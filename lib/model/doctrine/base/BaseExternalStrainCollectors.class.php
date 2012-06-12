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
 * BaseExternalStrainCollectors
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @property integer $external_strain_id
 * @property integer $collector_id
 * @property ExternalStrain $ExternalStrain
 *
 * @method integer                  getExternalStrainId()   Returns the current record's "external_strain_id" value
 * @method integer                  getCollectorId()        Returns the current record's "collector_id" value
 * @method ExternalStrain           getExternalStrain()     Returns the current record's "ExternalStrain" value
 * @method ExternalStrainCollectors setExternalStrainId()   Sets the current record's "external_strain_id" value
 * @method ExternalStrainCollectors setCollectorId()        Sets the current record's "collector_id" value
 * @method ExternalStrainCollectors setExternalStrain()     Sets the current record's "ExternalStrain" value
 *
 * @package ACM.Lib.Model
 * @since 1.0
 */
abstract class BaseExternalStrainCollectors extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('external_strain_collectors');
        $this->hasColumn('external_strain_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('collector_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));

        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('ExternalStrain', array(
             'local' => 'external_strain_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}