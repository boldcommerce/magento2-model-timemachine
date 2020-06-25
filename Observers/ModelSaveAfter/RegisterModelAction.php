<?php

namespace Bold\ModelTimemachine\Observers\ModelSaveAfter;

use Bold\ModelTimemachine\Config;
use Bold\ModelTimemachine\Service\CodePath;
use Bold\ModelTimemachine\Service\Origin;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\VersionControl\Metadata;
use Magento\Sales\Api\Data\CreditmemoInterface;
use Magento\Sales\Api\Data\InvoiceInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderItemInterface;
use Magento\Sales\Api\Data\ShipmentInterface;
use Magento\Sales\Model\Order;
use Bold\ModelTimemachine\Api\ActionRepositoryInterface;
use Bold\ModelTimemachine\Api\Data\ActionInterface;
use Bold\ModelTimemachine\Api\Data\ActionInterfaceFactory;

class RegisterModelAction implements ObserverInterface
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var ActionRepositoryInterface
     */
    private $repository;

    /**
     * @var ActionInterfaceFactory
     */
    private $actionFactory;

    /**
     * @var Origin
     */
    private $origin;

    /**
     * @var CodePath
     */
    private $codePath;

    /**
     * @var Metadata
     */
    private $metadata;

    /**
     * @var array
     */
    private $modelsToLog = [
        OrderInterface::class,
        InvoiceInterface::class,
        ShipmentInterface::class,
        OrderItemInterface::class,
        CreditmemoInterface::class,
    ];

    public function __construct(
        Config $config,
        ActionRepositoryInterface $repository,
        ActionInterfaceFactory $actionFactory,
        Origin $origin,
        CodePath $codePath,
        Metadata $metadata
    ) {
        $this->config = $config;
        $this->repository = $repository;
        $this->actionFactory = $actionFactory;
        $this->origin = $origin;
        $this->codePath = $codePath;
        $this->metadata = $metadata;
    }

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        if (!$this->config->isEnabled()) {
            return;
        }

        try {
            /** @var AbstractModel $model */
            $model = $observer->getData('object');

            $this->registerOperation($model);
        } catch (\Throwable $exception) {
            // Something went wrong.
        }
    }

    /**
     * @param AbstractModel $model
     * @return array|void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function registerOperation(AbstractModel $model)
    {
        if (!$this->logThis($model)) {
            return;
        }

        $data = $this->getDataArray($model, $model->getData());
        $origData = $this->getDataArray($model, $model->getOrigData() ?? []);

        ksort($data);
        ksort($origData);

        $operation = array_diff_assoc($data, $origData);
        $operation = $this->makeArrayFlat($operation);

        if (!$operation) {
            return;
        }

        /** @var ActionInterface $entity */
        $entity = $this->actionFactory->create();
        $entity->setType(get_class($model));
        $entity->setTypeId($model->getId());
        $entity->setOperation(json_encode($operation, JSON_PRETTY_PRINT));
        $entity->setSequence($this->repository->getNextSequence($entity));
        $entity->setOrigin($this->origin->calculate());
        $entity->setCodePath($this->codePath->calculate());

        $this->repository->save($entity);
    }

    private function logThis(AbstractModel $model)
    {
        foreach ($this->modelsToLog as $interface) {
            if ($model instanceof $interface) {
                return true;
            }
        }

        return false;
    }

    private function getDataArray(AbstractModel $model, array $data)
    {
        $metadata = $this->metadata->getFields($model);
        $data = array_intersect_key($data, $metadata);

        return $this->makeArrayFlat(array_merge($metadata, $data));
    }

    /**
     * @param array $data
     * @return array
     */
    private function makeArrayFlat(array $data): array
    {
        return array_filter($data, function ($item) {
            return !is_array($item) && !is_object($item);
        });
    }
}
