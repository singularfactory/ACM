<?php

/**
 * LocationPicture form.
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LocationPictureForm extends BaseLocationPictureForm {
  public function configure() {
		$this->useFields(array('filename'));

		$this->setWidget('filename', new sfWidgetFormInputFileEditable(array(
			'file_src' => '',
			'edit_mode' => !$this->getObject()->isNew(),
			'is_image' => true,
			'delete_label' => 'delete',
			'template'  => '%input% <span>%delete% %delete_label%</span>',
		)));
	
		$this->setValidator('filename', new sfValidatorFile(array(
			'max_size' => sfConfig::get('app_max_picture_size'),
			'mime_types' => 'web_images',
			'path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_location_pictures_dir'),
			'validated_file_class' => 'sfCustomValidatedFile',
			'required' => false,
		)));
	
		$this->setValidator('delete_object', new sfValidatorBoolean());
  }
}
