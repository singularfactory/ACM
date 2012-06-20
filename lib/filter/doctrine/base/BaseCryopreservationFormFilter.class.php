<?php

/**
 * Cryopreservation filter form base class.
 *
 * @package    ACM
 * @subpackage filter
 * @author     
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCryopreservationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'subject'                    => new sfWidgetFormChoice(array('choices' => array('' => '', 'sample' => 'sample', 'strain' => 'strain', 'external_strain' => 'external_strain', 'patent_deposit' => 'patent_deposit', 'maintenance_deposit' => 'maintenance_deposit'))),
      'strain_id'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Strain'), 'add_empty' => true)),
      'sample_id'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'), 'add_empty' => true)),
      'external_strain_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExternalStrain'), 'add_empty' => true)),
      'patent_deposit_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PatentDeposit'), 'add_empty' => true)),
      'maintenance_deposit_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MaintenanceDeposit'), 'add_empty' => true)),
      'cryopreservation_method_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CryopreservationMethod'), 'add_empty' => true)),
      'cryopreservation_date'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'first_replicate'            => new sfWidgetFormFilterInput(),
      'second_replicate'           => new sfWidgetFormFilterInput(),
      'third_replicate'            => new sfWidgetFormFilterInput(),
      'density'                    => new sfWidgetFormFilterInput(),
      'revival_date'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'viability'                  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'remarks'                    => new sfWidgetFormFilterInput(),
      'created_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'subject'                    => new sfValidatorChoice(array('required' => false, 'choices' => array('sample' => 'sample', 'strain' => 'strain', 'external_strain' => 'external_strain', 'patent_deposit' => 'patent_deposit', 'maintenance_deposit' => 'maintenance_deposit'))),
      'strain_id'                  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Strain'), 'column' => 'id')),
      'sample_id'                  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Sample'), 'column' => 'id')),
      'external_strain_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ExternalStrain'), 'column' => 'id')),
      'patent_deposit_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('PatentDeposit'), 'column' => 'id')),
      'maintenance_deposit_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('MaintenanceDeposit'), 'column' => 'id')),
      'cryopreservation_method_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CryopreservationMethod'), 'column' => 'id')),
      'cryopreservation_date'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'first_replicate'            => new sfValidatorPass(array('required' => false)),
      'second_replicate'           => new sfValidatorPass(array('required' => false)),
      'third_replicate'            => new sfValidatorPass(array('required' => false)),
      'density'                    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'revival_date'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'viability'                  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'remarks'                    => new sfValidatorPass(array('required' => false)),
      'created_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('cryopreservation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cryopreservation';
  }

  public function getFields()
  {
    return array(
      'id'                         => 'Number',
      'subject'                    => 'Enum',
      'strain_id'                  => 'ForeignKey',
      'sample_id'                  => 'ForeignKey',
      'external_strain_id'         => 'ForeignKey',
      'patent_deposit_id'          => 'ForeignKey',
      'maintenance_deposit_id'     => 'ForeignKey',
      'cryopreservation_method_id' => 'ForeignKey',
      'cryopreservation_date'      => 'Date',
      'first_replicate'            => 'Text',
      'second_replicate'           => 'Text',
      'third_replicate'            => 'Text',
      'density'                    => 'Number',
      'revival_date'               => 'Date',
      'viability'                  => 'Boolean',
      'remarks'                    => 'Text',
      'created_at'                 => 'Date',
      'updated_at'                 => 'Date',
    );
  }
}
