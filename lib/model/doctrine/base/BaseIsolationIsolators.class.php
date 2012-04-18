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
 * BaseIsolationIsolators
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @property integer $isolation_id
 * @property integer $isolator_id
 * @property Isolation $Isolation
 *
 * @method integer            getIsolationId()  Returns the current record's "isolation_id" value
 * @method integer            getIsolatorId()   Returns the current record's "isolator_id" value
 * @method Isolation          getIsolation()    Returns the current record's "Isolation" value
 * @method IsolationIsolators setIsolationId()  Sets the current record's "isolation_id" value
 * @method IsolationIsolators setIsolatorId()   Sets the current record's "isolator_id" value
 * @method IsolationIsolators setIsolation()    Sets the current record's "Isolation" value
 *
 * @package ACM.Lib.Model
 * @since 1.0
 */
abstract class BaseIsolationIsolators extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('isolation_isolators');
        $this->hasColumn('isolation_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('isolator_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));

        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Isolation', array(
             'local' => 'isolation_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}