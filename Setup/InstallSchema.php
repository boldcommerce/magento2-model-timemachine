<?php

namespace Bold\ModelTimemachine\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @inheritDoc
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (!$setup->tableExists('model_timemachine_actions')) {
            $this->createModelTimemachineTable($setup);
        }

        $setup->endSetup();
    }

    private function createModelTimemachineTable(SchemaSetupInterface $setup)
    {
        $connection = $setup->getConnection();
        $table = $connection->newTable($setup->getTable('model_timemachine_action'));

        $table->addColumn(
            'entity_id',
            Table::TYPE_INTEGER,
            null,
            [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary'  => true,
            ],
            'Entity ID'
        );

        $table->addColumn(
            'type',
            Table::TYPE_TEXT,
            255,
            [
                'nullable' => false,
            ],
            'Type'
        );

        $table->addColumn(
            'type_id',
            Table::TYPE_INTEGER,
            255,
            [
                'unsigned' => true,
                'nullable' => false,
            ],
            'Type ID'
        );

        $table->addColumn(
            'sequence',
            Table::TYPE_INTEGER,
            255,
            [
                'nullable' => false,
            ],
            'Sequence'
        );

        $table->addColumn(
            'operation',
            Table::TYPE_TEXT,
            null,
            [
                'nullable' => false,
            ],
            'Model'
        );

        $table->addColumn(
            'origin',
            Table::TYPE_TEXT,
            null,
            [
                'nullable' => false,
            ],
            'Origin'
        );

        $table->addColumn(
            'code_path',
            Table::TYPE_TEXT,
            null,
            [
                'nullable' => false,
            ],
            'Origin'
        );

        $table->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
            'Created At'
        );

        $table->addIndex(
            $setup->getIdxName(
                'model_timemachine_actions',
                ['type', 'type_id', 'sequence'],
                AdapterInterface::INDEX_TYPE_UNIQUE
            ),
            ['type', 'type_id', 'sequence'],
            ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
        );

        $connection->createTable($table);
    }
}
