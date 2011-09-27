<?php

/**
 * BaseStrain
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $sample_id
 * @property boolean $is_epitype
 * @property boolean $is_axenic
 * @property boolean $is_public
 * @property integer $taxonomic_class_id
 * @property integer $genus_id
 * @property integer $species_id
 * @property integer $authority_id
 * @property integer $isolator_id
 * @property date $isolation_date
 * @property integer $depositor_id
 * @property date $deposition_date
 * @property integer $identifier_id
 * @property integer $maintenance_status_id
 * @property integer $cryopreservation_method_id
 * @property integer $container_id
 * @property string $transfer_interval
 * @property string $observation
 * @property string $citations
 * @property string $web_notes
 * @property string $remarks
 * @property Sample $Sample
 * @property TaxonomicClass $TaxonomicClass
 * @property Genus $Genus
 * @property Species $Species
 * @property Authority $Authority
 * @property Isolator $Isolator
 * @property Depositor $Depositor
 * @property Identifier $Identifier
 * @property MaintenanceStatus $MaintenanceStatus
 * @property CryopreservationMethod $CryopreservationMethod
 * @property Container $Container
 * @property Doctrine_Collection $CultureMedia
 * @property Doctrine_Collection $Relatives
 * @property Doctrine_Collection $AxenityTests
 * @property Doctrine_Collection $Pictures
 * @property Doctrine_Collection $StrainCultureMedia
 * @property Doctrine_Collection $DnaExtractions
 * 
 * @method integer                getId()                         Returns the current record's "id" value
 * @method integer                getSampleId()                   Returns the current record's "sample_id" value
 * @method boolean                getIsEpitype()                  Returns the current record's "is_epitype" value
 * @method boolean                getIsAxenic()                   Returns the current record's "is_axenic" value
 * @method boolean                getIsPublic()                   Returns the current record's "is_public" value
 * @method integer                getTaxonomicClassId()           Returns the current record's "taxonomic_class_id" value
 * @method integer                getGenusId()                    Returns the current record's "genus_id" value
 * @method integer                getSpeciesId()                  Returns the current record's "species_id" value
 * @method integer                getAuthorityId()                Returns the current record's "authority_id" value
 * @method integer                getIsolatorId()                 Returns the current record's "isolator_id" value
 * @method date                   getIsolationDate()              Returns the current record's "isolation_date" value
 * @method integer                getDepositorId()                Returns the current record's "depositor_id" value
 * @method date                   getDepositionDate()             Returns the current record's "deposition_date" value
 * @method integer                getIdentifierId()               Returns the current record's "identifier_id" value
 * @method integer                getMaintenanceStatusId()        Returns the current record's "maintenance_status_id" value
 * @method integer                getCryopreservationMethodId()   Returns the current record's "cryopreservation_method_id" value
 * @method integer                getContainerId()                Returns the current record's "container_id" value
 * @method string                 getTransferInterval()           Returns the current record's "transfer_interval" value
 * @method string                 getObservation()                Returns the current record's "observation" value
 * @method string                 getCitations()                  Returns the current record's "citations" value
 * @method string                 getWebNotes()                   Returns the current record's "web_notes" value
 * @method string                 getRemarks()                    Returns the current record's "remarks" value
 * @method Sample                 getSample()                     Returns the current record's "Sample" value
 * @method TaxonomicClass         getTaxonomicClass()             Returns the current record's "TaxonomicClass" value
 * @method Genus                  getGenus()                      Returns the current record's "Genus" value
 * @method Species                getSpecies()                    Returns the current record's "Species" value
 * @method Authority              getAuthority()                  Returns the current record's "Authority" value
 * @method Isolator               getIsolator()                   Returns the current record's "Isolator" value
 * @method Depositor              getDepositor()                  Returns the current record's "Depositor" value
 * @method Identifier             getIdentifier()                 Returns the current record's "Identifier" value
 * @method MaintenanceStatus      getMaintenanceStatus()          Returns the current record's "MaintenanceStatus" value
 * @method CryopreservationMethod getCryopreservationMethod()     Returns the current record's "CryopreservationMethod" value
 * @method Container              getContainer()                  Returns the current record's "Container" value
 * @method Doctrine_Collection    getCultureMedia()               Returns the current record's "CultureMedia" collection
 * @method Doctrine_Collection    getRelatives()                  Returns the current record's "Relatives" collection
 * @method Doctrine_Collection    getAxenityTests()               Returns the current record's "AxenityTests" collection
 * @method Doctrine_Collection    getPictures()                   Returns the current record's "Pictures" collection
 * @method Doctrine_Collection    getStrainCultureMedia()         Returns the current record's "StrainCultureMedia" collection
 * @method Doctrine_Collection    getDnaExtractions()             Returns the current record's "DnaExtractions" collection
 * @method Strain                 setId()                         Sets the current record's "id" value
 * @method Strain                 setSampleId()                   Sets the current record's "sample_id" value
 * @method Strain                 setIsEpitype()                  Sets the current record's "is_epitype" value
 * @method Strain                 setIsAxenic()                   Sets the current record's "is_axenic" value
 * @method Strain                 setIsPublic()                   Sets the current record's "is_public" value
 * @method Strain                 setTaxonomicClassId()           Sets the current record's "taxonomic_class_id" value
 * @method Strain                 setGenusId()                    Sets the current record's "genus_id" value
 * @method Strain                 setSpeciesId()                  Sets the current record's "species_id" value
 * @method Strain                 setAuthorityId()                Sets the current record's "authority_id" value
 * @method Strain                 setIsolatorId()                 Sets the current record's "isolator_id" value
 * @method Strain                 setIsolationDate()              Sets the current record's "isolation_date" value
 * @method Strain                 setDepositorId()                Sets the current record's "depositor_id" value
 * @method Strain                 setDepositionDate()             Sets the current record's "deposition_date" value
 * @method Strain                 setIdentifierId()               Sets the current record's "identifier_id" value
 * @method Strain                 setMaintenanceStatusId()        Sets the current record's "maintenance_status_id" value
 * @method Strain                 setCryopreservationMethodId()   Sets the current record's "cryopreservation_method_id" value
 * @method Strain                 setContainerId()                Sets the current record's "container_id" value
 * @method Strain                 setTransferInterval()           Sets the current record's "transfer_interval" value
 * @method Strain                 setObservation()                Sets the current record's "observation" value
 * @method Strain                 setCitations()                  Sets the current record's "citations" value
 * @method Strain                 setWebNotes()                   Sets the current record's "web_notes" value
 * @method Strain                 setRemarks()                    Sets the current record's "remarks" value
 * @method Strain                 setSample()                     Sets the current record's "Sample" value
 * @method Strain                 setTaxonomicClass()             Sets the current record's "TaxonomicClass" value
 * @method Strain                 setGenus()                      Sets the current record's "Genus" value
 * @method Strain                 setSpecies()                    Sets the current record's "Species" value
 * @method Strain                 setAuthority()                  Sets the current record's "Authority" value
 * @method Strain                 setIsolator()                   Sets the current record's "Isolator" value
 * @method Strain                 setDepositor()                  Sets the current record's "Depositor" value
 * @method Strain                 setIdentifier()                 Sets the current record's "Identifier" value
 * @method Strain                 setMaintenanceStatus()          Sets the current record's "MaintenanceStatus" value
 * @method Strain                 setCryopreservationMethod()     Sets the current record's "CryopreservationMethod" value
 * @method Strain                 setContainer()                  Sets the current record's "Container" value
 * @method Strain                 setCultureMedia()               Sets the current record's "CultureMedia" collection
 * @method Strain                 setRelatives()                  Sets the current record's "Relatives" collection
 * @method Strain                 setAxenityTests()               Sets the current record's "AxenityTests" collection
 * @method Strain                 setPictures()                   Sets the current record's "Pictures" collection
 * @method Strain                 setStrainCultureMedia()         Sets the current record's "StrainCultureMedia" collection
 * @method Strain                 setDnaExtractions()             Sets the current record's "DnaExtractions" collection
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseStrain extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('strain');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('sample_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('is_epitype', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('is_axenic', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('is_public', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('taxonomic_class_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('genus_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('species_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('authority_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('isolator_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('isolation_date', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             ));
        $this->hasColumn('depositor_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('deposition_date', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('identifier_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('maintenance_status_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('cryopreservation_method_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('container_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('transfer_interval', 'string', 40, array(
             'type' => 'string',
             'length' => 40,
             ));
        $this->hasColumn('observation', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('citations', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('web_notes', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('remarks', 'string', null, array(
             'type' => 'string',
             ));

        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Sample', array(
             'local' => 'sample_id',
             'foreign' => 'id'));

        $this->hasOne('TaxonomicClass', array(
             'local' => 'taxonomic_class_id',
             'foreign' => 'id'));

        $this->hasOne('Genus', array(
             'local' => 'genus_id',
             'foreign' => 'id'));

        $this->hasOne('Species', array(
             'local' => 'species_id',
             'foreign' => 'id'));

        $this->hasOne('Authority', array(
             'local' => 'authority_id',
             'foreign' => 'id'));

        $this->hasOne('Isolator', array(
             'local' => 'isolator_id',
             'foreign' => 'id'));

        $this->hasOne('Depositor', array(
             'local' => 'depositor_id',
             'foreign' => 'id'));

        $this->hasOne('Identifier', array(
             'local' => 'identifier_id',
             'foreign' => 'id'));

        $this->hasOne('MaintenanceStatus', array(
             'local' => 'maintenance_status_id',
             'foreign' => 'id'));

        $this->hasOne('CryopreservationMethod', array(
             'local' => 'cryopreservation_method_id',
             'foreign' => 'id'));

        $this->hasOne('Container', array(
             'local' => 'container_id',
             'foreign' => 'id'));

        $this->hasMany('CultureMedium as CultureMedia', array(
             'refClass' => 'StrainCultureMedia',
             'local' => 'strain_id',
             'foreign' => 'culture_medium_id'));

        $this->hasMany('StrainRelative as Relatives', array(
             'local' => 'id',
             'foreign' => 'strain_id'));

        $this->hasMany('AxenityTest as AxenityTests', array(
             'local' => 'id',
             'foreign' => 'strain_id'));

        $this->hasMany('StrainPicture as Pictures', array(
             'local' => 'id',
             'foreign' => 'strain_id'));

        $this->hasMany('StrainCultureMedia', array(
             'local' => 'id',
             'foreign' => 'strain_id'));

        $this->hasMany('DnaExtraction as DnaExtractions', array(
             'local' => 'id',
             'foreign' => 'strain_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $date0 = new Date();
        $this->actAs($timestampable0);
        $this->actAs($date0);
    }
}