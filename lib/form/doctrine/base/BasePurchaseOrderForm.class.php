<?php

/**
 * PurchaseOrder form base class.
 *
 * @method PurchaseOrder getObject() Returns the current form's model object
 *
 * @package    ACM
 * @subpackage form
 * @author     
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
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
