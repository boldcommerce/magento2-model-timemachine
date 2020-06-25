<?php
namespace Bold\ModelTimemachine\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Action
 *
 * @package Bold\ModelTimemachine\Model\ResourceModel
 */
class Action extends AbstractDb
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('model_timemachine_action', 'action_id');
    }
}
