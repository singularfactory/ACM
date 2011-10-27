<?php

/**
 * Base project form.
 * 
 * @package    bna_green_house
 * @subpackage form
 * @author     Your name here 
 * @version    SVN: $Id: BaseForm.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 */
class BaseForm extends sfFormSymfony {

	public function setup() {
		parent::setup();
		
		// Remove <br /> tag after labels and set custom tag
		$this->getWidgetSchema()->getFormFormatter()->setHelpFormat('<p class="input_help">%help%</p>');
		
		// Change default errors formatter
		$this->getWidgetSchema()->getFormFormatter()->setErrorListFormatInARow('%errors%');
		$this->getWidgetSchema()->getFormFormatter()->setErrorRowFormatInARow('<span class="input_error">%error%</span>');
	}
	
}
