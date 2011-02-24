<?php

/**
 * BaseCountry
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property Doctrine_Collection $Ecosystems
 * 
 * @method integer             getId()         Returns the current record's "id" value
 * @method string              getName()       Returns the current record's "name" value
 * @method Doctrine_Collection getEcosystems() Returns the current record's "Ecosystems" collection
 * @method Country             setId()         Sets the current record's "id" value
 * @method Country             setName()       Sets the current record's "name" value
 * @method Country             setEcosystems() Sets the current record's "Ecosystems" collection
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
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));

        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Ecosystem as Ecosystems', array(
             'local' => 'id',
             'foreign' => 'country_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}