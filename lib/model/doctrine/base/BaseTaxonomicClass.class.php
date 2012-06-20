<?php

/**
 * BaseTaxonomicClass
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
 * @method TaxonomicClass      setId()                  Sets the current record's "id" value
 * @method TaxonomicClass      setName()                Sets the current record's "name" value
 * @method TaxonomicClass      setStrains()             Sets the current record's "Strains" collection
 * @method TaxonomicClass      setPatentDeposits()      Sets the current record's "PatentDeposits" collection
 * @method TaxonomicClass      setMaintenanceDeposits() Sets the current record's "MaintenanceDeposits" collection
 * @method TaxonomicClass      setExternalStrains()     Sets the current record's "ExternalStrains" collection
 * @method TaxonomicClass      setIsolations()          Sets the current record's "Isolations" collection
 * @method TaxonomicClass      setStrainUsages()        Sets the current record's "StrainUsages" collection
 * 
 * @package    ACM
 * @subpackage model
 * @author     
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTaxonomicClass extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('taxonomic_class');
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


        $this->index('taxonomic_class_name', array(
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
             'foreign' => 'taxonomic_class_id'));

        $this->hasMany('PatentDeposit as PatentDeposits', array(
             'local' => 'id',
             'foreign' => 'taxonomic_class_id'));

        $this->hasMany('MaintenanceDeposit as MaintenanceDeposits', array(
             'local' => 'id',
             'foreign' => 'taxonomic_class_id'));

        $this->hasMany('ExternalStrain as ExternalStrains', array(
             'local' => 'id',
             'foreign' => 'taxonomic_class_id'));

        $this->hasMany('Isolation as Isolations', array(
             'local' => 'id',
             'foreign' => 'taxonomic_class_id'));

        $this->hasMany('StrainUsage as StrainUsages', array(
             'local' => 'id',
             'foreign' => 'taxonomic_class_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}