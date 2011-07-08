<?php

/**
 * DnaSequence form base class.
 *
 * @method DnaSequence getObject() Returns the current form's model object
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDnaSequenceForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'pcr_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Pcr'), 'add_empty' => false)),
      'gen'        => new sfWidgetFormInputText(),
      'date'       => new sfWidgetFormDate(),
      'is_valid'   => new sfWidgetFormInputCheckbox(),
      'remarks'    => new sfWidgetFormTextarea(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'pcr_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Pcr'))),
      'gen'        => new sfValidatorString(array('max_length' => 127)),
      'date'       => new sfValidatorDate(),
      'is_valid'   => new sfValidatorBoolean(array('required' => false)),
      'remarks'    => new sfValidatorString(array('required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('dna_sequence[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DnaSequence';
  }

}
