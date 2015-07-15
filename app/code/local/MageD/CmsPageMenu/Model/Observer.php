<?php

/**
 * MageD
 *
 * MageD_CmsPageMenu
 *
 * adds Menu attributes
 *
 * @category     MageD
 * @package      MageD_CmsPageMenu
 *
 * @author    Dejan Beljic <beljic@gmail.com>
 * @copyright Copyright (c) 2015 MageD (www.magento3.com)
 */
class MageD_CmsPageMenu_Model_Observer
{	
	/**
     * addMenuAttributes
     *
     * @param Varien_Event_Observer $observer
     * @return void
     */
	public function addMenuAttributes(Varien_Event_Observer $observer)
	{
        $observer->getSelect()->columns(
            array('cms_page', 'url_key')
        );
	}
}