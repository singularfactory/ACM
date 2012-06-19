<?php
/**
 * Form class
 *
 * acm : Algae Culture Management (https://github.com/singularfactory/ACM)
 * Copyright 2012, Singular Factory <info@singularfactory.com>
 *
 * This file is part of ACM
 *
 * ACM is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ACM is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ACM.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright     Copyright 2012, Singular Factory <info@singularfactory.com>
 * @package       ACM.Lib.Form
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */


/**
 * Custom sfGuardUserAdminForm for admin generators
 *
 * @package    sfDoctrineGuardPlugin
 */
class sfGuardUserAdminForm extends BasesfGuardUserAdminForm {

	public function configure() {
		unset($this['permissions_list']);

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
