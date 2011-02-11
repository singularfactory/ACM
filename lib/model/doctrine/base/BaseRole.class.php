<?php

/**
 * BaseRole
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property Doctrine_Collection $Users
 * 
 * @method integer             getId()    Returns the current record's "id" value
 * @method string              getName()  Returns the current record's "name" value
 * @method Doctrine_Collection getUsers() Returns the current record's "Users" collection
 * @method Role                setId()    Sets the current record's "id" value
 * @method Role                setName()  Sets the current record's "name" value
 * @method Role                setUsers() Sets the current record's "Users" collection
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseRole extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('role');
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
        $this->hasMany('User as Users', array(
             'local' => 'id',
             'foreign' => 'role_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}