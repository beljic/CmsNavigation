<?php
/**
 * MageD
 *
 * MageD_CmsNavigation
 *
 * Returns categories and cms pages
 *
 * @category MageD
 * @package MageD_CmsNavigation
* @author beljic@gmail.com
 */
class MageD_CmsNavigation_Model_Category_Attribute_Source_Page extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    public function getAllOptions()
    {
        if (!$this->_options) {
            $pages = Mage::getResourceModel('cms/page_collection')
                ->load()
                ->toOptionArray();
            $categories = $this->getCategoriesArray();
            $this->_options = array_merge($pages, $categories);

            array_unshift($this->_options, array('value'=> MageD_CmsNavigation_Helper_Data::ROOT_NAVIGATION_IDENTIFIER, 'label'=>Mage::helper('catalog')->__('Root')));
            array_unshift($this->_options, array('value'=>'', 'label'=>Mage::helper('catalog')->__('Please select a CMS page or Category ...')));

        }
        return $this->_options;
    }

    public function getCategoriesArray() {

        $categoriesArray = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSort('path', 'asc')
            ->load()
            ->toArray();

        $categories = array();
        foreach ($categoriesArray as $categoryId => $category) {
            if (isset($category['name']) && isset($category['level'])) {
                $categories[] = array(
                    'label' => $category['name'],
                    'level'  =>$category['level'],
                    'value' => $categoryId
                );
            }
        }

        return $categories;
    }

}
