<?php
namespace Bold\ModelTimemachine\Model\ResourceModel\Action;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Bold\ModelTimemachine\Model\Action;
use Bold\ModelTimemachine\Model\ResourceModel\Action as ActionResource;

/**
 * Class Collection
 *
 * @package Bold\ModelTimemachine\Model\ResourceModel\Action
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'action_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            Action::class,
            ActionResource::class
        );
    }
}
