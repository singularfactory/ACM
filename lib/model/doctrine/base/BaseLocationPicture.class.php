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
 * BaseLocationPicture
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @property integer $id
 * @property string $filename
 * @property integer $location_id
 * @property Location $Location
 *
 * @method integer         getId()          Returns the current record's "id" value
 * @method string          getFilename()    Returns the current record's "filename" value
 * @method integer         getLocationId()  Returns the current record's "location_id" value
 * @method Location        getLocation()    Returns the current record's "Location" value
 * @method LocationPicture setId()          Sets the current record's "id" value
 * @method LocationPicture setFilename()    Sets the current record's "filename" value
 * @method LocationPicture setLocationId()  Sets the current record's "location_id" value
 * @method LocationPicture setLocation()    Sets the current record's "Location" value
 *
 * @package ACM.Lib.Model
 * @since 1.0
 */
abstract class BaseLocationPicture extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('location_picture');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('filename', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('location_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));

        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Location', array(
             'local' => 'location_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $picture0 = new Picture(array(
             'moduleName' => 'location',
             ));
        $this->actAs($timestampable0);
        $this->actAs($picture0);
    }
}