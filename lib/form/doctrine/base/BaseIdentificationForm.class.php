<?php

/**
 * Identification form base class.
 *
 * @method Identification getObject() Returns the current form's model object
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseIdentificationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'identification_date'       => new sfWidgetFormDate(),
      'yearly_count'              => new sfWidgetFormInputText(),
      'sample_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'), 'add_empty' => false)),
      'petitioner_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Petitioner'), 'add_empty' => false)),
      'sample_picture'            => new sfWidgetFormInputText(),
      'microscopy_identification' => new sfWidgetFormTextarea(),
      'molecular_identification'  => new sfWidgetFormTextarea(),
      'request_document'          => new sfWidgetFormInputText(),
      'report_document'           => new sfWidgetFormInputText(),
      'remarks'                   => new sfWidgetFormTextarea(),
      'created_at'                => new sfWidgetFormDateTime(),
      'updated_at'                => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'identification_date'       => new sfValidatorDate(),
      'yearly_count'              => new sfValidatorInteger(),
      'sample_id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'))),
      'petitioner_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Petitioner'))),
      'sample_picture'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'microscopy_identification' => new sfValidatorString(array('required' => false)),
      'molecular_identification'  => new sfValidatorString(array('required' => false)),
      'request_document'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'report_document'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'remarks'                   => new sfValidatorString(array('required' => false)),
      'created_at'                => new sfValidatorDateTime(),
      'updated_at'                => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('identification[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Identification';
  }

}
