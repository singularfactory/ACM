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
      'location_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Location'), 'add_empty' => true)),
      'latitude'            => new sfWidgetFormFilterInput(),
      'longitude'           => new sfWidgetFormFilterInput(),
      'environment_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Environment'), 'add_empty' => true)),
      'habitat_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Habitat'), 'add_empty' => true)),
      'ph'                  => new sfWidgetFormFilterInput(),
      'conductivity'        => new sfWidgetFormFilterInput(),
      'temperature'         => new sfWidgetFormFilterInput(),
      'salinity'            => new sfWidgetFormFilterInput(),
      'altitude'            => new sfWidgetFormFilterInput(),
      'radiation_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Radiation'), 'add_empty' => true)),
      'field_picture'       => new sfWidgetFormFilterInput(),
      'detailed_picture'    => new sfWidgetFormFilterInput(),
      'microscopic_picture' => new sfWidgetFormFilterInput(),
      'collector_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Collector'), 'add_empty' => true)),
      'collection_date'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'remarks'             => new sfWidgetFormFilterInput(),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'location_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Location'), 'column' => 'id')),
      'latitude'            => new sfValidatorPass(array('required' => false)),
      'longitude'           => new sfValidatorPass(array('required' => false)),
      'environment_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Environment'), 'column' => 'id')),
      'habitat_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Habitat'), 'column' => 'id')),
      'ph'                  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'conductivity'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'temperature'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'salinity'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'altitude'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'radiation_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Radiation'), 'column' => 'id')),
      'field_picture'       => new sfValidatorPass(array('required' => false)),
      'detailed_picture'    => new sfValidatorPass(array('required' => false)),
      'microscopic_picture' => new sfValidatorPass(array('required' => false)),
      'collector_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Collector'), 'column' => 'id')),
      'collection_date'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'remarks'             => new sfValidatorPass(array('required' => false)),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
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
      'id'                  => 'Number',
      'location_id'         => 'ForeignKey',
      'latitude'            => 'Text',
      'longitude'           => 'Text',
      'environment_id'      => 'ForeignKey',
      'habitat_id'          => 'ForeignKey',
      'ph'                  => 'Number',
      'conductivity'        => 'Number',
      'temperature'         => 'Number',
      'salinity'            => 'Number',
      'altitude'            => 'Number',
      'radiation_id'        => 'ForeignKey',
      'field_picture'       => 'Text',
      'detailed_picture'    => 'Text',
      'microscopic_picture' => 'Text',
      'collector_id'        => 'ForeignKey',
      'collection_date'     => 'Date',
      'remarks'             => 'Text',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
    );
  }
}
