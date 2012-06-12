<?php

/**
 * BasePatentDepositCollectors
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $patent_deposit_id
 * @property integer $collector_id
 * @property PatentDeposit $PatentDeposit
 * 
 * @method integer                 getPatentDepositId()   Returns the current record's "patent_deposit_id" value
 * @method integer                 getCollectorId()       Returns the current record's "collector_id" value
 * @method PatentDeposit           getPatentDeposit()     Returns the current record's "PatentDeposit" value
 * @method PatentDepositCollectors setPatentDepositId()   Sets the current record's "patent_deposit_id" value
 * @method PatentDepositCollectors setCollectorId()       Sets the current record's "collector_id" value
 * @method PatentDepositCollectors setPatentDeposit()     Sets the current record's "PatentDeposit" value
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePatentDepositCollectors extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('patent_deposit_collectors');
        $this->hasColumn('patent_deposit_id', 'integer', null, array(
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
        $this->hasOne('PatentDeposit', array(
             'local' => 'patent_deposit_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}