<?php

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
 * @package    ACM
 * @subpackage model
 * @author     
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
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