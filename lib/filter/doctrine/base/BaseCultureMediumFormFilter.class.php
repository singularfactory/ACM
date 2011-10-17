<?php

/**
 * CultureMedium filter form base class.
 *
 * @package    bna_green_house
 * @subpackage filter
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCultureMediumFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'link'                      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_public'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'strains_list'              => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Strain')),
      'patent_deposits_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'PatentDeposit')),
      'maintenance_deposits_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'MaintenanceDeposit')),
      'isolations_list'           => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Isolation')),
    ));

    $this->setValidators(array(
      'name'                      => new sfValidatorPass(array('required' => false)),
      'description'               => new sfValidatorPass(array('required' => false)),
      'link'                      => new sfValidatorPass(array('required' => false)),
      'is_public'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'strains_list'              => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Strain', 'required' => false)),
      'patent_deposits_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'PatentDeposit', 'required' => false)),
      'maintenance_deposits_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'MaintenanceDeposit', 'required' => false)),
      'isolations_list'           => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Isolation', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('culture_medium_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addStrainsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('StrainCultureMedia.strain_id', $values)
    ;
  }

  public function addPatentDepositsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('PatentDepositCultureMedia.patent_deposit_id', $values)
    ;
  }

  public function addMaintenanceDepositsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.MaintenanceDepositCultureMedia MaintenanceDepositCultureMedia')
      ->andWhereIn('MaintenanceDepositCultureMedia.maintenance_deposit_id', $values)
    ;
  }

  public function addIsolationsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('IsolationCultureMedia.isolation_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'CultureMedium';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'name'                      => 'Text',
      'description'               => 'Text',
      'link'                      => 'Text',
      'is_public'                 => 'Boolean',
      'created_at'                => 'Date',
      'updated_at'                => 'Date',
      'strains_list'              => 'ManyKey',
      'patent_deposits_list'      => 'ManyKey',
      'maintenance_deposits_list' => 'ManyKey',
      'isolations_list'           => 'ManyKey',
    );
  }
}
