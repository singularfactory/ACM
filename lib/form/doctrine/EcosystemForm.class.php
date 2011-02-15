<?php

/**
 * Ecosystem form.
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EcosystemForm extends BaseEcosystemForm
{
  public function configure()
  {
	$this->useFields(array(
		'id',
		'name',
		'city',
		'province_id',
		'lanscape_picture',
	));
	
	$this->setWidget('lanscape_picture', new sfWidgetFormInputFile());
	
	$this->setValidator('lanscape_picture', new sfValidatorFile(array('path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_ecosystem_pictures_directory'), 'required' => false)));
  }
}
