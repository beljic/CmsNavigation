<?php

/**
 * Created by PhpStorm.
 * User: Deki
 * Date: 5/29/15
 * Time: 7:27 AM
 */
class MageD_CmsNavigation_Varien_Data_Form_Element_Hierarchy extends Varien_Data_Form_Element_Abstract
{
    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
        $this->setType('label');
    }

    public function getElementHtml()
    {

        $html = $this->getEscapedValue();
        $html .= $this->getAfterElementHtml();

        $hierarchyMenu = new Varien_Data_Tree_Node(array(), 'root', new Varien_Data_Tree());

        /*TODO create html*/
        return $html;
    }

    public function getLabelHtml($idSuffix = '')
    {
        if (!is_null($this->getLabel())) {
            $html = '<label for="' . $this->getHtmlId() . $idSuffix . '" style="' . $this->getLabelStyle() . '">' . $this->getLabel()
                . ($this->getRequired() ? ' <span class="required">*</span>' : '') . '</label>' . "\n";
        } else {
            $html = '';
        }
        return $html;
    }
}