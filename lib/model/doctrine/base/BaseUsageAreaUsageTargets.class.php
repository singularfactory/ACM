<?php

/**
 * BaseUsageAreaUsageTargets
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $usage_area_id
 * @property integer $usage_target_id
 * @property UsageArea $UsageArea
 * @property UsageTarget $UsageTarget
 * @property Doctrine_Collection $StrainTaxonomies
 * 
 * @method integer               getId()               Returns the current record's "id" value
 * @method integer               getUsageAreaId()      Returns the current record's "usage_area_id" value
 * @method integer               getUsageTargetId()    Returns the current record's "usage_target_id" value
 * @method UsageArea             getUsageArea()        Returns the current record's "UsageArea" value
 * @method UsageTarget           getUsageTarget()      Returns the current record's "UsageTarget" value
 * @method Doctrine_Collection   getStrainTaxonomies() Returns the current record's "StrainTaxonomies" collection
 * @method UsageAreaUsageTargets setId()               Sets the current record's "id" value
 * @method UsageAreaUsageTargets setUsageAreaId()      Sets the current record's "usage_area_id" value
 * @method UsageAreaUsageTargets setUsageTargetId()    Sets the current record's "usage_target_id" value
 * @method UsageAreaUsageTargets setUsageArea()        Sets the current record's "UsageArea" value
 * @method UsageAreaUsageTargets setUsageTarget()      Sets the current record's "UsageTarget" value
 * @method UsageAreaUsageTargets setStrainTaxonomies() Sets the current record's "StrainTaxonomies" collection
 * 
 * @package    ACM
 * @subpackage model
 * @author     
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseUsageAreaUsageTargets extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('usage_area_usage_targets');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('usage_area_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('usage_target_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));


        $this->index('unique_usage', array(
             'fields' => 
             array(
              0 => 'usage_area_id',
              1 => 'usage_target_id',
             ),
             'type' => 'unique',
             ));
        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('UsageArea', array(
             'local' => 'usage_area_id',
             'foreign' => 'id',
             'onDelete' => 'cascade',
             'onUpdate' => 'cascade',
             'orderBy' => 'name'));

        $this->hasOne('UsageTarget', array(
             'local' => 'usage_target_id',
             'foreign' => 'id',
             'onDelete' => 'cascade',
             'onUpdate' => 'cascade',
             'orderBy' => 'name'));

        $this->hasMany('StrainTaxonomy as StrainTaxonomies', array(
             'refClass' => 'PotentialUsages',
             'local' => 'usage_id',
             'foreign' => 'strain_taxonomy_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}