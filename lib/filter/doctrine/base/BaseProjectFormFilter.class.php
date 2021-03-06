<?php

/**
 * Project filter form base class.
 *
 * @package    ACM
 * @subpackage filter
 * @author     
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProjectFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'project_name_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProjectName'), 'add_empty' => true)),
      'petitioner_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Petitioner'), 'add_empty' => true)),
      'subject'            => new sfWidgetFormChoice(array('choices' => array('' => '', 'sample' => 'sample', 'strain' => 'strain', 'external_strain' => 'external_strain'))),
      'strain_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Strain'), 'add_empty' => true)),
      'sample_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'), 'add_empty' => true)),
      'external_strain_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExternalStrain'), 'add_empty' => true)),
      'amount'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'provider_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Provider'), 'add_empty' => true)),
      'inoculation_date'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'purpose'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'delivery_date'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'remarks'            => new sfWidgetFormFilterInput(),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'project_name_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ProjectName'), 'column' => 'id')),
      'petitioner_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Petitioner'), 'column' => 'id')),
      'subject'            => new sfValidatorChoice(array('required' => false, 'choices' => array('sample' => 'sample', 'strain' => 'strain', 'external_strain' => 'external_strain'))),
      'strain_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Strain'), 'column' => 'id')),
      'sample_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Sample'), 'column' => 'id')),
      'external_strain_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ExternalStrain'), 'column' => 'id')),
      'amount'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'provider_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Provider'), 'column' => 'id')),
      'inoculation_date'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'purpose'            => new sfValidatorPass(array('required' => false)),
      'delivery_date'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'remarks'            => new sfValidatorPass(array('required' => false)),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('project_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Project';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'project_name_id'    => 'ForeignKey',
      'petitioner_id'      => 'ForeignKey',
      'subject'            => 'Enum',
      'strain_id'          => 'ForeignKey',
      'sample_id'          => 'ForeignKey',
      'external_strain_id' => 'ForeignKey',
      'amount'             => 'Number',
      'provider_id'        => 'ForeignKey',
      'inoculation_date'   => 'Date',
      'purpose'            => 'Text',
      'delivery_date'      => 'Date',
      'remarks'            => 'Text',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
    );
  }
}
