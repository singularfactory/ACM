<?php

/**
 * BaseCountry
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property Doctrine_Collection $Provinces
 * 
 * @method integer             getId()        Returns the current record's "id" value
 * @method string              getName()      Returns the current record's "name" value
 * @method Doctrine_Collection getProvinces() Returns the current record's "Provinces" collection
 * @method Country             setId()        Sets the current record's "id" value
 * @method Country             setName()      Sets the current record's "name" value
 * @method Country             setProvinces() Sets the current record's "Provinces" collection
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseCountry extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('country');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('name', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));

        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Province as Provinces', array(
             'local' => 'id',
             'foreign' => 'country_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}