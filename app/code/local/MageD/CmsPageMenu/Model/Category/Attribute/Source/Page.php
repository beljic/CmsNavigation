<?php
/**
 * MageD
 *
 * MageD_CmsPageMenu
 *
 * Returns page collection as options
 *
 * @category     MageD
 * @package      MageD_CmsPageMenu
 *
 * @author    Dejan Beljic <beljic@gmail.com>
 * @copyright Copyright (c) 2015 MageD (www.magento3.com)
 */
class MageD_CmsPageMenu_Model_Category_Attribute_Source_Page extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    public function getAllOptions()
    {
        if ($this->_options === false) {
            $this->_options = Mage::getResourceModel('cms/page_collection')
                ->load()
                ->toOptionArray();
            array_unshift($this->_options, array('value'=>'', 'label'=>Mage::helper('catalog')->__('Please select a CMS page ...')));
        }
        return $this->_options;
    }
}
