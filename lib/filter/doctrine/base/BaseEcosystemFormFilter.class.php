<?php

/**
 * Ecosystem filter form base class.
 *
 * @package    bna_green_house
 * @subpackage filter
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseEcosystemFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'latitude_degrees'  => new sfWidgetFormFilterInput(),
      'longitude_degrees' => new sfWidgetFormFilterInput(),
      'latitude_minutes'  => new sfWidgetFormFilterInput(),
      'longitude_minutes' => new sfWidgetFormFilterInput(),
      'country_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => true)),
      'province_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Province'), 'add_empty' => true)),
      'city'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'picture'           => new sfWidgetFormFilterInput(),
      'remarks'           => new sfWidgetFormFilterInput(),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'name'              => new sfValidatorPass(array('required' => false)),
      'latitude_degrees'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'longitude_degrees' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'latitude_minutes'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'longitude_minutes' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'country_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Country'), 'column' => 'id')),
      'province_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Province'), 'column' => 'id')),
      'city'              => new sfValidatorPass(array('required' => false)),
      'picture'           => new sfValidatorPass(array('required' => false)),
      'remarks'           => new sfValidatorPass(array('required' => false)),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('ecosystem_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Ecosystem';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'name'              => 'Text',
      'latitude_degrees'  => 'Number',
      'longitude_degrees' => 'Number',
      'latitude_minutes'  => 'Number',
      'longitude_minutes' => 'Number',
      'country_id'        => 'ForeignKey',
      'province_id'       => 'ForeignKey',
      'city'              => 'Text',
      'picture'           => 'Text',
      'remarks'           => 'Text',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
    );
  }
}
