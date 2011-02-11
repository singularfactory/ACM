<?php

/**
 * Sample filter form base class.
 *
 * @package    bna_green_house
 * @subpackage filter
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSampleFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'number'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'ecosystem_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ecosystem'), 'add_empty' => true)),
      'location'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'latitude_degrees'   => new sfWidgetFormFilterInput(),
      'longitude_degrees'  => new sfWidgetFormFilterInput(),
      'latitude_minutes'   => new sfWidgetFormFilterInput(),
      'longitude_minutes'  => new sfWidgetFormFilterInput(),
      'environment_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Environment'), 'add_empty' => true)),
      'habitat_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Habitat'), 'add_empty' => true)),
      'ph'                 => new sfWidgetFormFilterInput(),
      'conductivity'       => new sfWidgetFormFilterInput(),
      'temperature'        => new sfWidgetFormFilterInput(),
      'salinity'           => new sfWidgetFormFilterInput(),
      'close_picture'      => new sfWidgetFormFilterInput(),
      'laboratory_picture' => new sfWidgetFormFilterInput(),
      'collector_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Collector'), 'add_empty' => true)),
      'collection_date'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'number'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'ecosystem_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Ecosystem'), 'column' => 'id')),
      'location'           => new sfValidatorPass(array('required' => false)),
      'latitude_degrees'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'longitude_degrees'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'latitude_minutes'   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'longitude_minutes'  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'environment_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Environment'), 'column' => 'id')),
      'habitat_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Habitat'), 'column' => 'id')),
      'ph'                 => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'conductivity'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'temperature'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'salinity'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'close_picture'      => new sfValidatorPass(array('required' => false)),
      'laboratory_picture' => new sfValidatorPass(array('required' => false)),
      'collector_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Collector'), 'column' => 'id')),
      'collection_date'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('sample_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Sample';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'number'             => 'Number',
      'ecosystem_id'       => 'ForeignKey',
      'location'           => 'Text',
      'latitude_degrees'   => 'Number',
      'longitude_degrees'  => 'Number',
      'latitude_minutes'   => 'Number',
      'longitude_minutes'  => 'Number',
      'environment_id'     => 'ForeignKey',
      'habitat_id'         => 'ForeignKey',
      'ph'                 => 'Number',
      'conductivity'       => 'Number',
      'temperature'        => 'Number',
      'salinity'           => 'Number',
      'close_picture'      => 'Text',
      'laboratory_picture' => 'Text',
      'collector_id'       => 'ForeignKey',
      'collection_date'    => 'Date',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
    );
  }
}
