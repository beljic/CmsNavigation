<?php
/**
 * MageD
 *
 * @category     MageD
 * @package      MageD_Catalog
 *
 * @author    Dejan Beljic <beljic@gmail.com>
 * @copyright Copyright (c) 2015 MageD (www.magento3.com)
 *
 */
class MageD_CmsNavigation_Model_Observer_Cms
{

    /**
     * Add parent field to form
     *
     * @param Varien_Event_Observer $observer
     *
     * @return void
     */
    public function prepareForm(Varien_Event_Observer $observer)
    {
        $form = $observer->getEvent()->getForm();

        $fieldset = $form->addFieldset(
            'parent_node_fieldset',
            array(
                'legend' => 'Page navigation',
                'class' => 'fieldset-wide'
            )
        );

        //Choose parent
        $fieldset->addField('parent_node_id', 'select', array(
            'name' => 'parent_node_id',
            'label' => 'Parent',
            'values' => Mage::getModel('maged_cmsnavigation/category_attribute_source_page')->getAllOptions(),
            'title' => 'Parent'
        ));

        //Display hierarchy tree
        //http://excellencemagentoblog.com/blog/2011/11/02/magento-admin-form-field/
        //http://stackoverflow.com/questions/1993597/adding-a-custom-form-element-to-an-adminhtml-form

        //Here is what is interesting us
        //We add a new type, our type, to the fieldset
        //We call it extended_label
        $fieldset->addType('hierarchy','MageD_CmsNavigation_Varien_Data_Form_Element_Hierarchy');

        $fieldset->addField('hierarchy_element', 'hierarchy', array(
            'label'         => 'Hierarchy',
            'name'          => 'hierarchy_element',
            'required'      => false,
            'value'     => '123',
            'bold'      =>  true,
           // 'label_style'   =>  'font-weight: bold;color:red;',
        ));
    }


    /**
     * Adds CMS hierarchy menu item to top menu
     *
     * @param Varien_Event_Observer $observer
     */
    public function addCmsToTopmenuItems(Varien_Event_Observer $observer)
    {

        /**
         * @var $topMenuRootNode Varien_Data_Tree_Node
         */
        $topMenuRootNode = $observer->getMenu();

        //  $cmsPages = Mage::getModel('cms/page')->getCollection();
        $cmsPages = Mage::getResourceModel('cms/page_collection');
        //$nodes = $hierarchyModel->getNodesData();
        $tree = $topMenuRootNode->getTree();

        $nodesFlatList = array(
            $topMenuRootNode->getId() => $topMenuRootNode
        );

        //$nodeModel = Mage::getModel('enterprise_cms/hierarchy_node');
        $cmsPageModel = Mage::getModel('cms/page');

        foreach ($cmsPages as $cmsPage) {
            //$parentNode = null;
            $cmsPageData = $cmsPageModel->load($cmsPage->getId());

            //check if CMS goes to root
            if ($cmsPageData->getParentNodeId()) {

                if (($cmsPageData->getParentNodeId() == MageD_CmsNavigation_Helper_Data::ROOT_NAVIGATION_IDENTIFIER)) {
                    $parentNodeId = $topMenuRootNode->getId();
                    $parentNode = isset($nodesFlatList[$parentNodeId]) ? $nodesFlatList[$parentNodeId] : null;
                } else {
                    foreach ($topMenuRootNode->getAllChildNodes() as $fl) {
                        if ($fl['id'] == 'category-node-' . $cmsPageData->getParentNodeId()) {
                            $parentNode = $fl;
                        }
                        if ($fl['id'] == $cmsPageData->getParentNodeId()) {
                            $parentNode = $fl;
                        }
                    }
                }
                $menuNodeId = 'cms-node-' . $cmsPage->getId();

                $menuNodeData = array(
                    'name' => $cmsPageData->getData('title'),
                    'id' => $cmsPageData->getData('identifier'),
                    'url' => Mage::getBaseUrl() . $cmsPageData->getData('identifier'),
                    'is_active' => 1
                );

                $menuNode = new Varien_Data_Tree_Node($menuNodeData, 'id', $tree, $parentNode);
                if ($parentNode) {
                    $parentNode->addChild($menuNode);
                } else {
                    Mage::log('CMS Page: ' . $cmsPageData->getData('identifier') . '. Parent node not found in menu: ' . $cmsPageData->getParentNodeId() . '.');
                }

                $nodesFlatList[$menuNodeId] = $menuNode;
            }
        }

        return;
    }


}