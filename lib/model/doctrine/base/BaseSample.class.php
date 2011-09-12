<?php

/**
 * BaseSample
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $notebook_code
 * @property integer $location_id
 * @property string $latitude
 * @property string $longitude
 * @property integer $environment_id
 * @property boolean $is_extremophile
 * @property integer $habitat_id
 * @property float $ph
 * @property float $conductivity
 * @property float $temperature
 * @property float $salinity
 * @property float $altitude
 * @property integer $radiation_id
 * @property integer $collector_id
 * @property date $collection_date
 * @property string $remarks
 * @property Location $Location
 * @property Environment $Environment
 * @property Habitat $Habitat
 * @property Radiation $Radiation
 * @property Collector $Collector
 * @property Doctrine_Collection $FieldPictures
 * @property Doctrine_Collection $DetailedPictures
 * @property Doctrine_Collection $MicroscopicPictures
 * @property Doctrine_Collection $Strains
 * 
 * @method integer             getId()                  Returns the current record's "id" value
 * @method integer             getNotebookCode()        Returns the current record's "notebook_code" value
 * @method integer             getLocationId()          Returns the current record's "location_id" value
 * @method string              getLatitude()            Returns the current record's "latitude" value
 * @method string              getLongitude()           Returns the current record's "longitude" value
 * @method integer             getEnvironmentId()       Returns the current record's "environment_id" value
 * @method boolean             getIsExtremophile()      Returns the current record's "is_extremophile" value
 * @method integer             getHabitatId()           Returns the current record's "habitat_id" value
 * @method float               getPh()                  Returns the current record's "ph" value
 * @method float               getConductivity()        Returns the current record's "conductivity" value
 * @method float               getTemperature()         Returns the current record's "temperature" value
 * @method float               getSalinity()            Returns the current record's "salinity" value
 * @method float               getAltitude()            Returns the current record's "altitude" value
 * @method integer             getRadiationId()         Returns the current record's "radiation_id" value
 * @method integer             getCollectorId()         Returns the current record's "collector_id" value
 * @method date                getCollectionDate()      Returns the current record's "collection_date" value
 * @method string              getRemarks()             Returns the current record's "remarks" value
 * @method Location            getLocation()            Returns the current record's "Location" value
 * @method Environment         getEnvironment()         Returns the current record's "Environment" value
 * @method Habitat             getHabitat()             Returns the current record's "Habitat" value
 * @method Radiation           getRadiation()           Returns the current record's "Radiation" value
 * @method Collector           getCollector()           Returns the current record's "Collector" value
 * @method Doctrine_Collection getFieldPictures()       Returns the current record's "FieldPictures" collection
 * @method Doctrine_Collection getDetailedPictures()    Returns the current record's "DetailedPictures" collection
 * @method Doctrine_Collection getMicroscopicPictures() Returns the current record's "MicroscopicPictures" collection
 * @method Doctrine_Collection getStrains()             Returns the current record's "Strains" collection
 * @method Sample              setId()                  Sets the current record's "id" value
 * @method Sample              setNotebookCode()        Sets the current record's "notebook_code" value
 * @method Sample              setLocationId()          Sets the current record's "location_id" value
 * @method Sample              setLatitude()            Sets the current record's "latitude" value
 * @method Sample              setLongitude()           Sets the current record's "longitude" value
 * @method Sample              setEnvironmentId()       Sets the current record's "environment_id" value
 * @method Sample              setIsExtremophile()      Sets the current record's "is_extremophile" value
 * @method Sample              setHabitatId()           Sets the current record's "habitat_id" value
 * @method Sample              setPh()                  Sets the current record's "ph" value
 * @method Sample              setConductivity()        Sets the current record's "conductivity" value
 * @method Sample              setTemperature()         Sets the current record's "temperature" value
 * @method Sample              setSalinity()            Sets the current record's "salinity" value
 * @method Sample              setAltitude()            Sets the current record's "altitude" value
 * @method Sample              setRadiationId()         Sets the current record's "radiation_id" value
 * @method Sample              setCollectorId()         Sets the current record's "collector_id" value
 * @method Sample              setCollectionDate()      Sets the current record's "collection_date" value
 * @method Sample              setRemarks()             Sets the current record's "remarks" value
 * @method Sample              setLocation()            Sets the current record's "Location" value
 * @method Sample              setEnvironment()         Sets the current record's "Environment" value
 * @method Sample              setHabitat()             Sets the current record's "Habitat" value
 * @method Sample              setRadiation()           Sets the current record's "Radiation" value
 * @method Sample              setCollector()           Sets the current record's "Collector" value
 * @method Sample              setFieldPictures()       Sets the current record's "FieldPictures" collection
 * @method Sample              setDetailedPictures()    Sets the current record's "DetailedPictures" collection
 * @method Sample              setMicroscopicPictures() Sets the current record's "MicroscopicPictures" collection
 * @method Sample              setStrains()             Sets the current record's "Strains" collection
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
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
        $this->hasColumn('notebook_code', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('location_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('latitude', 'string', 10, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => 10,
             ));
        $this->hasColumn('longitude', 'string', 10, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => 10,
             ));
        $this->hasColumn('environment_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('is_extremophile', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
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
        $this->hasColumn('altitude', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('radiation_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('collector_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('collection_date', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             ));
        $this->hasColumn('remarks', 'string', null, array(
             'type' => 'string',
             ));


        $this->index('sample_notebook_code', array(
             'fields' => 
             array(
              0 => 'notebook_code',
             ),
             ));
        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Location', array(
             'local' => 'location_id',
             'foreign' => 'id'));

        $this->hasOne('Environment', array(
             'local' => 'environment_id',
             'foreign' => 'id'));

        $this->hasOne('Habitat', array(
             'local' => 'habitat_id',
             'foreign' => 'id'));

        $this->hasOne('Radiation', array(
             'local' => 'radiation_id',
             'foreign' => 'id'));

        $this->hasOne('Collector', array(
             'local' => 'collector_id',
             'foreign' => 'id'));

        $this->hasMany('FieldPicture as FieldPictures', array(
             'local' => 'id',
             'foreign' => 'sample_id'));

        $this->hasMany('DetailedPicture as DetailedPictures', array(
             'local' => 'id',
             'foreign' => 'sample_id'));

        $this->hasMany('MicroscopicPicture as MicroscopicPictures', array(
             'local' => 'id',
             'foreign' => 'sample_id'));

        $this->hasMany('Strain as Strains', array(
             'local' => 'id',
             'foreign' => 'sample_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $date0 = new Date();
        $this->actAs($timestampable0);
        $this->actAs($date0);
    }
}