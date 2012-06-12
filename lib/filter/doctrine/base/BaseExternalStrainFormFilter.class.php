<?php

/**
 * ExternalStrain filter form base class.
 *
 * @package    bna_green_house
 * @subpackage filter
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseExternalStrainFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'taxonomic_class_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TaxonomicClass'), 'add_empty' => true)),
      'genus_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Genus'), 'add_empty' => true)),
      'species_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Species'), 'add_empty' => true)),
      'authority_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Authority'), 'add_empty' => true)),
      'is_epitype'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_axenic'                  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'has_dna'                    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'location_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Location'), 'add_empty' => true)),
      'environment_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Environment'), 'add_empty' => true)),
      'habitat_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Habitat'), 'add_empty' => true)),
      'collection_date'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'isolation_date'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'identifier_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Identifier'), 'add_empty' => true)),
      'supervisor_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Supervisor'), 'add_empty' => true)),
      'cryopreservation_method_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CryopreservationMethod'), 'add_empty' => true)),
      'transfer_interval'          => new sfWidgetFormFilterInput(),
      'observation'                => new sfWidgetFormFilterInput(),
      'citations'                  => new sfWidgetFormFilterInput(),
      'remarks'                    => new sfWidgetFormFilterInput(),
      'container_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Container'), 'add_empty' => true)),
      'created_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'containers_list'            => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Container')),
      'culture_media_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'CultureMedium')),
      'maintenance_status_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'MaintenanceStatus')),
      'isolators_list'             => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Isolator')),
    ));

    $this->setValidators(array(
      'taxonomic_class_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TaxonomicClass'), 'column' => 'id')),
      'genus_id'                   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Genus'), 'column' => 'id')),
      'species_id'                 => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Species'), 'column' => 'id')),
      'authority_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Authority'), 'column' => 'id')),
      'is_epitype'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_axenic'                  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'has_dna'                    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'location_id'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Location'), 'column' => 'id')),
      'environment_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Environment'), 'column' => 'id')),
      'habitat_id'                 => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Habitat'), 'column' => 'id')),
      'collection_date'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'isolation_date'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'identifier_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Identifier'), 'column' => 'id')),
      'supervisor_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Supervisor'), 'column' => 'id')),
      'cryopreservation_method_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CryopreservationMethod'), 'column' => 'id')),
      'transfer_interval'          => new sfValidatorPass(array('required' => false)),
      'observation'                => new sfValidatorPass(array('required' => false)),
      'citations'                  => new sfValidatorPass(array('required' => false)),
      'remarks'                    => new sfValidatorPass(array('required' => false)),
      'container_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Container'), 'column' => 'id')),
      'created_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'containers_list'            => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Container', 'required' => false)),
      'culture_media_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'CultureMedium', 'required' => false)),
      'maintenance_status_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'MaintenanceStatus', 'required' => false)),
      'isolators_list'             => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Isolator', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('external_strain_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addContainersListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.ExternalStrainContainers ExternalStrainContainers')
      ->andWhereIn('ExternalStrainContainers.container_id', $values)
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
      ->leftJoin($query->getRootAlias().'.ExternalStrainCultureMedia ExternalStrainCultureMedia')
      ->andWhereIn('ExternalStrainCultureMedia.culture_medium_id', $values)
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
      ->leftJoin($query->getRootAlias().'.ExternalStrainMaintenanceStatus ExternalStrainMaintenanceStatus')
      ->andWhereIn('ExternalStrainMaintenanceStatus.maintenance_status_id', $values)
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
      ->leftJoin($query->getRootAlias().'.ExternalStrainIsolators ExternalStrainIsolators')
      ->andWhereIn('ExternalStrainIsolators.isolator_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'ExternalStrain';
  }

  public function getFields()
  {
    return array(
      'id'                         => 'Number',
      'taxonomic_class_id'         => 'ForeignKey',
      'genus_id'                   => 'ForeignKey',
      'species_id'                 => 'ForeignKey',
      'authority_id'               => 'ForeignKey',
      'is_epitype'                 => 'Boolean',
      'is_axenic'                  => 'Boolean',
      'has_dna'                    => 'Boolean',
      'location_id'                => 'ForeignKey',
      'environment_id'             => 'ForeignKey',
      'habitat_id'                 => 'ForeignKey',
      'collection_date'            => 'Date',
      'isolation_date'             => 'Date',
      'identifier_id'              => 'ForeignKey',
      'supervisor_id'              => 'ForeignKey',
      'cryopreservation_method_id' => 'ForeignKey',
      'transfer_interval'          => 'Text',
      'observation'                => 'Text',
      'citations'                  => 'Text',
      'remarks'                    => 'Text',
      'container_id'               => 'ForeignKey',
      'created_at'                 => 'Date',
      'updated_at'                 => 'Date',
      'containers_list'            => 'ManyKey',
      'culture_media_list'         => 'ManyKey',
      'maintenance_status_list'    => 'ManyKey',
      'isolators_list'             => 'ManyKey',
    );
  }
}
