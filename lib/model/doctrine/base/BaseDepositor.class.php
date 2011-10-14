<?php

/**
 * BaseDepositor
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property Doctrine_Collection $PatentDeposits
 * @property Doctrine_Collection $MaintenanceDeposits
 * 
 * @method integer             getId()                  Returns the current record's "id" value
 * @method string              getName()                Returns the current record's "name" value
 * @method string              getSurname()             Returns the current record's "surname" value
 * @method string              getEmail()               Returns the current record's "email" value
 * @method Doctrine_Collection getPatentDeposits()      Returns the current record's "PatentDeposits" collection
 * @method Doctrine_Collection getMaintenanceDeposits() Returns the current record's "MaintenanceDeposits" collection
 * @method Depositor           setId()                  Sets the current record's "id" value
 * @method Depositor           setName()                Sets the current record's "name" value
 * @method Depositor           setSurname()             Sets the current record's "surname" value
 * @method Depositor           setEmail()               Sets the current record's "email" value
 * @method Depositor           setPatentDeposits()      Sets the current record's "PatentDeposits" collection
 * @method Depositor           setMaintenanceDeposits() Sets the current record's "MaintenanceDeposits" collection
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseDepositor extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('depositor');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('name', 'string', 127, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 127,
             ));
        $this->hasColumn('surname', 'string', 127, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 127,
             ));
        $this->hasColumn('email', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));


        $this->index('depositor_name', array(
             'fields' => 
             array(
              'name' => 
              array(
              'length' => 20,
              ),
             ),
             ));
        $this->index('depositor_surname', array(
             'fields' => 
             array(
              'surname' => 
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
        $this->hasMany('PatentDeposit as PatentDeposits', array(
             'local' => 'id',
             'foreign' => 'depositor_id'));

        $this->hasMany('MaintenanceDeposit as MaintenanceDeposits', array(
             'local' => 'id',
             'foreign' => 'depositor_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}