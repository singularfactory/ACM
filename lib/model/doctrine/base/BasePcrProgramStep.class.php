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
 * BasePcrProgramStep
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @property integer $id
 * @property integer $segment
 * @property decimal $temperature
 * @property time $duration
 * @property integer $pcr_program_id
 * @property PcrProgram $PcrProgram
 *
 * @method integer        getId()             Returns the current record's "id" value
 * @method integer        getSegment()        Returns the current record's "segment" value
 * @method decimal        getTemperature()    Returns the current record's "temperature" value
 * @method time           getDuration()       Returns the current record's "duration" value
 * @method integer        getPcrProgramId()   Returns the current record's "pcr_program_id" value
 * @method PcrProgram     getPcrProgram()     Returns the current record's "PcrProgram" value
 * @method PcrProgramStep setId()             Sets the current record's "id" value
 * @method PcrProgramStep setSegment()        Sets the current record's "segment" value
 * @method PcrProgramStep setTemperature()    Sets the current record's "temperature" value
 * @method PcrProgramStep setDuration()       Sets the current record's "duration" value
 * @method PcrProgramStep setPcrProgramId()   Sets the current record's "pcr_program_id" value
 * @method PcrProgramStep setPcrProgram()     Sets the current record's "PcrProgram" value
 *
 * @package ACM.Lib.Model
 * @since 1.0
 */
abstract class BasePcrProgramStep extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('pcr_program_step');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('segment', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('temperature', 'decimal', null, array(
             'type' => 'decimal',
             'notnull' => true,
             ));
        $this->hasColumn('duration', 'time', null, array(
             'type' => 'time',
             'notnull' => true,
             ));
        $this->hasColumn('pcr_program_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));

        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('PcrProgram', array(
             'local' => 'pcr_program_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}