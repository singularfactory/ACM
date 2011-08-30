<?php

/**
 * sfGuardUser form.
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardUserForm extends PluginsfGuardUserForm {
	
  public function configure() {
		// Configure password management
		$this->setWidget('password', new sfWidgetFormInputPassword());
		$this->setValidator('password', new sfValidatorString(array('max_length' => 128, 'required' => false)));
		
		$this->setWidget('password_again', new sfWidgetFormInputPassword());
		$this->setValidator('password_again', new sfValidatorString(array('max_length' => 128, 'required' => false)));
		$this->validatorSchema->setPostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_again'));
		
		// Configure avatar management
		$this->setWidget('avatar', new sfWidgetFormInputFileEditable(array(
			'file_src' => '',
			'edit_mode' => false,
			'is_image' => true,
		)));
		$this->setValidator('avatar', new sfValidatorFile(array(
			'max_size' => sfConfig::get('app_max_picture_size'),
			'mime_types' => sfConfig::get('app_image_mime_types'),
			'path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_avatar_dir'),
			'validated_file_class' => 'myAvatarFile',
			'required' => false,
		)));
		
		// Configure authentication token management
		$this->setWidget('token', new sfWidgetFormInputHidden());
	
		$this->useFields(array('first_name', 'last_name', 'email_address', 'username', 'password', 'password_again', 'avatar', 'token', 'notify_new_order', 'notify_ready_order'));

		$this->widgetSchema->setLabel('first_name', 'Name');
		$this->widgetSchema->setLabel('last_name', 'Surname');
		$this->widgetSchema->setLabel('email_address', 'Email');
		$this->widgetSchema->setLabel('password_again', 'Password again');
		$this->widgetSchema->setLabel('avatar', 'Profile picture');
		$this->widgetSchema->setLabel('token', 'Authentication token');
		$this->widgetSchema->setLabel('notify_new_order', 'A new purchase order arrives');
		$this->widgetSchema->setLabel('notify_ready_order', 'A purchase order is ready to deliver');
	
		$this->widgetSchema->setHelp('first_name', 'Your name');
		$this->widgetSchema->setHelp('last_name', 'Your last name');
		$this->widgetSchema->setHelp('email_address', 'Your email address');
		$this->widgetSchema->setHelp('username', 'A name to identiy yourself in the application');
		$this->widgetSchema->setHelp('password', 'Leave it blank if you do not want to update it');
		$this->widgetSchema->setHelp('password_again', 'Your password again in case you want to update it');
		$this->widgetSchema->setHelp('avatar', 'A picture of you. Try to choose a square image, e.g. 75x75');
	
		// Remove <br /> tag after labels and set custom tag
		$this->getWidgetSchema()->getFormFormatter()->setHelpFormat('<p class="input_help">%help%</p>');
  }
}
