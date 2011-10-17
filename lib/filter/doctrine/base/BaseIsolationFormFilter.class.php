<?php

/**
 * Isolation filter form base class.
 *
 * @package    bna_green_house
 * @subpackage filter
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseIsolationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'reception_date'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'isolation_subject'      => new sfWidgetFormChoice(array('choices' => array('' => '', 'sample' => 'sample', 'strain' => 'strain', 'external' => 'external'))),
      'sample_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'), 'add_empty' => true)),
      'strain_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Strain'), 'add_empty' => true)),
      'external_code'          => new sfWidgetFormFilterInput(),
      'taxonomic_class_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TaxonomicClass'), 'add_empty' => true)),
      'genus_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Genus'), 'add_empty' => true)),
      'species_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Species'), 'add_empty' => true)),
      'authority_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Authority'), 'add_empty' => true)),
      'location_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Location'), 'add_empty' => true)),
      'environment_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Environment'), 'add_empty' => true)),
      'habitat_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Habitat'), 'add_empty' => true)),
      'delivery_date'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'purification_method_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PurificationMethod'), 'add_empty' => true)),
      'purification_details'   => new sfWidgetFormFilterInput(),
      'observation'            => new sfWidgetFormFilterInput(),
      'remarks'                => new sfWidgetFormFilterInput(),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'isolators_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Isolator')),
      'culture_media_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'CultureMedium')),
    ));

    $this->setValidators(array(
      'reception_date'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'isolation_subject'      => new sfValidatorChoice(array('required' => false, 'choices' => array('sample' => 'sample', 'strain' => 'strain', 'external' => 'external'))),
      'sample_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Sample'), 'column' => 'id')),
      'strain_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Strain'), 'column' => 'id')),
      'external_code'          => new sfValidatorPass(array('required' => false)),
      'taxonomic_class_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TaxonomicClass'), 'column' => 'id')),
      'genus_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Genus'), 'column' => 'id')),
      'species_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Species'), 'column' => 'id')),
      'authority_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Authority'), 'column' => 'id')),
      'location_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Location'), 'column' => 'id')),
      'environment_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Environment'), 'column' => 'id')),
      'habitat_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Habitat'), 'column' => 'id')),
      'delivery_date'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'purification_method_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('PurificationMethod'), 'column' => 'id')),
      'purification_details'   => new sfValidatorPass(array('required' => false)),
      'observation'            => new sfValidatorPass(array('required' => false)),
      'remarks'                => new sfValidatorPass(array('required' => false)),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'isolators_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Isolator', 'required' => false)),
      'culture_media_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'CultureMedium', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('isolation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addIsolatorsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.IsolationIsolators IsolationIsolators')
      ->andWhereIn('IsolationIsolators.isolator_id', $values)
    ;
  }

  public function addCultureMediaListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.IsolationCultureMedia IsolationCultureMedia')
      ->andWhereIn('IsolationCultureMedia.culture_medium_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Isolation';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'reception_date'         => 'Date',
      'isolation_subject'      => 'Enum',
      'sample_id'              => 'ForeignKey',
      'strain_id'              => 'ForeignKey',
      'external_code'          => 'Text',
      'taxonomic_class_id'     => 'ForeignKey',
      'genus_id'               => 'ForeignKey',
      'species_id'             => 'ForeignKey',
      'authority_id'           => 'ForeignKey',
      'location_id'            => 'ForeignKey',
      'environment_id'         => 'ForeignKey',
      'habitat_id'             => 'ForeignKey',
      'delivery_date'          => 'Date',
      'purification_method_id' => 'ForeignKey',
      'purification_details'   => 'Text',
      'observation'            => 'Text',
      'remarks'                => 'Text',
      'created_at'             => 'Date',
      'updated_at'             => 'Date',
      'isolators_list'         => 'ManyKey',
      'culture_media_list'     => 'ManyKey',
    );
  }
}
