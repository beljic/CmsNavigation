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
class MageD_CmsPageMenu_Model_Rewrite_Catalog_Observer extends Mage_Catalog_Model_Observer
{

    /**
     * Recursively adds categories to top menu
     *
     * @param Varien_Data_Tree_Node_Collection|array $categories
     * @param Varien_Data_Tree_Node $parentCategoryNode
     * @param Mage_Page_Block_Html_Topmenu $menuBlock
     * @param bool $addTags
     */
    protected function _addCategoriesToMenu($categories, $parentCategoryNode, $menuBlock, $addTags = false)
    {
        $categoryModel = Mage::getModel('catalog/category');
        foreach ($categories as $category) {
            if (!$category->getIsActive()) {
                continue;
            }

            $nodeId = 'category-node-' . $category->getId();

            $categoryModel->setId($category->getId());
            if ($addTags) {
                $menuBlock->addModelTags($categoryModel);
            }

            //check if there is a cms page set in category
            if($category->getCmsPage()) {
                $categoryUrl = Mage::helper('cms/page')->getPageUrl( $category->getCmsPage());
            }
            else {
                $categoryUrl =  Mage::helper('catalog/category')->getCategoryUrl($category);
            }

            $tree = $parentCategoryNode->getTree();
            $categoryData = array(
                'name' => $category->getName(),
                'id' => $nodeId,
                'url' => $categoryUrl,
                'is_active' => $this->_isActiveMenuCategory($category)
            );
            $categoryNode = new Varien_Data_Tree_Node($categoryData, 'id', $tree, $parentCategoryNode);
            $parentCategoryNode->addChild($categoryNode);

            $flatHelper = Mage::helper('catalog/category_flat');
            if ($flatHelper->isEnabled() && $flatHelper->isBuilt(true)) {
                $subcategories = (array)$category->getChildrenNodes();
            } else {
                $subcategories = $category->getChildren();
            }

            $this->_addCategoriesToMenu($subcategories, $categoryNode, $menuBlock, $addTags);
        }
    }

}
		