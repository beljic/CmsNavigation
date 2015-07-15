<?php
/**
 * MageD
 *
 * @category     MageD
 * @package      MageD_Catalog
 *
 * Installer ads new column to cms page table
 *
 * @author    Dejan Beljic <beljic@gmail.com>
 * @copyright Copyright (c) 2015 MageD (www.magento3.com)
 */
$installer = $this;

$installer->startSetup();

$installer->run('
  ALTER TABLE cms_page ADD  parent_node_id VARCHAR(255) NULL;
');

$installer->endSetup();
	 