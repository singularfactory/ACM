<?php

/**
 * BaseLocation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $latitude
 * @property string $longitude
 * @property integer $country_id
 * @property integer $region_id
 * @property integer $island_id
 * @property string $remarks
 * @property Country $Country
 * @property Region $Region
 * @property Island $Island
 * @property Doctrine_Collection $Pictures
 * @property Doctrine_Collection $Samples
 * 
 * @method integer             getId()         Returns the current record's "id" value
 * @method string              getName()       Returns the current record's "name" value
 * @method string              getLatitude()   Returns the current record's "latitude" value
 * @method string              getLongitude()  Returns the current record's "longitude" value
 * @method integer             getCountryId()  Returns the current record's "country_id" value
 * @method integer             getRegionId()   Returns the current record's "region_id" value
 * @method integer             getIslandId()   Returns the current record's "island_id" value
 * @method string              getRemarks()    Returns the current record's "remarks" value
 * @method Country             getCountry()    Returns the current record's "Country" value
 * @method Region              getRegion()     Returns the current record's "Region" value
 * @method Island              getIsland()     Returns the current record's "Island" value
 * @method Doctrine_Collection getPictures()   Returns the current record's "Pictures" collection
 * @method Doctrine_Collection getSamples()    Returns the current record's "Samples" collection
 * @method Location            setId()         Sets the current record's "id" value
 * @method Location            setName()       Sets the current record's "name" value
 * @method Location            setLatitude()   Sets the current record's "latitude" value
 * @method Location            setLongitude()  Sets the current record's "longitude" value
 * @method Location            setCountryId()  Sets the current record's "country_id" value
 * @method Location            setRegionId()   Sets the current record's "region_id" value
 * @method Location            setIslandId()   Sets the current record's "island_id" value
 * @method Location            setRemarks()    Sets the current record's "remarks" value
 * @method Location            setCountry()    Sets the current record's "Country" value
 * @method Location            setRegion()     Sets the current record's "Region" value
 * @method Location            setIsland()     Sets the current record's "Island" value
 * @method Location            setPictures()   Sets the current record's "Pictures" collection
 * @method Location            setSamples()    Sets the current record's "Samples" collection
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseLocation extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('location');
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
        $this->hasColumn('country_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('region_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('island_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('remarks', 'string', null, array(
             'type' => 'string',
             ));

        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Country', array(
             'local' => 'country_id',
             'foreign' => 'id'));

        $this->hasOne('Region', array(
             'local' => 'region_id',
             'foreign' => 'id'));

        $this->hasOne('Island', array(
             'local' => 'island_id',
             'foreign' => 'id'));

        $this->hasMany('LocationPicture as Pictures', array(
             'local' => 'id',
             'foreign' => 'location_id'));

        $this->hasMany('Sample as Samples', array(
             'local' => 'id',
             'foreign' => 'location_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}