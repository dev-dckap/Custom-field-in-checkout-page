<?php
/**
* *
*  @author DCKAP Team
*  @copyright Copyright (c) 2018 DCKAP (https://www.dckap.com)
*  @package Dckap_CustomFields
*/

namespace Dckap\CustomFields\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
* Class InstallSchema
* @package Dckap\CustomFields\Setup
*/
class InstallSchema implements InstallSchemaInterface
{

   /**
    * {@inheritdoc}
    * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
    */
   public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
   {
       $installer = $setup;

       $installer->startSetup();

       /* While module install, creates columns in quote_address and sales_order_address table */

       $eavTable1 = $installer->getTable('quote');
       $eavTable2 = $installer->getTable('sales_order');

       $columns = [
           'input_custom_shipping_field' => [
               'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
               'nullable' => true,
               'comment' => 'Input option',
           ],

           'date_custom_shipping_field' => [
               'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
               'nullable' => true,
               'comment' => 'Date Ui component',
           ],

           'select_custom_shipping_field' => [
               'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
               'nullable' => true,
               'comment' => 'Select option',
           ],
       ];

       $connection = $installer->getConnection();
       foreach ($columns as $name => $definition) {
          $connection->addColumn($eavTable1, $name, $definition);
          $connection->addColumn($eavTable2, $name, $definition);
       }
       $installer->endSetup();
   }
}
