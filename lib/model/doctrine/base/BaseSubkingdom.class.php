<?php

/**
 * BaseSubkingdom
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property Doctrine_Collection $Strains
 * @property Doctrine_Collection $ExternalStrains
 * 
 * @method integer             getId()              Returns the current record's "id" value
 * @method string              getName()            Returns the current record's "name" value
 * @method Doctrine_Collection getStrains()         Returns the current record's "Strains" collection
 * @method Doctrine_Collection getExternalStrains() Returns the current record's "ExternalStrains" collection
 * @method Subkingdom          setId()              Sets the current record's "id" value
 * @method Subkingdom          setName()            Sets the current record's "name" value
 * @method Subkingdom          setStrains()         Sets the current record's "Strains" collection
 * @method Subkingdom          setExternalStrains() Sets the current record's "ExternalStrains" collection
 * 
 * @package    ACM
 * @subpackage model
 * @author     
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSubkingdom extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('subkingdom');
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


        $this->index('subkingdom_name', array(
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
             'foreign' => 'subkingdom_id'));

        $this->hasMany('ExternalStrain as ExternalStrains', array(
             'local' => 'id',
             'foreign' => 'subkingdom_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}