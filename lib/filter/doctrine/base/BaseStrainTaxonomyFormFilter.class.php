<?php

/**
 * StrainTaxonomy filter form base class.
 *
 * @package    ACM
 * @subpackage filter
 * @author     
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseStrainTaxonomyFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'taxonomic_class_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TaxonomicClass'), 'add_empty' => true)),
      'genus_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Genus'), 'add_empty' => true)),
      'species_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Species'), 'add_empty' => true)),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'potential_usages_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'UsageAreaUsageTargets')),
      'strain_taxonomies_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'UsageAreaUsageTargets')),
    ));

    $this->setValidators(array(
      'taxonomic_class_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TaxonomicClass'), 'column' => 'id')),
      'genus_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Genus'), 'column' => 'id')),
      'species_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Species'), 'column' => 'id')),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'potential_usages_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'UsageAreaUsageTargets', 'required' => false)),
      'strain_taxonomies_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'UsageAreaUsageTargets', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('strain_taxonomy_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addPotentialUsagesListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.PotentialUsages PotentialUsages')
      ->andWhereIn('PotentialUsages.usage_id', $values)
    ;
  }

  public function addStrainTaxonomiesListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.PotentialUsages PotentialUsages')
      ->andWhereIn('PotentialUsages.id', $values)
    ;
  }

  public function getModelName()
  {
    return 'StrainTaxonomy';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'taxonomic_class_id'     => 'ForeignKey',
      'genus_id'               => 'ForeignKey',
      'species_id'             => 'ForeignKey',
      'created_at'             => 'Date',
      'updated_at'             => 'Date',
      'potential_usages_list'  => 'ManyKey',
      'strain_taxonomies_list' => 'ManyKey',
    );
  }
}
