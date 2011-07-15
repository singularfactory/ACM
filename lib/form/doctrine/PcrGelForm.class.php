<?php

/**
 * PcrGel form.
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PcrGelForm extends BasePcrGelForm {
  public function configure() {
		$this->useFields(array('number', 'band', 'is_valid'));
		$this->setValidator('delete_object', new sfValidatorBoolean());
  }
}
