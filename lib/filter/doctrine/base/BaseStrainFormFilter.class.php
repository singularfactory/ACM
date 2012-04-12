<?php

/**
 * Strain filter form base class.
 *
 * @package    bna_green_house
 * @subpackage filter
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseStrainFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'code'                    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'clone_number'            => new sfWidgetFormFilterInput(),
      'sample_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'), 'add_empty' => true)),
      'depositor_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Depositor'), 'add_empty' => true)),
      'is_epitype'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_axenic'               => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_public'               => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'deceased'                => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'kingdom_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Kingdom'), 'add_empty' => true)),
      'subkingdom_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Subkingdom'), 'add_empty' => true)),
      'phylum_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Phylum'), 'add_empty' => true)),
      'taxonomic_class_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TaxonomicClass'), 'add_empty' => true)),
      'taxonomic_order_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TaxonomicOrder'), 'add_empty' => true)),
      'family_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Family'), 'add_empty' => true)),
      'genus_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Genus'), 'add_empty' => true)),
      'species_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Species'), 'add_empty' => true)),
      'authority_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Authority'), 'add_empty' => true)),
      'isolation_date'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'identifier_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Identifier'), 'add_empty' => true)),
      'container_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Container'), 'add_empty' => true)),
      'transfer_interval'       => new sfWidgetFormFilterInput(),
      'observation'             => new sfWidgetFormFilterInput(),
      'citations'               => new sfWidgetFormFilterInput(),
      'web_notes'               => new sfWidgetFormFilterInput(),
      'remarks'                 => new sfWidgetFormFilterInput(),
      'supervisor_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Supervisor'), 'add_empty' => true)),
      'in_g_catalog'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'temperature'             => new sfWidgetFormFilterInput(),
      'photoperiod'             => new sfWidgetFormFilterInput(),
      'irradiation'             => new sfWidgetFormFilterInput(),
      'distribution'            => new sfWidgetFormFilterInput(),
      'article_description'     => new sfWidgetFormFilterInput(),
      'created_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'isolators_list'          => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Isolator')),
      'containers_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Container')),
      'culture_media_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'CultureMedium')),
      'maintenance_status_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'MaintenanceStatus')),
    ));

    $this->setValidators(array(
      'code'                    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'clone_number'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sample_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Sample'), 'column' => 'id')),
      'depositor_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Depositor'), 'column' => 'id')),
      'is_epitype'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_axenic'               => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_public'               => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'deceased'                => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'kingdom_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Kingdom'), 'column' => 'id')),
      'subkingdom_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Subkingdom'), 'column' => 'id')),
      'phylum_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Phylum'), 'column' => 'id')),
      'taxonomic_class_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TaxonomicClass'), 'column' => 'id')),
      'taxonomic_order_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TaxonomicOrder'), 'column' => 'id')),
      'family_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Family'), 'column' => 'id')),
      'genus_id'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Genus'), 'column' => 'id')),
      'species_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Species'), 'column' => 'id')),
      'authority_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Authority'), 'column' => 'id')),
      'isolation_date'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'identifier_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Identifier'), 'column' => 'id')),
      'container_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Container'), 'column' => 'id')),
      'transfer_interval'       => new sfValidatorPass(array('required' => false)),
      'observation'             => new sfValidatorPass(array('required' => false)),
      'citations'               => new sfValidatorPass(array('required' => false)),
      'web_notes'               => new sfValidatorPass(array('required' => false)),
      'remarks'                 => new sfValidatorPass(array('required' => false)),
      'supervisor_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Supervisor'), 'column' => 'id')),
      'in_g_catalog'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'temperature'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'photoperiod'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'irradiation'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'distribution'            => new sfValidatorPass(array('required' => false)),
      'article_description'     => new sfValidatorPass(array('required' => false)),
      'created_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'isolators_list'          => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Isolator', 'required' => false)),
      'containers_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Container', 'required' => false)),
      'culture_media_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'CultureMedium', 'required' => false)),
      'maintenance_status_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'MaintenanceStatus', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('strain_filters[%s]');

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
      ->leftJoin($query->getRootAlias().'.StrainIsolators StrainIsolators')
      ->andWhereIn('StrainIsolators.isolator_id', $values)
    ;
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
      ->leftJoin($query->getRootAlias().'.StrainContainers StrainContainers')
      ->andWhereIn('StrainContainers.container_id', $values)
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
      ->leftJoin($query->getRootAlias().'.StrainCultureMedia StrainCultureMedia')
      ->andWhereIn('StrainCultureMedia.culture_medium_id', $values)
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
      ->leftJoin($query->getRootAlias().'.StrainMaintenanceStatus StrainMaintenanceStatus')
      ->andWhereIn('StrainMaintenanceStatus.maintenance_status_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Strain';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'code'                    => 'Number',
      'clone_number'            => 'Number',
      'sample_id'               => 'ForeignKey',
      'depositor_id'            => 'ForeignKey',
      'is_epitype'              => 'Boolean',
      'is_axenic'               => 'Boolean',
      'is_public'               => 'Boolean',
      'deceased'                => 'Boolean',
      'kingdom_id'              => 'ForeignKey',
      'subkingdom_id'           => 'ForeignKey',
      'phylum_id'               => 'ForeignKey',
      'taxonomic_class_id'      => 'ForeignKey',
      'taxonomic_order_id'      => 'ForeignKey',
      'family_id'               => 'ForeignKey',
      'genus_id'                => 'ForeignKey',
      'species_id'              => 'ForeignKey',
      'authority_id'            => 'ForeignKey',
      'isolation_date'          => 'Date',
      'identifier_id'           => 'ForeignKey',
      'container_id'            => 'ForeignKey',
      'transfer_interval'       => 'Text',
      'observation'             => 'Text',
      'citations'               => 'Text',
      'web_notes'               => 'Text',
      'remarks'                 => 'Text',
      'supervisor_id'           => 'ForeignKey',
      'in_g_catalog'            => 'Boolean',
      'temperature'             => 'Number',
      'photoperiod'             => 'Number',
      'irradiation'             => 'Number',
      'distribution'            => 'Text',
      'article_description'     => 'Text',
      'created_at'              => 'Date',
      'updated_at'              => 'Date',
      'isolators_list'          => 'ManyKey',
      'containers_list'         => 'ManyKey',
      'culture_media_list'      => 'ManyKey',
      'maintenance_status_list' => 'ManyKey',
    );
  }
}
