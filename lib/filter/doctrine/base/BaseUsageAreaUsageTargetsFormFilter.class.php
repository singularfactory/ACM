<?php

/**
 * UsageAreaUsageTargets filter form base class.
 *
 * @package    ACM
 * @subpackage filter
 * @author     
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUsageAreaUsageTargetsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'usage_area_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UsageArea'), 'add_empty' => true)),
      'usage_target_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UsageTarget'), 'add_empty' => true)),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'strain_taxonomies_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'StrainTaxonomy')),
    ));

    $this->setValidators(array(
      'usage_area_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UsageArea'), 'column' => 'id')),
      'usage_target_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UsageTarget'), 'column' => 'id')),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'strain_taxonomies_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'StrainTaxonomy', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usage_area_usage_targets_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
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
      ->andWhereIn('PotentialUsages.strain_taxonomy_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'UsageAreaUsageTargets';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'usage_area_id'          => 'ForeignKey',
      'usage_target_id'        => 'ForeignKey',
      'created_at'             => 'Date',
      'updated_at'             => 'Date',
      'strain_taxonomies_list' => 'ManyKey',
    );
  }
}
