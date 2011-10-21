<?php

/**
 * MaintenanceStatus filter form base class.
 *
 * @package    bna_green_house
 * @subpackage filter
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMaintenanceStatusFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                      => new sfWidgetFormChoice(array('choices' => array('' => '', 'Liquid' => 'Liquid', 'Solid' => 'Solid', 'Cryopreserved' => 'Cryopreserved'))),
      'created_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'strains_list'              => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Strain')),
      'patent_deposits_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'PatentDeposit')),
      'maintenance_deposits_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'MaintenanceDeposit')),
    ));

    $this->setValidators(array(
      'name'                      => new sfValidatorChoice(array('required' => false, 'choices' => array('Liquid' => 'Liquid', 'Solid' => 'Solid', 'Cryopreserved' => 'Cryopreserved'))),
      'created_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'strains_list'              => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Strain', 'required' => false)),
      'patent_deposits_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'PatentDeposit', 'required' => false)),
      'maintenance_deposits_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'MaintenanceDeposit', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('maintenance_status_filters[%s]');

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
      ->leftJoin($query->getRootAlias().'.StrainMaintenanceStatus StrainMaintenanceStatus')
      ->andWhereIn('StrainMaintenanceStatus.strain_id', $values)
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
      ->leftJoin($query->getRootAlias().'.PatentDepositMaintenanceStatus PatentDepositMaintenanceStatus')
      ->andWhereIn('PatentDepositMaintenanceStatus.patent_deposit_id', $values)
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
      ->leftJoin($query->getRootAlias().'.MaintenanceDepositMaintenanceStatus MaintenanceDepositMaintenanceStatus')
      ->andWhereIn('MaintenanceDepositMaintenanceStatus.maintenance_deposit_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'MaintenanceStatus';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'name'                      => 'Enum',
      'created_at'                => 'Date',
      'updated_at'                => 'Date',
      'strains_list'              => 'ManyKey',
      'patent_deposits_list'      => 'ManyKey',
      'maintenance_deposits_list' => 'ManyKey',
    );
  }
}
