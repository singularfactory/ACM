<?php

/**
 * BaseMaintenanceStatus
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property Doctrine_Collection $Strains
 * @property Doctrine_Collection $ExternalStrains
 * @property Doctrine_Collection $PatentDeposits
 * @property Doctrine_Collection $MaintenanceDeposits
 * 
 * @method integer             getId()                  Returns the current record's "id" value
 * @method string              getName()                Returns the current record's "name" value
 * @method Doctrine_Collection getStrains()             Returns the current record's "Strains" collection
 * @method Doctrine_Collection getExternalStrains()     Returns the current record's "ExternalStrains" collection
 * @method Doctrine_Collection getPatentDeposits()      Returns the current record's "PatentDeposits" collection
 * @method Doctrine_Collection getMaintenanceDeposits() Returns the current record's "MaintenanceDeposits" collection
 * @method MaintenanceStatus   setId()                  Sets the current record's "id" value
 * @method MaintenanceStatus   setName()                Sets the current record's "name" value
 * @method MaintenanceStatus   setStrains()             Sets the current record's "Strains" collection
 * @method MaintenanceStatus   setExternalStrains()     Sets the current record's "ExternalStrains" collection
 * @method MaintenanceStatus   setPatentDeposits()      Sets the current record's "PatentDeposits" collection
 * @method MaintenanceStatus   setMaintenanceDeposits() Sets the current record's "MaintenanceDeposits" collection
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseMaintenanceStatus extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('maintenance_status');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('name', 'string', 127, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 127,
             ));


        $this->index('maintenance_status_name', array(
             'fields' => 
             array(
              'name' => 
              array(
              'length' => 20,
              ),
             ),
             ));
        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Strain as Strains', array(
             'refClass' => 'StrainMaintenanceStatus',
             'local' => 'maintenance_status_id',
             'foreign' => 'strain_id'));

        $this->hasMany('ExternalStrain as ExternalStrains', array(
             'refClass' => 'ExternalStrainMaintenanceStatus',
             'local' => 'maintenance_status_id',
             'foreign' => 'external_strain_id'));

        $this->hasMany('PatentDeposit as PatentDeposits', array(
             'refClass' => 'PatentDepositMaintenanceStatus',
             'local' => 'maintenance_status_id',
             'foreign' => 'patent_deposit_id'));

        $this->hasMany('MaintenanceDeposit as MaintenanceDeposits', array(
             'refClass' => 'MaintenanceDepositMaintenanceStatus',
             'local' => 'maintenance_status_id',
             'foreign' => 'maintenance_deposit_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}