<?php

/**
* CultureMedium form.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class CultureMediumForm extends BaseCultureMediumForm {

	public function configure() {
		$this->widgetSchema->setHelp('name', 'Name of this culture medium');
		$this->widgetSchema->setHelp('description', 'A detailed explanation of characteristics of this culture medium');
		$this->widgetSchema->setHelp('link', 'Links to external resources');
		$this->widgetSchema->setHelp('is_public', 'Whether the culture media must be shown in public catalog or not');
		$this->widgetSchema->setHelp('amount', 'Items in stock');
	}
}
