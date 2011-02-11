<?php

/**
 * BaseUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property integer $role_id
 * @property Role $Role
 * @property Sample $Samples
 * 
 * @method integer getId()       Returns the current record's "id" value
 * @method string  getUsername() Returns the current record's "username" value
 * @method string  getPassword() Returns the current record's "password" value
 * @method string  getName()     Returns the current record's "name" value
 * @method string  getSurname()  Returns the current record's "surname" value
 * @method string  getEmail()    Returns the current record's "email" value
 * @method integer getRoleId()   Returns the current record's "role_id" value
 * @method Role    getRole()     Returns the current record's "Role" value
 * @method Sample  getSamples()  Returns the current record's "Samples" value
 * @method User    setId()       Sets the current record's "id" value
 * @method User    setUsername() Sets the current record's "username" value
 * @method User    setPassword() Sets the current record's "password" value
 * @method User    setName()     Sets the current record's "name" value
 * @method User    setSurname()  Sets the current record's "surname" value
 * @method User    setEmail()    Sets the current record's "email" value
 * @method User    setRoleId()   Sets the current record's "role_id" value
 * @method User    setRole()     Sets the current record's "Role" value
 * @method User    setSamples()  Sets the current record's "Samples" value
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseUser extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('user');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('username', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('password', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('name', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('surname', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('email', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('role_id', 'integer', null, array(
             'type' => 'integer',
             ));

        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Role', array(
             'local' => 'role_id',
             'foreign' => 'id'));

        $this->hasOne('Sample as Samples', array(
             'local' => 'id',
             'foreign' => 'collector_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}