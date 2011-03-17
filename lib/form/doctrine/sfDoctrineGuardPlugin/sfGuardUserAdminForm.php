<?php

/**
 * Custom sfGuardUserAdminForm for admin generators
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 */
class sfGuardUserAdminForm extends BasesfGuardUserAdminForm
{
  public function configure()
  {
	unset($this['permissions_list']);
	
	$this->widgetSchema->setLabel('first_name', 'Name');
	$this->widgetSchema->setLabel('last_name', 'Surname');
	$this->widgetSchema->setLabel('email_address', 'Email');
	$this->widgetSchema->setLabel('is_super_admin', 'Is super admin?');
	
  }
}
