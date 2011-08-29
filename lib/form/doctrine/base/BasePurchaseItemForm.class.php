<?php

/**
 * PurchaseItem form base class.
 *
 * @method PurchaseItem getObject() Returns the current form's model object
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePurchaseItemForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'status'            => new sfWidgetFormChoice(array('choices' => array('pending' => 'pending', 'processing' => 'processing', 'ready' => 'ready'))),
      'product'           => new sfWidgetFormChoice(array('choices' => array('strain' => 'strain', 'culture_medium' => 'culture_medium', 'genomic_dna' => 'genomic_dna'))),
      'amount'            => new sfWidgetFormInputText(),
      'remarks'           => new sfWidgetFormTextarea(),
      'purchase_order_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PurchaseOrder'), 'add_empty' => false)),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'status'            => new sfValidatorChoice(array('choices' => array(0 => 'pending', 1 => 'processing', 2 => 'ready'), 'required' => false)),
      'product'           => new sfValidatorChoice(array('choices' => array(0 => 'strain', 1 => 'culture_medium', 2 => 'genomic_dna'), 'required' => false)),
      'amount'            => new sfValidatorInteger(array('required' => false)),
      'remarks'           => new sfValidatorString(array('required' => false)),
      'purchase_order_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('PurchaseOrder'))),
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
