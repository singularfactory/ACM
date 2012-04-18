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
 * PurchaseItem form base class.
 *
 * @method PurchaseItem getObject() Returns the current form's model object
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
abstract class BasePurchaseItemForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'status'            => new sfWidgetFormChoice(array('choices' => array('pending' => 'pending', 'processing' => 'processing', 'ready' => 'ready'))),
      'product'           => new sfWidgetFormChoice(array('choices' => array('strain' => 'strain', 'culture_medium' => 'culture_medium', 'genomic_dna' => 'genomic_dna'))),
      'product_id'        => new sfWidgetFormInputText(),
      'code'              => new sfWidgetFormInputText(),
      'amount'            => new sfWidgetFormInputText(),
      'remarks'           => new sfWidgetFormTextarea(),
      'purchase_order_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PurchaseOrder'), 'add_empty' => false)),
      'supervisor_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Supervisor'), 'add_empty' => true)),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'status'            => new sfValidatorChoice(array('choices' => array(0 => 'pending', 1 => 'processing', 2 => 'ready'), 'required' => false)),
      'product'           => new sfValidatorChoice(array('choices' => array(0 => 'strain', 1 => 'culture_medium', 2 => 'genomic_dna'), 'required' => false)),
      'product_id'        => new sfValidatorInteger(array('required' => false)),
      'code'              => new sfValidatorString(array('max_length' => 40)),
      'amount'            => new sfValidatorInteger(array('required' => false)),
      'remarks'           => new sfValidatorString(array('required' => false)),
      'purchase_order_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('PurchaseOrder'))),
      'supervisor_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Supervisor'), 'required' => false)),
      'created_at'        => new sfValidatorDateTime(),
      'updated_at'        => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('purchase_item[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PurchaseItem';
  }

}
