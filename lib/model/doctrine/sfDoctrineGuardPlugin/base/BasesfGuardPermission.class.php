<?php
/**
 * Model class
 *
 * acm : Algae Culture Management (https://github.com/singularfactory/ACM)
 * Copyright 2012, Singular Factory <info@singularfactory.com>
 *
 * This file is part of ACM
 *
 * ACM is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ACM is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ACM.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright     Copyright 2012, Singular Factory <info@singularfactory.com>
 * @package       ACM.Lib.Model
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */


/**
 * BasesfGuardPermission
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @property string $name
 * @property string $description
 * @property Doctrine_Collection $Groups
 * @property Doctrine_Collection $sfGuardGroupPermission
 * @property Doctrine_Collection $Users
 * @property Doctrine_Collection $sfGuardUserPermission
 *
 * @method string              getName()                   Returns the current record's "name" value
 * @method string              getDescription()            Returns the current record's "description" value
 * @method Doctrine_Collection getGroups()                 Returns the current record's "Groups" collection
 * @method Doctrine_Collection getSfGuardGroupPermission() Returns the current record's "sfGuardGroupPermission" collection
 * @method Doctrine_Collection getUsers()                  Returns the current record's "Users" collection
 * @method Doctrine_Collection getSfGuardUserPermission()  Returns the current record's "sfGuardUserPermission" collection
 * @method sfGuardPermission   setName()                   Sets the current record's "name" value
 * @method sfGuardPermission   setDescription()            Sets the current record's "description" value
 * @method sfGuardPermission   setGroups()                 Sets the current record's "Groups" collection
 * @method sfGuardPermission   setSfGuardGroupPermission() Sets the current record's "sfGuardGroupPermission" collection
 * @method sfGuardPermission   setUsers()                  Sets the current record's "Users" collection
 * @method sfGuardPermission   setSfGuardUserPermission()  Sets the current record's "sfGuardUserPermission" collection
 *
 * @package ACM.Lib.Model
 * @since 1.0
 */
abstract class BasesfGuardPermission extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('sf_guard_permission');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'unique' => true,
             'length' => 255,
             ));
        $this->hasColumn('description', 'string', 1000, array(
             'type' => 'string',
             'length' => 1000,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('sfGuardGroup as Groups', array(
             'refClass' => 'sfGuardGroupPermission',
             'local' => 'permission_id',
             'foreign' => 'group_id'));

        $this->hasMany('sfGuardGroupPermission', array(
             'local' => 'id',
             'foreign' => 'permission_id'));

        $this->hasMany('sfGuardUser as Users', array(
             'refClass' => 'sfGuardUserPermission',
             'local' => 'permission_id',
             'foreign' => 'user_id'));

        $this->hasMany('sfGuardUserPermission', array(
             'local' => 'id',
             'foreign' => 'permission_id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $this->actAs($timestampable0);
    }
}