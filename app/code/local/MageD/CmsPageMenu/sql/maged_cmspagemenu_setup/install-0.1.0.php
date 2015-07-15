<?php
/**
 * MageD
 *
 * MageD_CmsPageMenu
 *
 * Installer ads new category attribute
 *
 * @category MageD
 * @package MageD_CmsPageMenu
 * @author beljic@gmail.com
 */
$installer = $this;
$installer->startSetup();

$entityTypeId = $installer->getEntityTypeId('catalog_category');

$installer->removeAttribute('catalog_category', 'cms_page'); // remove previous attribute definition

$installer->addAttribute('catalog_category', 'cms_page',  array(
    'type'     => 'varchar',
    'backend'  => '',
    'frontend' => '',
    'label'    => 'CMS page to redirect to',
    'input'    => 'select',
    'required'    => false,
    'class'    => '',
    'source'   => 'maged_cmspagemenu/category_attribute_source_page',
    'global'   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible'  => true,
    'system'   => false,
    'user_defined'  => true,
    'visible_on_front'  => true,
    'note'       => ''

));

$installer->addAttributeToGroup($entityTypeId, 3, 5, 'cms_page', '4');

$installer->endSetup();
	 