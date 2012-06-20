<?php

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
 * @package    ACM
 * @subpackage model
 * @author     
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
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