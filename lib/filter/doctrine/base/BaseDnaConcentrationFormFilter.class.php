<?php

/**
 * DnaConcentration filter form base class.
 *
 * @package    bna_green_house
 * @subpackage filter
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDnaConcentrationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'amount'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      '260_280_ratio' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      '260_230_ratio' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'amount'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      '260_280_ratio' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      '260_230_ratio' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'created_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('dna_concentration_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DnaConcentration';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'amount'        => 'Number',
      '260_280_ratio' => 'Number',
      '260_230_ratio' => 'Number',
      'created_at'    => 'Date',
      'updated_at'    => 'Date',
    );
  }
}
