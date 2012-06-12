<?php

/**
 * PurchaseItem filter form base class.
 *
 * @package    bna_green_house
 * @subpackage filter
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
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
