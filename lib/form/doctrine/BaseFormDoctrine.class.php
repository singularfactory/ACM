<?php

/**
 * Project form base class.
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormBaseTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class BaseFormDoctrine extends ahBaseFormDoctrine {
	public function setup() {
		// Hide widgets
		unset($this['created_at'], $this['updated_at']);
		
		// Remove <br /> tag after labels and set custom tag
		$this->getWidgetSchema()->getFormFormatter()->setHelpFormat('<p class="input_help">%help%</p>');
		
		// Change default errors formatter
		$this->getWidgetSchema()->getFormFormatter()->setErrorRowFormatInARow('<p class="form_error_item">%error%</p>');
		$this->getWidgetSchema()->getFormFormatter()->setErrorListFormatInARow('<span class="form_error_list">%errors%</span>');
	}
}
