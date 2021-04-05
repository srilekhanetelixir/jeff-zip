<?php
namespace Jeff\SimpleNews\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface {
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) {
        $installer = $setup;

        $installer->startSetup();

        $tableName = $installer->getTable('tutorial_simplenews');

        if($installer->getConnection()->isTableExists($tableName) != true) {
            $table = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'title',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Title'
                )
                ->addColumn(
                    'summary',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Summary'
                )
                ->addColumn(
                    'description',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Description'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_DATETIME,
                    null,
                    ['nullable' => false],
                    'Created At'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '0'],
                    'Status'
                )
				->addColumn(
                    'pricerange',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'pricerange'
                )
                ->addColumn(
                    'feedprice',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'feedprice'
                )
               ->addColumn(
                    'product_categories',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'product_categories'
                )
               ->addColumn(
                    'feed_csv',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'feed_csv'
                )
               ->addColumn(
                    'feed_xml',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'feed_xml'
                )
               ->addColumn(
                    'contains_with',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'contains_with'
                )
               ->addColumn(
                    'pricevalue',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'pricevalue'
                )
               ->addColumn(
                    'upc',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'upc'
                )
               ->addColumn(
                    'begins_with',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'begins_with'
                )
               ->addColumn(
                    'ftype',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'ftype'
                )
               ->addColumn(
                    'brand',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'brand'
                )
                ->addColumn(
                    'file_name',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'file_name'
                )
                ->addColumn(
                    'mpn',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'mpn'
                )
                ->addColumn(
                    'gtin',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'gtin'
                )
                ->addColumn(
                    'condition',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'condition'
                )
                ->addColumn(
                    'product',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'product'
                )
                ->addColumn(
                    'iteration_limit',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'iteration_limit'
                )
                ->addColumn(
                    'content',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'content'
                )
                ->addColumn(
                    'created_time',
                    Table::TYPE_DATETIME,
                    null,
                    ['nullable' => false],
                    'created_time'
                )
                ->addColumn(
                    'update_time',
                    Table::TYPE_DATETIME,
                    null,
                    ['nullable' => false],
                    'update_time'
                )
                ->addColumn(
                    'stock_availability',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'stock_availability'
                )
                ->addColumn(
                    'stock_range',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'stock_range'
                )
                ->addColumn(
                    'stock_value',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'stock_value'
                )
                ->addColumn(
                    'shipweight',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'shipweight'
                )
                ->addColumn(
                    'customlabelzero',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'customlabelzero'
                )
                ->addColumn(
                    'color',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'color'
                )
                ->addColumn(
                    'adult',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'adult'
                )
                ->addColumn(
                    'gender',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'gender'
                )
                ->addColumn(
                    'size',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'size'
                )
                ->addColumn(
                    'material',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'material'
                )
                ->addColumn(
                    'pattern',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'pattern'
                )
                ->addColumn(
                    'tax',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'tax'
                )
                ->addColumn(
                    'adult',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'adult'
                )
                ->addColumn(
                    'item_group_id',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'item_group_id'
                )
                ->addColumn(
                    'cron',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'cron'
                )
                ->addColumn(
                    'cron_days',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'cron_days'
                )
                ->addColumn(
                    'cron_interval',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'cron_interval'
                )
                ->addColumn(
                    'preview_xml',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'preview_xml'
                )
                ->setComment('News Table')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}
