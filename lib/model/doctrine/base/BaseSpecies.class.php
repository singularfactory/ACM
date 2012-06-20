<?php

/**
 * BaseSpecies
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property Doctrine_Collection $Strains
 * @property Doctrine_Collection $PatentDeposits
 * @property Doctrine_Collection $MaintenanceDeposits
 * @property Doctrine_Collection $ExternalStrains
 * @property Doctrine_Collection $Isolations
 * @property Doctrine_Collection $StrainUsages
 * 
 * @method integer             getId()                  Returns the current record's "id" value
 * @method string              getName()                Returns the current record's "name" value
 * @method Doctrine_Collection getStrains()             Returns the current record's "Strains" collection
 * @method Doctrine_Collection getPatentDeposits()      Returns the current record's "PatentDeposits" collection
 * @method Doctrine_Collection getMaintenanceDeposits() Returns the current record's "MaintenanceDeposits" collection
 * @method Doctrine_Collection getExternalStrains()     Returns the current record's "ExternalStrains" collection
 * @method Doctrine_Collection getIsolations()          Returns the current record's "Isolations" collection
 * @method Doctrine_Collection getStrainUsages()        Returns the current record's "StrainUsages" collection
 * @method Species             setId()                  Sets the current record's "id" value
 * @method Species             setName()                Sets the current record's "name" value
 * @method Species             setStrains()             Sets the current record's "Strains" collection
 * @method Species             setPatentDeposits()      Sets the current record's "PatentDeposits" collection
 * @method Species             setMaintenanceDeposits() Sets the current record's "MaintenanceDeposits" collection
 * @method Species             setExternalStrains()     Sets the current record's "ExternalStrains" collection
 * @method Species             setIsolations()          Sets the current record's "Isolations" collection
 * @method Species             setStrainUsages()        Sets the current record's "StrainUsages" collection
 * 
 * @package    ACM
 * @subpackage model
 * @author     
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSpecies extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('species');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));


        $this->index('species_name', array(
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
             'foreign' => 'species_id'));

        $this->hasMany('PatentDeposit as PatentDeposits', array(
             'local' => 'id',
             'foreign' => 'species_id'));

        $this->hasMany('MaintenanceDeposit as MaintenanceDeposits', array(
             'local' => 'id',
             'foreign' => 'species_id'));

        $this->hasMany('ExternalStrain as ExternalStrains', array(
             'local' => 'id',
             'foreign' => 'species_id'));

        $this->hasMany('Isolation as Isolations', array(
             'local' => 'id',
             'foreign' => 'species_id'));

        $this->hasMany('StrainUsage as StrainUsages', array(
             'local' => 'id',
             'foreign' => 'species_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}