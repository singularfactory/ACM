<?php

/**
* Label form class.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    2011-10-25
*/
class LabelForm extends BaseForm {
	
	protected static $products = array(
		'strain' => 'Strain',
	);
		
	public function configure() {
		$this->setWidgets(array(
			'product_type'		=> new sfWidgetFormChoice(array('choices' => self::$products)),
			'product_id'			=> new sfWidgetFormInputHidden(),
			'supervisor'			=> new sfWidgetFormInputText(),
			'all_products'		=> new sfWidgetFormInputCheckbox(),
			
			// Strain attributes
			'culture_medium_id'	=> new sfWidgetFormDoctrineChoice(array('model' => 'CultureMedium', 'add_empty' => true)),
			'transfer_interval'	=> new sfWidgetFormInputText(),
		));

		$this->setValidators(array(
			'product_type'	=> new sfValidatorChoice(array('choices' => array_keys(self::$products), 'required' => false)),
			'product_id'		=> new sfValidatorInteger(array('required' => true)),
			'supervisor'		=> new sfValidatorString(array('max_length' => 5, 'required' => false, 'trim' => true)),
			'all_products'	=> new sfValidatorBoolean(array('required' => false)),
			
			// Strain attributes
			'culture_medium_id' => new sfValidatorDoctrineChoice(array('model' => 'CultureMedium')),
			'transfer_interval' => new sfValidatorInteger(array('required' => false, 'trim' => true)),
		));

		$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
		
		$this->widgetSchema->setLabels(array(
			'product_type'	=> 'Product type',
			'product_id'		=> 'Product code',
			'supervisor'		=> 'Supervisor',
			'all_products'	=> 'Create labels for every product',
			
			// Strain attributes
			'culture_medium_id' => 'Culture medium',
			'transfer_interval' => 'Transfer interval',
		));
		
		$this->widgetSchema->setHelps(array(
			'product_type'	=> 'Choose the product to create labels for',
			'product_id'		=> '',
			'supervisor'		=> 'Alias of the supervisor that will appear in the label (5 characters maximum)',
			'all_products'	=> null,
			
			// Strain attributes
			'culture_medium_id' => 'Choose the culture medium that will appear in the label',
			'transfer_interval'=> 'Overrides the transfer interval specified for the strain',
		));
		
		$this->setup();
	}

}
