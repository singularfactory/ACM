<?php

/**
 * Pcr form base class.
 *
 * @method Pcr getObject() Returns the current form's model object
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePcrForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'dna_extraction_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DnaExtraction'), 'add_empty' => false)),
      'dna_primer_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DnaPrimer'), 'add_empty' => false)),
      'dna_polymerase_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DnaPolymerase'), 'add_empty' => false)),
      'concentration'     => new sfWidgetFormInputText(),
      '260_280_ratio'     => new sfWidgetFormInputText(),
      '260_230_ratio'     => new sfWidgetFormInputText(),
      'can_be_sequenced'  => new sfWidgetFormInputCheckbox(),
      'remarks'           => new sfWidgetFormTextarea(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'dna_extraction_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DnaExtraction'))),
      'dna_primer_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DnaPrimer'))),
      'dna_polymerase_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DnaPolymerase'))),
      'concentration'     => new sfValidatorNumber(array('required' => false)),
      '260_280_ratio'     => new sfValidatorNumber(array('required' => false)),
      '260_230_ratio'     => new sfValidatorNumber(array('required' => false)),
      'can_be_sequenced'  => new sfValidatorBoolean(array('required' => false)),
      'remarks'           => new sfValidatorString(array('required' => false)),
      'created_at'        => new sfValidatorDateTime(),
      'updated_at'        => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('pcr[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Pcr';
  }

}
