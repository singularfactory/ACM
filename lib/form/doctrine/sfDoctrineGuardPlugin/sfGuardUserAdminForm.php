<?php

/**
* Custom sfGuardUserAdminForm for admin generators
*
* @package    sfDoctrineGuardPlugin
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
*/
class sfGuardUserAdminForm extends BasesfGuardUserAdminForm {
	
	public function configure() {
		unset($this['permissions_list'], $this['groups_list']);
		
		// Only superadministrators are allowed to set/unset the superadministrator flag
		if ( !sfContext::getInstance()->getUser()->isSuperAdmin() ) {
			unset($this['is_super_admin']);
		}
		else {
			$this->widgetSchema->setLabel('is_super_admin', 'Is super admin?');
		}
		
		// Configure notifications management
		$this->setWidget('notify_new_order', new sfWidgetFormInputCheckbox());
		$this->setWidget('notify_ready_order', new sfWidgetFormInputCheckbox());
		$this->setValidator('notify_new_order', new sfValidatorBoolean(array('required' => false)));
		$this->setValidator('notify_ready_order', new sfValidatorBoolean(array('required' => false)));
		
		// Configure authentication token management
		$this->setWidget('token', new sfWidgetFormInputHidden());
		$this->setValidator('token', new sfValidatorString(array('max_length' => 40, 'min_length' => 40, 'required' => false)));
		$this->validatorSchema->setPostValidator( new sfValidatorCallback(array('callback' => array($this, 'checkTokenValue'))));
		
		$this->widgetSchema->setLabel('first_name', 'Name');
		$this->widgetSchema->setLabel('last_name', 'Surname');
		$this->widgetSchema->setLabel('email_address', 'Email');
		$this->widgetSchema->setLabel('notify_new_order', 'A new purchase order arrives');
		$this->widgetSchema->setLabel('notify_ready_order', 'A purchase order is ready to deliver');
	}
	
	public function checkTokenValue($validator, $values) {
		if ( empty($values['token']) ) {
			$values['token'] = sha1($values['email_address'].rand(11111, 99999));
		}
		
		return $values;
	}
	
}
