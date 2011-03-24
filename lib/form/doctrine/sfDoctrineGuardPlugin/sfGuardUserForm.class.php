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
	$this->setWidget('password', new sfWidgetFormInputPassword());
	$this->setValidator('password', new sfValidatorString(array('max_length' => 128, 'required' => false)));
	$this->setWidget('password_again', new sfWidgetFormInputPassword());
	$this->setValidator('password_again', new sfValidatorString(array('max_length' => 128, 'required' => false)));
	$this->validatorSchema->setPostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_again'));
	
	
	$this->useFields(array('first_name', 'last_name', 'email_address', 'username', 'password', 'password_again'));

	$this->widgetSchema->setLabel('first_name', 'Name');
	$this->widgetSchema->setLabel('last_name', 'Surname');
	$this->widgetSchema->setLabel('email_address', 'Email');
	$this->widgetSchema->setLabel('password_again', 'Password again');
	
	$this->widgetSchema->setHelp('first_name', 'Your name');
	$this->widgetSchema->setHelp('last_name', 'Your last name');
	$this->widgetSchema->setHelp('email_address', 'Your email address');
	$this->widgetSchema->setHelp('username', 'A name to identiy yourself in the application');
	$this->widgetSchema->setHelp('password', 'Leave it blank if you do not want to update it');
	$this->widgetSchema->setHelp('password_again', 'Your password again in case you want to update it');
	
	// Remove <br /> tag after labels and set custom tag
	$this->getWidgetSchema()->getFormFormatter()->setHelpFormat('<p class="input_help">%help%</p>');
  }
}
