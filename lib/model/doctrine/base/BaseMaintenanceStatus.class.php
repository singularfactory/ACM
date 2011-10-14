<?php

/**
 * BaseMaintenanceStatus
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property enum $name
 * @property Doctrine_Collection $Strains
 * @property Doctrine_Collection $PatentDeposits
 * @property Doctrine_Collection $MaintenanceDeposits
 * 
 * @method integer             getId()                  Returns the current record's "id" value
 * @method enum                getName()                Returns the current record's "name" value
 * @method Doctrine_Collection getStrains()             Returns the current record's "Strains" collection
 * @method Doctrine_Collection getPatentDeposits()      Returns the current record's "PatentDeposits" collection
 * @method Doctrine_Collection getMaintenanceDeposits() Returns the current record's "MaintenanceDeposits" collection
 * @method MaintenanceStatus   setId()                  Sets the current record's "id" value
 * @method MaintenanceStatus   setName()                Sets the current record's "name" value
 * @method MaintenanceStatus   setStrains()             Sets the current record's "Strains" collection
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
        $this->hasColumn('name', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'Liquid',
              1 => 'Solid',
              2 => 'Cryopreserved',
             ),
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
             'local' => 'id',
             'foreign' => 'maintenance_status_id'));

        $this->hasMany('PatentDeposit as PatentDeposits', array(
             'local' => 'id',
             'foreign' => 'maintenance_status_id'));

        $this->hasMany('MaintenanceDeposit as MaintenanceDeposits', array(
             'local' => 'id',
             'foreign' => 'maintenance_status_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}