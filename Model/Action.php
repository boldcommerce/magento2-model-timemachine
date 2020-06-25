<?php

namespace Bold\ModelTimemachine\Model;

use Bold\ModelTimemachine\Api\Data\ActionInterface;
use Bold\ModelTimemachine\Api\Data\ActionInterfaceFactory;
use Bold\ModelTimemachine\Model\ResourceModel\Action\Collection;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;

/**
 * Class Action
 *
 * @package Bold\ModelTimemachine\Model
 */
class Action extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @var ActionInterfaceFactory
     */
    protected $actionDataFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var string
     */
    protected $_eventPrefix = 'Bold_modeltimemachine_action';

    public function __construct(
        Context $context,
        Registry $registry,
        ActionInterfaceFactory $actionDataFactory,
        DataObjectHelper $dataObjectHelper,
        ResourceModel\Action $resource,
        Collection $resourceCollection,
        array $data = []
    ) {
        $this->actionDataFactory = $actionDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve action model with action data
     * @return ActionInterface
     */
    public function getDataModel()
    {
        $actionData = $this->getData();

        $actionDataObject = $this->actionDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $actionDataObject,
            $actionData,
            ActionInterface::class
        );

        return $actionDataObject;
    }
}
