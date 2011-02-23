<?php

/**
 * EcosystemPicture form.
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EcosystemPictureForm extends BaseEcosystemPictureForm
{
  public function configure()
  {
	$this->useFields(array('filename'));
	
	$this->setWidget('filename', new sfWidgetFormInputFile());
	$this->setValidator('filename', new sfValidatorFile(array(
		'mime_types' => 'web_images',
		'path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_ecosystem_pictures_directory'),
	)));
  }
}
