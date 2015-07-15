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
        //  $html = $this->getBold() ? '<strong>' : '';
        $html = $this->getEscapedValue();
        //  $html.= $this->getBold() ? '</strong>' : '';
        $html .= $this->getAfterElementHtml();

     /*   $pages = Mage::getResourceModel('cms/page_collection')
            ->load()
            ->toOptionArray();
*/
        //foreach($pages as $p) {
        //  $html .= print_r($p['value'], true);

        $hierarchyMenu = new Varien_Data_Tree_Node(array(), 'root', new Varien_Data_Tree());
       // Zend_Debug::dump($hierarchyMenu);
        foreach($hierarchyMenu as $h) {
     //       $html .= Zend_Debug::dump($h);
        }

       // $topMenu = $this->getLayout()->createBlock('page_html/topmenu');
      //  $html .= $topMenu;

        $html .= '<style>#nestedlist, #nestedlist ul {
                    font-family: Verdana, Arial, Helvetica, sans-serif;
                    list-style-type: none;
                     margin-left:0;
                     padding-left:30px;
                    text-indent: -5px;
                    }</style>';

        $html .= '<ul id="nestedlist">
    <li><a href="#">Gadgets and Gizmos</a>
    <ul>
        <li><a href="#">Gadgets</a>
        <ul>
            <li><a href="#">Inspector Gadget </a></li>
            <li><a href="#">Gadget Hackwrench</a></li>
            <li><a href="#">Gadget Galaxy</a></li>
            <li><a href="#">Daily Gadget </a></li>
            <li><a href="#">Cheese Gadgets</a>
            <ul>
                <li><a href="#">Bleu</a></li>
                <li><a href="#">Swiss</a></li>
                <li><a href="#">Havardi</a></li>
            </ul>
            </li>
        </ul>
        </li>
        <li><a href="#">Gizmos</a>
        <ul>
            <li><a href="#">Gizmo the Mogwai</a></li>
            <li><a href="#">The Transform Gizmo</a></li>
            <li><a href="#">Gizmondo</a></li>
        </ul>
        </li>
    </ul>
    </li>
</ul>';
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