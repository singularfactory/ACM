<?php

/**
* Authority form base class.
*
* @method Authority getObject() Returns the current form's model object
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
*/
class LabelForm extends BaseForm {
	
	protected static $products = array(
		'sample' => 'Sample',
		'strain' => 'Strain',
		'dna_extraction' => 'DNA extraction',
		'culture_medium' => 'Culture medium',
		'patent_deposit' => 'Patent deposit',
		'maintenance_deposit' => 'Maintenance deposit',
		'isolation' => 'Isolation',
		'project' => 'Project',
	);
	
	public function setup() {
		// Remove <br /> tag after labels and set custom tag
		$this->getWidgetSchema()->getFormFormatter()->setHelpFormat('<p class="input_help">%help%</p>');
		
		// Change default errors formatter
		$this->getWidgetSchema()->getFormFormatter()->setErrorListFormatInARow('%errors%');
		$this->getWidgetSchema()->getFormFormatter()->setErrorRowFormatInARow('<span class="input_error">%error%</span>');
		
		parent::setup();
	}
	
	public function configure() {		
		$this->setWidgets(array(
			'product' => new sfWidgetFormSelect(array('choices' => self::$products)),
			'all_products' => new sfWidgetFormInputCheckbox(),
			'code' => new sfWidgetFormInputHidden(),
			'supervisor' => new sfWidgetFormInputText(),
			'transfer_interval' => new sfWidgetFormInputText(),
		));

		$this->setValidators(array(
			'product' => new sfValidatorChoice(array('choices' => self::$products, 'required' => true)),
			'transfer_interval' => new sfValidatorInteger(array('required' => false)),
		));

		$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
		
		$this->widgetSchema->setLabels(array(
			'product' => 'Product type',
			'code' => 'Code',
			'all_products' => 'Create labels for every product',
		));
		
		$this->widgetSchema->setHelp('supervisor', 'Name of the supervisor that will appear in the label');
		$this->widgetSchema->setHelp('transfer_interval', 'Overrides the interval specified for the product');
		
		$this->setup();
	}

}
