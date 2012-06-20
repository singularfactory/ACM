<?php

/**
 * BaseExternalStrainCultureMedia
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $external_strain_id
 * @property integer $culture_medium_id
 * @property ExternalStrain $ExternalStrain
 * 
 * @method integer                    getExternalStrainId()   Returns the current record's "external_strain_id" value
 * @method integer                    getCultureMediumId()    Returns the current record's "culture_medium_id" value
 * @method ExternalStrain             getExternalStrain()     Returns the current record's "ExternalStrain" value
 * @method ExternalStrainCultureMedia setExternalStrainId()   Sets the current record's "external_strain_id" value
 * @method ExternalStrainCultureMedia setCultureMediumId()    Sets the current record's "culture_medium_id" value
 * @method ExternalStrainCultureMedia setExternalStrain()     Sets the current record's "ExternalStrain" value
 * 
 * @package    ACM
 * @subpackage model
 * @author     
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseExternalStrainCultureMedia extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('external_strain_culture_media');
        $this->hasColumn('external_strain_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('culture_medium_id', 'integer', null, array(
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