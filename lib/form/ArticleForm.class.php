<?php

/**
* Article form class.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    2011-10-25
*/
class ArticleForm extends BaseForm {
	
	public function configure() {
		$this->setWidgets(array(
			'strain_id'			=> new sfWidgetFormInputHidden(),
			'content'			=> new sfWidgetFormInputText(),
		));

		$this->setValidators(array(
			'strain_id'		=> new sfValidatorInteger(array('required' => true)),
			'content'		=> new sfValidatorString(array('max_length' => 5, 'required' => false, 'trim' => true)),
		));

		$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
		
		$this->widgetSchema->setLabels(array(
			'strain_id'		=> 'Strain code',
			'content'		=> 'Text',
		));
		
		$this->widgetSchema->setHelps(array(
			'strain_id'		=> '',
			'content'		=> 'Write the text body of the article',
		));
		
		$this->setup();
	}

}
