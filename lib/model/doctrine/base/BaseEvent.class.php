<?php

/**
 * BaseEvent
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $user_id
 * @property string $ip_address
 * @property string $module
 * @property string $action
 * @property string $description
 * @property sfGuardUser $User
 * 
 * @method integer     getId()          Returns the current record's "id" value
 * @method integer     getUserId()      Returns the current record's "user_id" value
 * @method string      getIpAddress()   Returns the current record's "ip_address" value
 * @method string      getModule()      Returns the current record's "module" value
 * @method string      getAction()      Returns the current record's "action" value
 * @method string      getDescription() Returns the current record's "description" value
 * @method sfGuardUser getUser()        Returns the current record's "User" value
 * @method Event       setId()          Sets the current record's "id" value
 * @method Event       setUserId()      Sets the current record's "user_id" value
 * @method Event       setIpAddress()   Sets the current record's "ip_address" value
 * @method Event       setModule()      Sets the current record's "module" value
 * @method Event       setAction()      Sets the current record's "action" value
 * @method Event       setDescription() Sets the current record's "description" value
 * @method Event       setUser()        Sets the current record's "User" value
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEvent extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('event');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('ip_address', 'string', 15, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 15,
             ));
        $this->hasColumn('module', 'string', 40, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 40,
             ));
        $this->hasColumn('action', 'string', 40, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 40,
             ));
        $this->hasColumn('description', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));

        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}