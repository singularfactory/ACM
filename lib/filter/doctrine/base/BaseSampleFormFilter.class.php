<?php

/**
 * Sample filter form base class.
 *
 * @package    ACM
 * @subpackage filter
 * @author     
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSampleFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'notebook_code'    => new sfWidgetFormFilterInput(),
      'location_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Location'), 'add_empty' => true)),
      'location_details' => new sfWidgetFormFilterInput(),
      'latitude'         => new sfWidgetFormFilterInput(),
      'longitude'        => new sfWidgetFormFilterInput(),
      'environment_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Environment'), 'add_empty' => true)),
      'is_extremophile'  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'habitat_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Habitat'), 'add_empty' => true)),
      'ph'               => new sfWidgetFormFilterInput(),
      'conductivity'     => new sfWidgetFormFilterInput(),
      'temperature'      => new sfWidgetFormFilterInput(),
      'salinity'         => new sfWidgetFormFilterInput(),
      'altitude'         => new sfWidgetFormFilterInput(),
      'radiation_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Radiation'), 'add_empty' => true)),
      'collection_date'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'remarks'          => new sfWidgetFormFilterInput(),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'collectors_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Collector')),
    ));

    $this->setValidators(array(
      'notebook_code'    => new sfValidatorPass(array('required' => false)),
      'location_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Location'), 'column' => 'id')),
      'location_details' => new sfValidatorPass(array('required' => false)),
      'latitude'         => new sfValidatorPass(array('required' => false)),
      'longitude'        => new sfValidatorPass(array('required' => false)),
      'environment_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Environment'), 'column' => 'id')),
      'is_extremophile'  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'habitat_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Habitat'), 'column' => 'id')),
      'ph'               => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'conductivity'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'temperature'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'salinity'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'altitude'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'radiation_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Radiation'), 'column' => 'id')),
      'collection_date'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'remarks'          => new sfValidatorPass(array('required' => false)),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'collectors_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Collector', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sample_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addCollectorsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.SampleCollectors SampleCollectors')
      ->andWhereIn('SampleCollectors.collector_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Sample';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'notebook_code'    => 'Text',
      'location_id'      => 'ForeignKey',
      'location_details' => 'Text',
      'latitude'         => 'Text',
      'longitude'        => 'Text',
      'environment_id'   => 'ForeignKey',
      'is_extremophile'  => 'Boolean',
      'habitat_id'       => 'ForeignKey',
      'ph'               => 'Number',
      'conductivity'     => 'Number',
      'temperature'      => 'Number',
      'salinity'         => 'Number',
      'altitude'         => 'Number',
      'radiation_id'     => 'ForeignKey',
      'collection_date'  => 'Date',
      'remarks'          => 'Text',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
      'collectors_list'  => 'ManyKey',
    );
  }
}
