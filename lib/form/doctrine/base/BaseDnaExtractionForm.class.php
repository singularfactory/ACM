<?php

/**
 * DnaExtraction form base class.
 *
 * @method DnaExtraction getObject() Returns the current form's model object
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDnaExtractionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'genbank_link'         => new sfWidgetFormInputText(),
      'strain_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Strain'), 'add_empty' => false)),
      'is_public'            => new sfWidgetFormInputCheckbox(),
      'arrival_date'         => new sfWidgetFormDate(),
      'extraction_date'      => new sfWidgetFormDate(),
      'extraction_kit_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExtractionKit'), 'add_empty' => false)),
      'dna_concentration_id' => new sfWidgetFormInputText(),
      'aliquots'             => new sfWidgetFormInputText(),
      'remarks'              => new sfWidgetFormTextarea(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'genbank_link'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'strain_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Strain'))),
      'is_public'            => new sfValidatorBoolean(array('required' => false)),
      'arrival_date'         => new sfValidatorDate(),
      'extraction_date'      => new sfValidatorDate(),
      'extraction_kit_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ExtractionKit'))),
      'dna_concentration_id' => new sfValidatorInteger(),
      'aliquots'             => new sfValidatorInteger(array('required' => false)),
      'remarks'              => new sfValidatorString(array('required' => false)),
      'created_at'           => new sfValidatorDateTime(),
      'updated_at'           => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('dna_extraction[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DnaExtraction';
  }

}
