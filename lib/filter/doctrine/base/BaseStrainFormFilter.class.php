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
      'sample_id'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'), 'add_empty' => true)),
      'is_epitype'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_axenic'                  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_public'                  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'taxonomic_class_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TaxonomicClass'), 'add_empty' => true)),
      'genus_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Genus'), 'add_empty' => true)),
      'species_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Species'), 'add_empty' => true)),
      'authority_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Authority'), 'add_empty' => true)),
      'isolator_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Isolator'), 'add_empty' => true)),
      'isolation_date'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'depositor_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Depositor'), 'add_empty' => true)),
      'deposition_date'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'identifier_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Identifier'), 'add_empty' => true)),
      'maintenance_status_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MaintenanceStatus'), 'add_empty' => true)),
      'cryopreservation_method_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CryopreservationMethod'), 'add_empty' => true)),
      'transfer_interval'          => new sfWidgetFormFilterInput(),
      'observation'                => new sfWidgetFormFilterInput(),
      'citations'                  => new sfWidgetFormFilterInput(),
      'web_notes'                  => new sfWidgetFormFilterInput(),
      'remarks'                    => new sfWidgetFormFilterInput(),
      'created_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'growth_mediums_list'        => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'GrowthMedium')),
    ));

    $this->setValidators(array(
      'sample_id'                  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Sample'), 'column' => 'id')),
      'is_epitype'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_axenic'                  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_public'                  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'taxonomic_class_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TaxonomicClass'), 'column' => 'id')),
      'genus_id'                   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Genus'), 'column' => 'id')),
      'species_id'                 => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Species'), 'column' => 'id')),
      'authority_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Authority'), 'column' => 'id')),
      'isolator_id'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Isolator'), 'column' => 'id')),
      'isolation_date'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'depositor_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Depositor'), 'column' => 'id')),
      'deposition_date'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'identifier_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Identifier'), 'column' => 'id')),
      'maintenance_status_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('MaintenanceStatus'), 'column' => 'id')),
      'cryopreservation_method_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CryopreservationMethod'), 'column' => 'id')),
      'transfer_interval'          => new sfValidatorPass(array('required' => false)),
      'observation'                => new sfValidatorPass(array('required' => false)),
      'citations'                  => new sfValidatorPass(array('required' => false)),
      'web_notes'                  => new sfValidatorPass(array('required' => false)),
      'remarks'                    => new sfValidatorPass(array('required' => false)),
      'created_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'growth_mediums_list'        => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'GrowthMedium', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('strain_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addGrowthMediumsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.StrainGrowthMediums StrainGrowthMediums')
      ->andWhereIn('StrainGrowthMediums.growth_medium_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Strain';
  }

  public function getFields()
  {
    return array(
      'id'                         => 'Number',
      'sample_id'                  => 'ForeignKey',
      'is_epitype'                 => 'Boolean',
      'is_axenic'                  => 'Boolean',
      'is_public'                  => 'Boolean',
      'taxonomic_class_id'         => 'ForeignKey',
      'genus_id'                   => 'ForeignKey',
      'species_id'                 => 'ForeignKey',
      'authority_id'               => 'ForeignKey',
      'isolator_id'                => 'ForeignKey',
      'isolation_date'             => 'Date',
      'depositor_id'               => 'ForeignKey',
      'deposition_date'            => 'Date',
      'identifier_id'              => 'ForeignKey',
      'maintenance_status_id'      => 'ForeignKey',
      'cryopreservation_method_id' => 'ForeignKey',
      'transfer_interval'          => 'Text',
      'observation'                => 'Text',
      'citations'                  => 'Text',
      'web_notes'                  => 'Text',
      'remarks'                    => 'Text',
      'created_at'                 => 'Date',
      'updated_at'                 => 'Date',
      'growth_mediums_list'        => 'ManyKey',
    );
  }
}
