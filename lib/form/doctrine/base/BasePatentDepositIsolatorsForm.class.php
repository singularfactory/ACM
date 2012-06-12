<?php

/**
 * PatentDepositIsolators form base class.
 *
 * @method PatentDepositIsolators getObject() Returns the current form's model object
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePatentDepositIsolatorsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'patent_deposit_id' => new sfWidgetFormInputHidden(),
      'isolator_id'       => new sfWidgetFormInputHidden(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'patent_deposit_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('patent_deposit_id')), 'empty_value' => $this->getObject()->get('patent_deposit_id'), 'required' => false)),
      'isolator_id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('isolator_id')), 'empty_value' => $this->getObject()->get('isolator_id'), 'required' => false)),
      'created_at'        => new sfValidatorDateTime(),
      'updated_at'        => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('patent_deposit_isolators[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PatentDepositIsolators';
  }

}
