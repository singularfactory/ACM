<?php

/**
 * PatentDeposit filter form base class.
 *
 * @package    ACM
 * @subpackage filter
 * @author     
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePatentDepositFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'depositor_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Depositor'), 'add_empty' => true)),
      'deposition_date'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'yearly_count'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'taxonomic_class_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TaxonomicClass'), 'add_empty' => true)),
      'genus_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Genus'), 'add_empty' => true)),
      'species_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Species'), 'add_empty' => true)),
      'authority_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Authority'), 'add_empty' => true)),
      'supervisor_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Supervisor'), 'add_empty' => true)),
      'is_epitype'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_axenic'               => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'has_dna'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'gen_sequence'            => new sfWidgetFormFilterInput(),
      'location_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Location'), 'add_empty' => true)),
      'environment_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Environment'), 'add_empty' => true)),
      'habitat_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Habitat'), 'add_empty' => true)),
      'collection_date'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'isolation_date'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'identifier_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Identifier'), 'add_empty' => true)),
      'transfer_interval'       => new sfWidgetFormFilterInput(),
      'viability_test'          => new sfWidgetFormFilterInput(),
      'observation'             => new sfWidgetFormFilterInput(),
      'citations'               => new sfWidgetFormFilterInput(),
      'remarks'                 => new sfWidgetFormFilterInput(),
      'bp1_document'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'bp4_document'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'picture'                 => new sfWidgetFormFilterInput(),
      'created_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'collectors_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Collector')),
      'isolators_list'          => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Isolator')),
      'culture_media_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'CultureMedium')),
      'maintenance_status_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'MaintenanceStatus')),
    ));

    $this->setValidators(array(
      'depositor_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Depositor'), 'column' => 'id')),
      'deposition_date'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'yearly_count'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'taxonomic_class_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TaxonomicClass'), 'column' => 'id')),
      'genus_id'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Genus'), 'column' => 'id')),
      'species_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Species'), 'column' => 'id')),
      'authority_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Authority'), 'column' => 'id')),
      'supervisor_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Supervisor'), 'column' => 'id')),
      'is_epitype'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_axenic'               => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'has_dna'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'gen_sequence'            => new sfValidatorPass(array('required' => false)),
      'location_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Location'), 'column' => 'id')),
      'environment_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Environment'), 'column' => 'id')),
      'habitat_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Habitat'), 'column' => 'id')),
      'collection_date'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'isolation_date'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'identifier_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Identifier'), 'column' => 'id')),
      'transfer_interval'       => new sfValidatorPass(array('required' => false)),
      'viability_test'          => new sfValidatorPass(array('required' => false)),
      'observation'             => new sfValidatorPass(array('required' => false)),
      'citations'               => new sfValidatorPass(array('required' => false)),
      'remarks'                 => new sfValidatorPass(array('required' => false)),
      'bp1_document'            => new sfValidatorPass(array('required' => false)),
      'bp4_document'            => new sfValidatorPass(array('required' => false)),
      'picture'                 => new sfValidatorPass(array('required' => false)),
      'created_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'collectors_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Collector', 'required' => false)),
      'isolators_list'          => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Isolator', 'required' => false)),
      'culture_media_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'CultureMedium', 'required' => false)),
      'maintenance_status_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'MaintenanceStatus', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('patent_deposit_filters[%s]');

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
      ->leftJoin($query->getRootAlias().'.PatentDepositCollectors PatentDepositCollectors')
      ->andWhereIn('PatentDepositCollectors.collector_id', $values)
    ;
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
      ->leftJoin($query->getRootAlias().'.PatentDepositIsolators PatentDepositIsolators')
      ->andWhereIn('PatentDepositIsolators.isolator_id', $values)
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
      ->leftJoin($query->getRootAlias().'.PatentDepositCultureMedia PatentDepositCultureMedia')
      ->andWhereIn('PatentDepositCultureMedia.culture_medium_id', $values)
    ;
  }

  public function addMaintenanceStatusListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.PatentDepositMaintenanceStatus PatentDepositMaintenanceStatus')
      ->andWhereIn('PatentDepositMaintenanceStatus.maintenance_status_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'PatentDeposit';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'depositor_id'            => 'ForeignKey',
      'deposition_date'         => 'Date',
      'yearly_count'            => 'Number',
      'taxonomic_class_id'      => 'ForeignKey',
      'genus_id'                => 'ForeignKey',
      'species_id'              => 'ForeignKey',
      'authority_id'            => 'ForeignKey',
      'supervisor_id'           => 'ForeignKey',
      'is_epitype'              => 'Boolean',
      'is_axenic'               => 'Boolean',
      'has_dna'                 => 'Boolean',
      'gen_sequence'            => 'Text',
      'location_id'             => 'ForeignKey',
      'environment_id'          => 'ForeignKey',
      'habitat_id'              => 'ForeignKey',
      'collection_date'         => 'Date',
      'isolation_date'          => 'Date',
      'identifier_id'           => 'ForeignKey',
      'transfer_interval'       => 'Text',
      'viability_test'          => 'Text',
      'observation'             => 'Text',
      'citations'               => 'Text',
      'remarks'                 => 'Text',
      'bp1_document'            => 'Text',
      'bp4_document'            => 'Text',
      'picture'                 => 'Text',
      'created_at'              => 'Date',
      'updated_at'              => 'Date',
      'collectors_list'         => 'ManyKey',
      'isolators_list'          => 'ManyKey',
      'culture_media_list'      => 'ManyKey',
      'maintenance_status_list' => 'ManyKey',
    );
  }
}
