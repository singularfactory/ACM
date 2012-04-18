<?php
/**
 * Filter form
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
 * @package       ACM.Lib.Filter
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */


/**
 * PurchaseItem filter form base class.
 *
 * @package ACM.Lib.Filter
 * @since 1.0
 */
abstract class BasePurchaseItemFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'status'            => new sfWidgetFormChoice(array('choices' => array('' => '', 'pending' => 'pending', 'processing' => 'processing', 'ready' => 'ready'))),
      'product'           => new sfWidgetFormChoice(array('choices' => array('' => '', 'strain' => 'strain', 'culture_medium' => 'culture_medium', 'genomic_dna' => 'genomic_dna'))),
      'product_id'        => new sfWidgetFormFilterInput(),
      'code'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'amount'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'remarks'           => new sfWidgetFormFilterInput(),
      'purchase_order_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PurchaseOrder'), 'add_empty' => true)),
      'supervisor_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Supervisor'), 'add_empty' => true)),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'status'            => new sfValidatorChoice(array('required' => false, 'choices' => array('pending' => 'pending', 'processing' => 'processing', 'ready' => 'ready'))),
      'product'           => new sfValidatorChoice(array('required' => false, 'choices' => array('strain' => 'strain', 'culture_medium' => 'culture_medium', 'genomic_dna' => 'genomic_dna'))),
      'product_id'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'code'              => new sfValidatorPass(array('required' => false)),
      'amount'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'remarks'           => new sfValidatorPass(array('required' => false)),
      'purchase_order_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('PurchaseOrder'), 'column' => 'id')),
      'supervisor_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Supervisor'), 'column' => 'id')),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('purchase_item_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PurchaseItem';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'status'            => 'Enum',
      'product'           => 'Enum',
      'product_id'        => 'Number',
      'code'              => 'Text',
      'amount'            => 'Number',
      'remarks'           => 'Text',
      'purchase_order_id' => 'ForeignKey',
      'supervisor_id'     => 'ForeignKey',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
    );
  }
}
