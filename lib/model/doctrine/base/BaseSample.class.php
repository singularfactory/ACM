<?php

/**
 * BaseSample
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $number
 * @property integer $ecosystem_id
 * @property string $location
 * @property integer $latitude_degrees
 * @property integer $longitude_degrees
 * @property float $latitude_minutes
 * @property float $longitude_minutes
 * @property integer $environment_id
 * @property integer $habitat_id
 * @property float $ph
 * @property float $conductivity
 * @property float $temperature
 * @property float $salinity
 * @property string $close_picture
 * @property string $laboratory_picture
 * @property integer $collector_id
 * @property timestamp $collection_date
 * @property Ecosystem $Ecosystem
 * @property Environment $Environment
 * @property Habitat $Habitat
 * @property User $Collector
 * 
 * @method integer     getId()                 Returns the current record's "id" value
 * @method integer     getNumber()             Returns the current record's "number" value
 * @method integer     getEcosystemId()        Returns the current record's "ecosystem_id" value
 * @method string      getLocation()           Returns the current record's "location" value
 * @method integer     getLatitudeDegrees()    Returns the current record's "latitude_degrees" value
 * @method integer     getLongitudeDegrees()   Returns the current record's "longitude_degrees" value
 * @method float       getLatitudeMinutes()    Returns the current record's "latitude_minutes" value
 * @method float       getLongitudeMinutes()   Returns the current record's "longitude_minutes" value
 * @method integer     getEnvironmentId()      Returns the current record's "environment_id" value
 * @method integer     getHabitatId()          Returns the current record's "habitat_id" value
 * @method float       getPh()                 Returns the current record's "ph" value
 * @method float       getConductivity()       Returns the current record's "conductivity" value
 * @method float       getTemperature()        Returns the current record's "temperature" value
 * @method float       getSalinity()           Returns the current record's "salinity" value
 * @method string      getClosePicture()       Returns the current record's "close_picture" value
 * @method string      getLaboratoryPicture()  Returns the current record's "laboratory_picture" value
 * @method integer     getCollectorId()        Returns the current record's "collector_id" value
 * @method timestamp   getCollectionDate()     Returns the current record's "collection_date" value
 * @method Ecosystem   getEcosystem()          Returns the current record's "Ecosystem" value
 * @method Environment getEnvironment()        Returns the current record's "Environment" value
 * @method Habitat     getHabitat()            Returns the current record's "Habitat" value
 * @method User        getCollector()          Returns the current record's "Collector" value
 * @method Sample      setId()                 Sets the current record's "id" value
 * @method Sample      setNumber()             Sets the current record's "number" value
 * @method Sample      setEcosystemId()        Sets the current record's "ecosystem_id" value
 * @method Sample      setLocation()           Sets the current record's "location" value
 * @method Sample      setLatitudeDegrees()    Sets the current record's "latitude_degrees" value
 * @method Sample      setLongitudeDegrees()   Sets the current record's "longitude_degrees" value
 * @method Sample      setLatitudeMinutes()    Sets the current record's "latitude_minutes" value
 * @method Sample      setLongitudeMinutes()   Sets the current record's "longitude_minutes" value
 * @method Sample      setEnvironmentId()      Sets the current record's "environment_id" value
 * @method Sample      setHabitatId()          Sets the current record's "habitat_id" value
 * @method Sample      setPh()                 Sets the current record's "ph" value
 * @method Sample      setConductivity()       Sets the current record's "conductivity" value
 * @method Sample      setTemperature()        Sets the current record's "temperature" value
 * @method Sample      setSalinity()           Sets the current record's "salinity" value
 * @method Sample      setClosePicture()       Sets the current record's "close_picture" value
 * @method Sample      setLaboratoryPicture()  Sets the current record's "laboratory_picture" value
 * @method Sample      setCollectorId()        Sets the current record's "collector_id" value
 * @method Sample      setCollectionDate()     Sets the current record's "collection_date" value
 * @method Sample      setEcosystem()          Sets the current record's "Ecosystem" value
 * @method Sample      setEnvironment()        Sets the current record's "Environment" value
 * @method Sample      setHabitat()            Sets the current record's "Habitat" value
 * @method Sample      setCollector()          Sets the current record's "Collector" value
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseSample extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('sample');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('number', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'unique' => true,
             'unsigned' => true,
             ));
        $this->hasColumn('ecosystem_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('location', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('latitude_degrees', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('longitude_degrees', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('latitude_minutes', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('longitude_minutes', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('environment_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('habitat_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('ph', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('conductivity', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('temperature', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('salinity', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('close_picture', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('laboratory_picture', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('collector_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('collection_date', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => true,
             ));

        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Ecosystem', array(
             'local' => 'ecosystem_id',
             'foreign' => 'id'));

        $this->hasOne('Environment', array(
             'local' => 'environment_id',
             'foreign' => 'id'));

        $this->hasOne('Habitat', array(
             'local' => 'habitat_id',
             'foreign' => 'id'));

        $this->hasOne('User as Collector', array(
             'local' => 'collector_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}