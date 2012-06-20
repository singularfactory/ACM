<?php

/**
 * BaseCultureMedium
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $link
 * @property boolean $is_public
 * @property Doctrine_Collection $Strains
 * @property Doctrine_Collection $ExternalStrains
 * @property Doctrine_Collection $PatentDeposits
 * @property Doctrine_Collection $MaintenanceDeposits
 * @property Doctrine_Collection $Isolations
 * 
 * @method integer             getId()                  Returns the current record's "id" value
 * @method string              getName()                Returns the current record's "name" value
 * @method string              getDescription()         Returns the current record's "description" value
 * @method string              getLink()                Returns the current record's "link" value
 * @method boolean             getIsPublic()            Returns the current record's "is_public" value
 * @method Doctrine_Collection getStrains()             Returns the current record's "Strains" collection
 * @method Doctrine_Collection getExternalStrains()     Returns the current record's "ExternalStrains" collection
 * @method Doctrine_Collection getPatentDeposits()      Returns the current record's "PatentDeposits" collection
 * @method Doctrine_Collection getMaintenanceDeposits() Returns the current record's "MaintenanceDeposits" collection
 * @method Doctrine_Collection getIsolations()          Returns the current record's "Isolations" collection
 * @method CultureMedium       setId()                  Sets the current record's "id" value
 * @method CultureMedium       setName()                Sets the current record's "name" value
 * @method CultureMedium       setDescription()         Sets the current record's "description" value
 * @method CultureMedium       setLink()                Sets the current record's "link" value
 * @method CultureMedium       setIsPublic()            Sets the current record's "is_public" value
 * @method CultureMedium       setStrains()             Sets the current record's "Strains" collection
 * @method CultureMedium       setExternalStrains()     Sets the current record's "ExternalStrains" collection
 * @method CultureMedium       setPatentDeposits()      Sets the current record's "PatentDeposits" collection
 * @method CultureMedium       setMaintenanceDeposits() Sets the current record's "MaintenanceDeposits" collection
 * @method CultureMedium       setIsolations()          Sets the current record's "Isolations" collection
 * 
 * @package    ACM
 * @subpackage model
 * @author     
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCultureMedium extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('culture_medium');
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
        $this->hasColumn('description', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('link', 'string', 1024, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 1024,
             ));
        $this->hasColumn('is_public', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));


        $this->index('culture_medium_name', array(
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
             'refClass' => 'StrainCultureMedia',
             'local' => 'culture_medium_id',
             'foreign' => 'strain_id'));

        $this->hasMany('ExternalStrain as ExternalStrains', array(
             'refClass' => 'ExternalStrainCultureMedia',
             'local' => 'culture_medium_id',
             'foreign' => 'external_strain_id'));

        $this->hasMany('PatentDeposit as PatentDeposits', array(
             'refClass' => 'PatentDepositCultureMedia',
             'local' => 'culture_medium_id',
             'foreign' => 'patent_deposit_id'));

        $this->hasMany('MaintenanceDeposit as MaintenanceDeposits', array(
             'refClass' => 'MaintenanceDepositCultureMedia',
             'local' => 'culture_medium_id',
             'foreign' => 'maintenance_deposit_id'));

        $this->hasMany('Isolation as Isolations', array(
             'refClass' => 'IsolationCultureMedia',
             'local' => 'culture_medium_id',
             'foreign' => 'isolation_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}