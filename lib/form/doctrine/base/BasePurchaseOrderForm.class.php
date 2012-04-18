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
 * PurchaseOrder form base class.
 *
 * @method PurchaseOrder getObject() Returns the current form's model object
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
abstract class BasePurchaseOrderForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'status'          => new sfWidgetFormChoice(array('choices' => array('pending' => 'pending', 'processing' => 'processing', 'ready' => 'ready'))),
      'code'            => new sfWidgetFormInputText(),
      'customer'        => new sfWidgetFormTextarea(),
      'remarks'         => new sfWidgetFormTextarea(),
      'activation_date' => new sfWidgetFormDateTime(),
      'delivery_date'   => new sfWidgetFormDateTime(),
      'delivery_code'   => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'status'          => new sfValidatorChoice(array('choices' => array(0 => 'pending', 1 => 'processing', 2 => 'ready'), 'required' => false)),
      'code'            => new sfValidatorString(array('max_length' => 40)),
      'customer'        => new sfValidatorString(array('max_length' => 512)),
      'remarks'         => new sfValidatorString(array('required' => false)),
      'activation_date' => new sfValidatorDateTime(array('required' => false)),
      'delivery_date'   => new sfValidatorDateTime(array('required' => false)),
      'delivery_code'   => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('purchase_order[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PurchaseOrder';
  }

}
