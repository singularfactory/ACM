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
		
		$this->widgetSchema->setLabel('first_name', 'Name');
		$this->widgetSchema->setLabel('last_name', 'Surname');
		$this->widgetSchema->setLabel('email_address', 'Email');
	}
}
