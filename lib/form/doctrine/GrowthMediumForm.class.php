<?php

/**
 * GrowthMedium form.
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GrowthMediumForm extends BaseGrowthMediumForm {
	public function configure() {
		$this->widgetSchema->setHelp('name', 'Name of this culture medium');
		$this->widgetSchema->setHelp('description', 'A detailed explanation of characteristics of this culture medium');
		$this->widgetSchema->setHelp('link', 'Links to external resources');
	}
}
