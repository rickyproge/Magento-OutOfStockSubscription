<?php

/**
 * Out of Stock Subscription index controller
 *
 * @category    BusinessKing
 * @package     BusinessKing_OutofStockSubscription
 */
class BusinessKing_OutofStockSubscription_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{ 
		$productId = $this->getRequest()->getPost('product');
		
		$superAttribute = $this->getRequest()->getPost('super_attribute');
				
		$email = $this->getRequest()->getPost('subscription_email');
		if ($email && $productId) {

						
			$product = Mage::getModel('catalog/product')->load($productId);
			
			if($product->isConfigurable() && $superAttribute) {
				$childProduct = Mage::getModel('catalog/product_type_configurable')->getProductByAttributes($superAttribute, $product);
				$productId = $childProduct->getId();
			}
			
			Mage::getModel('outofstocksubscription/info')->saveSubscrition($productId, $email);
			$this->_getSession()->addSuccess($this->__('Subscription added successfully.'));
			
			//$product->getProductUrl();
			$url = $product->getData('url_path');
			//$this->_redirect('catalog/product/view', array('id'=>$productId));
			$this->_redirect($url);
		}
		else {
			$this->_redirect('');
		}		
	}
	
    protected function _getSession()
    {
        return Mage::getSingleton('checkout/session');
    }
}