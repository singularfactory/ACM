<?php

/**
* PurchaseOrder form.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class PurchaseOrderForm extends BasePurchaseOrderForm {

	public function configure() {
		$this->setWidget('customer', new sfWidgetFormInputText());
		
		$this->setWidget('status', new sfWidgetFormChoice(array(
			'choices' => array(
				sfConfig::get('app_purchase_order_pending') => 'pending',
				sfConfig::get('app_purchase_order_processing') => 'processing',
				sfConfig::get('app_purchase_order_ready') => 'ready',
				sfConfig::get('app_purchase_order_sent') => 'sent',
				sfConfig::get('app_purchase_order_canceled') => 'canceled',
				sfConfig::get('app_purchase_order_refunded') => 'refunded',
		))));
		
		$this->setValidator('status', new sfValidatorChoice(array(
			'choices' => array(
				sfConfig::get('app_purchase_order_pending'),
				sfConfig::get('app_purchase_order_processing'),
				sfConfig::get('app_purchase_order_ready'),
				sfConfig::get('app_purchase_order_sent'),
				sfConfig::get('app_purchase_order_canceled'),
				sfConfig::get('app_purchase_order_refunded'),),
			'required' => false)
		));

		$this->widgetSchema->setHelp('code', 'Purchase code assigned after payment');
		$this->widgetSchema->setHelp('status', 'Status of this purchase order');
	}
	
}
