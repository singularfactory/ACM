<?php

/**
 * BaseEcosystem
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $city
 * @property integer $province_id
 * @property string $lanscape_picture
 * @property Province $Province
 * @property Doctrine_Collection $Samples
 * 
 * @method integer             getId()               Returns the current record's "id" value
 * @method string              getName()             Returns the current record's "name" value
 * @method string              getCity()             Returns the current record's "city" value
 * @method integer             getProvinceId()       Returns the current record's "province_id" value
 * @method string              getLanscapePicture()  Returns the current record's "lanscape_picture" value
 * @method Province            getProvince()         Returns the current record's "Province" value
 * @method Doctrine_Collection getSamples()          Returns the current record's "Samples" collection
 * @method Ecosystem           setId()               Sets the current record's "id" value
 * @method Ecosystem           setName()             Sets the current record's "name" value
 * @method Ecosystem           setCity()             Sets the current record's "city" value
 * @method Ecosystem           setProvinceId()       Sets the current record's "province_id" value
 * @method Ecosystem           setLanscapePicture()  Sets the current record's "lanscape_picture" value
 * @method Ecosystem           setProvince()         Sets the current record's "Province" value
 * @method Ecosystem           setSamples()          Sets the current record's "Samples" collection
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseEcosystem extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('ecosystem');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('name', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('city', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('province_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('lanscape_picture', 'string', null, array(
             'type' => 'string',
             ));

        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Province', array(
             'local' => 'province_id',
             'foreign' => 'id'));

        $this->hasMany('Sample as Samples', array(
             'local' => 'id',
             'foreign' => 'ecosystem_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}