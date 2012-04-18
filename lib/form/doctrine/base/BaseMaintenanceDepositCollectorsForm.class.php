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
 * MaintenanceDepositCollectors form base class.
 *
 * @method MaintenanceDepositCollectors getObject() Returns the current form's model object
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
abstract class BaseMaintenanceDepositCollectorsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'maintenance_deposit_id' => new sfWidgetFormInputHidden(),
      'collector_id'           => new sfWidgetFormInputHidden(),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'maintenance_deposit_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('maintenance_deposit_id')), 'empty_value' => $this->getObject()->get('maintenance_deposit_id'), 'required' => false)),
      'collector_id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('collector_id')), 'empty_value' => $this->getObject()->get('collector_id'), 'required' => false)),
      'created_at'             => new sfValidatorDateTime(),
      'updated_at'             => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('maintenance_deposit_collectors[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MaintenanceDepositCollectors';
  }

}
