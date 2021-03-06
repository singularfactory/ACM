<?php

/**
 * BaseStrainIsolators
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $strain_id
 * @property integer $isolator_id
 * @property integer $sort_order
 * @property Strain $Strain
 * 
 * @method integer         getStrainId()    Returns the current record's "strain_id" value
 * @method integer         getIsolatorId()  Returns the current record's "isolator_id" value
 * @method integer         getSortOrder()   Returns the current record's "sort_order" value
 * @method Strain          getStrain()      Returns the current record's "Strain" value
 * @method StrainIsolators setStrainId()    Sets the current record's "strain_id" value
 * @method StrainIsolators setIsolatorId()  Sets the current record's "isolator_id" value
 * @method StrainIsolators setSortOrder()   Sets the current record's "sort_order" value
 * @method StrainIsolators setStrain()      Sets the current record's "Strain" value
 * 
 * @package    ACM
 * @subpackage model
 * @author     
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseStrainIsolators extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('strain_isolators');
        $this->hasColumn('strain_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('isolator_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('sort_order', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));


        $this->index('unique_order', array(
             'fields' => 
             array(
              0 => 'strain_id',
              1 => 'isolator_id',
              2 => 'sort_order',
             ),
             'type' => 'unique',
             ));
        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Strain', array(
             'local' => 'strain_id',
             'foreign' => 'id',
             'onDelete' => 'cascade',
             'onUpdate' => 'cascade'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}