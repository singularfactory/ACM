<?php

/**
 * Project form base class.
 *
 * @method Project getObject() Returns the current form's model object
 *
 * @package    ACM
 * @subpackage form
 * @author     
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProjectForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'project_name_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProjectName'), 'add_empty' => false)),
      'petitioner_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Petitioner'), 'add_empty' => false)),
      'subject'            => new sfWidgetFormChoice(array('choices' => array('sample' => 'sample', 'strain' => 'strain', 'external_strain' => 'external_strain'))),
      'strain_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Strain'), 'add_empty' => true)),
      'sample_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'), 'add_empty' => true)),
      'external_strain_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExternalStrain'), 'add_empty' => true)),
      'amount'             => new sfWidgetFormInputText(),
      'provider_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Provider'), 'add_empty' => true)),
      'inoculation_date'   => new sfWidgetFormDate(),
      'purpose'            => new sfWidgetFormTextarea(),
      'delivery_date'      => new sfWidgetFormDate(),
      'remarks'            => new sfWidgetFormTextarea(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'project_name_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ProjectName'))),
      'petitioner_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Petitioner'))),
      'subject'            => new sfValidatorChoice(array('choices' => array(0 => 'sample', 1 => 'strain', 2 => 'external_strain'), 'required' => false)),
      'strain_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Strain'), 'required' => false)),
      'sample_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'), 'required' => false)),
      'external_strain_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ExternalStrain'), 'required' => false)),
      'amount'             => new sfValidatorNumber(array('required' => false)),
      'provider_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Provider'), 'required' => false)),
      'inoculation_date'   => new sfValidatorDate(),
      'purpose'            => new sfValidatorString(),
      'delivery_date'      => new sfValidatorDate(array('required' => false)),
      'remarks'            => new sfValidatorString(array('required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('project[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Project';
  }

}
