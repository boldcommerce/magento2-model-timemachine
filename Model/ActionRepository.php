<?php

namespace Bold\ModelTimemachine\Model;

use Bold\ModelTimemachine\Api\ActionRepositoryInterface;
use Bold\ModelTimemachine\Api\Data;
use Bold\ModelTimemachine\Api\Data\ActionInterface;
use Bold\ModelTimemachine\Api\Data\ActionSearchResultsInterfaceFactory;
use Bold\ModelTimemachine\Api\Data\ActionInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Bold\ModelTimemachine\Model\ResourceModel\Action as ResourceAction;
use Bold\ModelTimemachine\Model\ResourceModel\Action\CollectionFactory as ActionCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\ExtensibleDataObjectConverter;

/**
 * Class ActionRepository
 *
 * @package Bold\ModelTimemachine\Model
 */
class ActionRepository implements ActionRepositoryInterface
{
    /**
     * @var ResourceAction
     */
    protected $resource;

    /**
     * @var ActionFactory
     */
    protected $actionFactory;

    /**
     * @var ActionCollectionFactory
     */
    protected $actionCollectionFactory;

    /**
     * @var ActionSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var ActionInterfaceFactory
     */
    protected $dataActionFactory;

    /**
     * @var JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var ExtensibleDataObjectConverter
     */
    protected $extensibleDataObjectConverter;

    public function __construct(
        ResourceAction $resource,
        ActionFactory $actionFactory,
        ActionInterfaceFactory $dataActionFactory,
        ActionCollectionFactory $actionCollectionFactory,
        ActionSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->actionFactory = $actionFactory;
        $this->actionCollectionFactory = $actionCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataActionFactory = $dataActionFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        ActionInterface $action
    ) {
        $actionData = $this->extensibleDataObjectConverter->toNestedArray(
            $action,
            [],
            ActionInterface::class
        );

        $actionModel = $this->actionFactory->create()->setData($actionData);

        try {
            $this->resource->save($actionModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the action: %1',
                $exception->getMessage()
            ));
        }
        return $actionModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($actionId)
    {
        $action = $this->actionFactory->create();
        $this->resource->load($action, $actionId);
        if (!$action->getId()) {
            throw new NoSuchEntityException(__('Action with id "%1" does not exist.', $actionId));
        }
        return $action->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        SearchCriteriaInterface $criteria
    ) {
        $collection = $this->actionCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            ActionInterface::class
        );

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ActionInterface $action) {
        try {
            $actionModel = $this->actionFactory->create();
            $this->resource->load($actionModel, $action->getActionId());
            $this->resource->delete($actionModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Action: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($actionId)
    {
        return $this->delete($this->get($actionId));
    }

    /**
     * @inheritDoc
     */
    public function getNextSequence(Data\ActionInterface $entity): int
    {
        $connection = $this->resource->getConnection();
        $select = $connection->select()
            ->from(
                $this->resource->getMainTable(),
                'max(`sequence`)'
            )
            ->where('type = ?', $entity->getType())
            ->where('type_id = ?', $entity->getTypeId())
        ;

        return ($connection->fetchOne($select) ?? 0) + 1;
    }
}
