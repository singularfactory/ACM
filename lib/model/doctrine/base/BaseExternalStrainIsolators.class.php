<?php

/**
 * BaseExternalStrainIsolators
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $external_strain_id
 * @property integer $isolator_id
 * @property ExternalStrain $ExternalStrain
 * 
 * @method integer                 getExternalStrainId()   Returns the current record's "external_strain_id" value
 * @method integer                 getIsolatorId()         Returns the current record's "isolator_id" value
 * @method ExternalStrain          getExternalStrain()     Returns the current record's "ExternalStrain" value
 * @method ExternalStrainIsolators setExternalStrainId()   Sets the current record's "external_strain_id" value
 * @method ExternalStrainIsolators setIsolatorId()         Sets the current record's "isolator_id" value
 * @method ExternalStrainIsolators setExternalStrain()     Sets the current record's "ExternalStrain" value
 * 
 * @package    ACM
 * @subpackage model
 * @author     
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseExternalStrainIsolators extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('external_strain_isolators');
        $this->hasColumn('external_strain_id', 'integer', null, array(
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
        $this->hasOne('ExternalStrain', array(
             'local' => 'external_strain_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}