<?php

/**
 * PcrProgramStep form base class.
 *
 * @method PcrProgramStep getObject() Returns the current form's model object
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePcrProgramStepForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'segment'        => new sfWidgetFormInputText(),
      'temperature'    => new sfWidgetFormInputText(),
      'duration'       => new sfWidgetFormTime(),
      'pcr_program_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PcrProgram'), 'add_empty' => false)),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'segment'        => new sfValidatorInteger(),
      'temperature'    => new sfValidatorNumber(),
      'duration'       => new sfValidatorTime(),
      'pcr_program_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('PcrProgram'))),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('pcr_program_step[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcrProgramStep';
  }

}
