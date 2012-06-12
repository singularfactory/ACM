<?php

/**
 * BaseExternalStrainMaintenanceStatus
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $external_strain_id
 * @property integer $maintenance_status_id
 * @property ExternalStrain $ExternalStrain
 * 
 * @method integer                         getExternalStrainId()      Returns the current record's "external_strain_id" value
 * @method integer                         getMaintenanceStatusId()   Returns the current record's "maintenance_status_id" value
 * @method ExternalStrain                  getExternalStrain()        Returns the current record's "ExternalStrain" value
 * @method ExternalStrainMaintenanceStatus setExternalStrainId()      Sets the current record's "external_strain_id" value
 * @method ExternalStrainMaintenanceStatus setMaintenanceStatusId()   Sets the current record's "maintenance_status_id" value
 * @method ExternalStrainMaintenanceStatus setExternalStrain()        Sets the current record's "ExternalStrain" value
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseExternalStrainMaintenanceStatus extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('external_strain_maintenance_status');
        $this->hasColumn('external_strain_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('maintenance_status_id', 'integer', null, array(
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