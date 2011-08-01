<?php

/**
 * PcrProgramStep filter form base class.
 *
 * @package    bna_green_house
 * @subpackage filter
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePcrProgramStepFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'segment'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'temperature'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'duration'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'pcr_program_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PcrProgram'), 'add_empty' => true)),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'segment'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'temperature'    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'duration'       => new sfValidatorPass(array('required' => false)),
      'pcr_program_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('PcrProgram'), 'column' => 'id')),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('pcr_program_step_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcrProgramStep';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'segment'        => 'Number',
      'temperature'    => 'Number',
      'duration'       => 'Text',
      'pcr_program_id' => 'ForeignKey',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
    );
  }
}
