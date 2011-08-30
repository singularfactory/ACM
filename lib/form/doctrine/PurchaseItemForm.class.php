<?php

/**
* PurchaseItem form.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class PurchaseItemForm extends BasePurchaseItemForm {

	public function configure() {
		unset($this['product'], $this['amount']);
		
		$this->setWidget('status', new sfWidgetFormChoice(array(
			'choices' => array(
				sfConfig::get('app_purchase_item_pending') => 'pending',
				sfConfig::get('app_purchase_item_processing') => 'processing',
				sfConfig::get('app_purchase_item_ready') => 'ready',
		))));
		
		$this->setValidator('status', new sfValidatorChoice(array(
			'choices' => array(
				sfConfig::get('app_purchase_item_pending'),
				sfConfig::get('app_purchase_item_processing'),
				sfConfig::get('app_purchase_item_ready'),
			'required' => false)
		)));
		
		$this->setWidget('purchase_order_id', new sfWidgetFormInputHidden());
		$this->setWidget('product_id', new sfWidgetFormInputHidden());
		
		$this->widgetSchema->setHelp('status', 'Status of this item');
	}
}
