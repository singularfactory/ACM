<?php

/**
 * BaseProject
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $project_name_id
 * @property integer $petitioner_id
 * @property enum $subject
 * @property integer $strain_id
 * @property integer $sample_id
 * @property integer $external_strain_id
 * @property float $amount
 * @property integer $provider_id
 * @property date $inoculation_date
 * @property string $purpose
 * @property date $delivery_date
 * @property string $remarks
 * @property ProjectName $ProjectName
 * @property Sample $Sample
 * @property Strain $Strain
 * @property ExternalStrain $ExternalStrain
 * @property sfGuardUser $Provider
 * @property Petitioners $Petitioner
 * 
 * @method integer        getId()                 Returns the current record's "id" value
 * @method integer        getProjectNameId()      Returns the current record's "project_name_id" value
 * @method integer        getPetitionerId()       Returns the current record's "petitioner_id" value
 * @method enum           getSubject()            Returns the current record's "subject" value
 * @method integer        getStrainId()           Returns the current record's "strain_id" value
 * @method integer        getSampleId()           Returns the current record's "sample_id" value
 * @method integer        getExternalStrainId()   Returns the current record's "external_strain_id" value
 * @method float          getAmount()             Returns the current record's "amount" value
 * @method integer        getProviderId()         Returns the current record's "provider_id" value
 * @method date           getInoculationDate()    Returns the current record's "inoculation_date" value
 * @method string         getPurpose()            Returns the current record's "purpose" value
 * @method date           getDeliveryDate()       Returns the current record's "delivery_date" value
 * @method string         getRemarks()            Returns the current record's "remarks" value
 * @method ProjectName    getProjectName()        Returns the current record's "ProjectName" value
 * @method Sample         getSample()             Returns the current record's "Sample" value
 * @method Strain         getStrain()             Returns the current record's "Strain" value
 * @method ExternalStrain getExternalStrain()     Returns the current record's "ExternalStrain" value
 * @method sfGuardUser    getProvider()           Returns the current record's "Provider" value
 * @method Petitioners    getPetitioner()         Returns the current record's "Petitioner" value
 * @method Project        setId()                 Sets the current record's "id" value
 * @method Project        setProjectNameId()      Sets the current record's "project_name_id" value
 * @method Project        setPetitionerId()       Sets the current record's "petitioner_id" value
 * @method Project        setSubject()            Sets the current record's "subject" value
 * @method Project        setStrainId()           Sets the current record's "strain_id" value
 * @method Project        setSampleId()           Sets the current record's "sample_id" value
 * @method Project        setExternalStrainId()   Sets the current record's "external_strain_id" value
 * @method Project        setAmount()             Sets the current record's "amount" value
 * @method Project        setProviderId()         Sets the current record's "provider_id" value
 * @method Project        setInoculationDate()    Sets the current record's "inoculation_date" value
 * @method Project        setPurpose()            Sets the current record's "purpose" value
 * @method Project        setDeliveryDate()       Sets the current record's "delivery_date" value
 * @method Project        setRemarks()            Sets the current record's "remarks" value
 * @method Project        setProjectName()        Sets the current record's "ProjectName" value
 * @method Project        setSample()             Sets the current record's "Sample" value
 * @method Project        setStrain()             Sets the current record's "Strain" value
 * @method Project        setExternalStrain()     Sets the current record's "ExternalStrain" value
 * @method Project        setProvider()           Sets the current record's "Provider" value
 * @method Project        setPetitioner()         Sets the current record's "Petitioner" value
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseProject extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('project');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('project_name_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('petitioner_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('subject', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'sample',
              1 => 'strain',
              2 => 'external_strain',
             ),
             ));
        $this->hasColumn('strain_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('sample_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('external_strain_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('amount', 'float', null, array(
             'type' => 'float',
             'notnull' => true,
             'default' => 0,
             ));
        $this->hasColumn('provider_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('inoculation_date', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             ));
        $this->hasColumn('purpose', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('delivery_date', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('remarks', 'string', null, array(
             'type' => 'string',
             ));


        $this->index('project_inoculation_date', array(
             'fields' => 
             array(
              0 => 'inoculation_date',
             ),
             ));
        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('ProjectName', array(
             'local' => 'project_name_id',
             'foreign' => 'id'));

        $this->hasOne('Sample', array(
             'local' => 'sample_id',
             'foreign' => 'id'));

        $this->hasOne('Strain', array(
             'local' => 'strain_id',
             'foreign' => 'id',
             'onUpdate' => 'cascade'));

        $this->hasOne('ExternalStrain', array(
             'local' => 'external_strain_id',
             'foreign' => 'id'));

        $this->hasOne('sfGuardUser as Provider', array(
             'local' => 'provider_id',
             'foreign' => 'id'));

        $this->hasOne('Petitioners as Petitioner', array(
             'local' => 'petitioner_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $date0 = new Date();
        $this->actAs($timestampable0);
        $this->actAs($date0);
    }
}