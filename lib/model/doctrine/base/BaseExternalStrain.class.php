<?php

/**
 * BaseExternalStrain
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $taxonomic_class_id
 * @property integer $genus_id
 * @property integer $species_id
 * @property integer $authority_id
 * @property boolean $is_epitype
 * @property boolean $is_axenic
 * @property boolean $has_dna
 * @property integer $location_id
 * @property integer $environment_id
 * @property integer $habitat_id
 * @property date $collection_date
 * @property date $isolation_date
 * @property integer $identifier_id
 * @property integer $supervisor_id
 * @property integer $cryopreservation_method_id
 * @property string $transfer_interval
 * @property string $observation
 * @property string $citations
 * @property string $remarks
 * @property integer $container_id
 * @property TaxonomicClass $TaxonomicClass
 * @property Genus $Genus
 * @property Species $Species
 * @property Authority $Authority
 * @property Location $Location
 * @property Environment $Environment
 * @property Habitat $Habitat
 * @property Identifier $Identifier
 * @property sfGuardUser $Supervisor
 * @property CryopreservationMethod $CryopreservationMethod
 * @property Container $Container
 * @property Doctrine_Collection $Containers
 * @property Doctrine_Collection $CultureMedia
 * @property Doctrine_Collection $MaintenanceStatus
 * @property Doctrine_Collection $Isolators
 * @property Doctrine_Collection $Projects
 * @property Doctrine_Collection $Relatives
 * @property Doctrine_Collection $ExternalStrainContainers
 * @property Doctrine_Collection $ExternalStrainCultureMedia
 * @property Doctrine_Collection $ExternalStrainIsolators
 * @property Doctrine_Collection $ExternalStrainMaintenanceStatus
 * @property Doctrine_Collection $Isolations
 * @property Doctrine_Collection $Cryopreservations
 * 
 * @method integer                getId()                              Returns the current record's "id" value
 * @method integer                getTaxonomicClassId()                Returns the current record's "taxonomic_class_id" value
 * @method integer                getGenusId()                         Returns the current record's "genus_id" value
 * @method integer                getSpeciesId()                       Returns the current record's "species_id" value
 * @method integer                getAuthorityId()                     Returns the current record's "authority_id" value
 * @method boolean                getIsEpitype()                       Returns the current record's "is_epitype" value
 * @method boolean                getIsAxenic()                        Returns the current record's "is_axenic" value
 * @method boolean                getHasDna()                          Returns the current record's "has_dna" value
 * @method integer                getLocationId()                      Returns the current record's "location_id" value
 * @method integer                getEnvironmentId()                   Returns the current record's "environment_id" value
 * @method integer                getHabitatId()                       Returns the current record's "habitat_id" value
 * @method date                   getCollectionDate()                  Returns the current record's "collection_date" value
 * @method date                   getIsolationDate()                   Returns the current record's "isolation_date" value
 * @method integer                getIdentifierId()                    Returns the current record's "identifier_id" value
 * @method integer                getSupervisorId()                    Returns the current record's "supervisor_id" value
 * @method integer                getCryopreservationMethodId()        Returns the current record's "cryopreservation_method_id" value
 * @method string                 getTransferInterval()                Returns the current record's "transfer_interval" value
 * @method string                 getObservation()                     Returns the current record's "observation" value
 * @method string                 getCitations()                       Returns the current record's "citations" value
 * @method string                 getRemarks()                         Returns the current record's "remarks" value
 * @method integer                getContainerId()                     Returns the current record's "container_id" value
 * @method TaxonomicClass         getTaxonomicClass()                  Returns the current record's "TaxonomicClass" value
 * @method Genus                  getGenus()                           Returns the current record's "Genus" value
 * @method Species                getSpecies()                         Returns the current record's "Species" value
 * @method Authority              getAuthority()                       Returns the current record's "Authority" value
 * @method Location               getLocation()                        Returns the current record's "Location" value
 * @method Environment            getEnvironment()                     Returns the current record's "Environment" value
 * @method Habitat                getHabitat()                         Returns the current record's "Habitat" value
 * @method Identifier             getIdentifier()                      Returns the current record's "Identifier" value
 * @method sfGuardUser            getSupervisor()                      Returns the current record's "Supervisor" value
 * @method CryopreservationMethod getCryopreservationMethod()          Returns the current record's "CryopreservationMethod" value
 * @method Container              getContainer()                       Returns the current record's "Container" value
 * @method Doctrine_Collection    getContainers()                      Returns the current record's "Containers" collection
 * @method Doctrine_Collection    getCultureMedia()                    Returns the current record's "CultureMedia" collection
 * @method Doctrine_Collection    getMaintenanceStatus()               Returns the current record's "MaintenanceStatus" collection
 * @method Doctrine_Collection    getIsolators()                       Returns the current record's "Isolators" collection
 * @method Doctrine_Collection    getProjects()                        Returns the current record's "Projects" collection
 * @method Doctrine_Collection    getRelatives()                       Returns the current record's "Relatives" collection
 * @method Doctrine_Collection    getExternalStrainContainers()        Returns the current record's "ExternalStrainContainers" collection
 * @method Doctrine_Collection    getExternalStrainCultureMedia()      Returns the current record's "ExternalStrainCultureMedia" collection
 * @method Doctrine_Collection    getExternalStrainIsolators()         Returns the current record's "ExternalStrainIsolators" collection
 * @method Doctrine_Collection    getExternalStrainMaintenanceStatus() Returns the current record's "ExternalStrainMaintenanceStatus" collection
 * @method Doctrine_Collection    getIsolations()                      Returns the current record's "Isolations" collection
 * @method Doctrine_Collection    getCryopreservations()               Returns the current record's "Cryopreservations" collection
 * @method ExternalStrain         setId()                              Sets the current record's "id" value
 * @method ExternalStrain         setTaxonomicClassId()                Sets the current record's "taxonomic_class_id" value
 * @method ExternalStrain         setGenusId()                         Sets the current record's "genus_id" value
 * @method ExternalStrain         setSpeciesId()                       Sets the current record's "species_id" value
 * @method ExternalStrain         setAuthorityId()                     Sets the current record's "authority_id" value
 * @method ExternalStrain         setIsEpitype()                       Sets the current record's "is_epitype" value
 * @method ExternalStrain         setIsAxenic()                        Sets the current record's "is_axenic" value
 * @method ExternalStrain         setHasDna()                          Sets the current record's "has_dna" value
 * @method ExternalStrain         setLocationId()                      Sets the current record's "location_id" value
 * @method ExternalStrain         setEnvironmentId()                   Sets the current record's "environment_id" value
 * @method ExternalStrain         setHabitatId()                       Sets the current record's "habitat_id" value
 * @method ExternalStrain         setCollectionDate()                  Sets the current record's "collection_date" value
 * @method ExternalStrain         setIsolationDate()                   Sets the current record's "isolation_date" value
 * @method ExternalStrain         setIdentifierId()                    Sets the current record's "identifier_id" value
 * @method ExternalStrain         setSupervisorId()                    Sets the current record's "supervisor_id" value
 * @method ExternalStrain         setCryopreservationMethodId()        Sets the current record's "cryopreservation_method_id" value
 * @method ExternalStrain         setTransferInterval()                Sets the current record's "transfer_interval" value
 * @method ExternalStrain         setObservation()                     Sets the current record's "observation" value
 * @method ExternalStrain         setCitations()                       Sets the current record's "citations" value
 * @method ExternalStrain         setRemarks()                         Sets the current record's "remarks" value
 * @method ExternalStrain         setContainerId()                     Sets the current record's "container_id" value
 * @method ExternalStrain         setTaxonomicClass()                  Sets the current record's "TaxonomicClass" value
 * @method ExternalStrain         setGenus()                           Sets the current record's "Genus" value
 * @method ExternalStrain         setSpecies()                         Sets the current record's "Species" value
 * @method ExternalStrain         setAuthority()                       Sets the current record's "Authority" value
 * @method ExternalStrain         setLocation()                        Sets the current record's "Location" value
 * @method ExternalStrain         setEnvironment()                     Sets the current record's "Environment" value
 * @method ExternalStrain         setHabitat()                         Sets the current record's "Habitat" value
 * @method ExternalStrain         setIdentifier()                      Sets the current record's "Identifier" value
 * @method ExternalStrain         setSupervisor()                      Sets the current record's "Supervisor" value
 * @method ExternalStrain         setCryopreservationMethod()          Sets the current record's "CryopreservationMethod" value
 * @method ExternalStrain         setContainer()                       Sets the current record's "Container" value
 * @method ExternalStrain         setContainers()                      Sets the current record's "Containers" collection
 * @method ExternalStrain         setCultureMedia()                    Sets the current record's "CultureMedia" collection
 * @method ExternalStrain         setMaintenanceStatus()               Sets the current record's "MaintenanceStatus" collection
 * @method ExternalStrain         setIsolators()                       Sets the current record's "Isolators" collection
 * @method ExternalStrain         setProjects()                        Sets the current record's "Projects" collection
 * @method ExternalStrain         setRelatives()                       Sets the current record's "Relatives" collection
 * @method ExternalStrain         setExternalStrainContainers()        Sets the current record's "ExternalStrainContainers" collection
 * @method ExternalStrain         setExternalStrainCultureMedia()      Sets the current record's "ExternalStrainCultureMedia" collection
 * @method ExternalStrain         setExternalStrainIsolators()         Sets the current record's "ExternalStrainIsolators" collection
 * @method ExternalStrain         setExternalStrainMaintenanceStatus() Sets the current record's "ExternalStrainMaintenanceStatus" collection
 * @method ExternalStrain         setIsolations()                      Sets the current record's "Isolations" collection
 * @method ExternalStrain         setCryopreservations()               Sets the current record's "Cryopreservations" collection
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseExternalStrain extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('external_strain');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
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
        $this->hasColumn('has_dna', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('location_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('environment_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('habitat_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('collection_date', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('isolation_date', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('identifier_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('supervisor_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('cryopreservation_method_id', 'integer', null, array(
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
        $this->hasColumn('remarks', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('container_id', 'integer', null, array(
             'type' => 'integer',
             ));

        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
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

        $this->hasOne('Location', array(
             'local' => 'location_id',
             'foreign' => 'id'));

        $this->hasOne('Environment', array(
             'local' => 'environment_id',
             'foreign' => 'id'));

        $this->hasOne('Habitat', array(
             'local' => 'habitat_id',
             'foreign' => 'id'));

        $this->hasOne('Identifier', array(
             'local' => 'identifier_id',
             'foreign' => 'id'));

        $this->hasOne('sfGuardUser as Supervisor', array(
             'local' => 'supervisor_id',
             'foreign' => 'id'));

        $this->hasOne('CryopreservationMethod', array(
             'local' => 'cryopreservation_method_id',
             'foreign' => 'id'));

        $this->hasOne('Container', array(
             'local' => 'container_id',
             'foreign' => 'id'));

        $this->hasMany('Container as Containers', array(
             'refClass' => 'ExternalStrainContainers',
             'local' => 'external_strain_id',
             'foreign' => 'container_id'));

        $this->hasMany('CultureMedium as CultureMedia', array(
             'refClass' => 'ExternalStrainCultureMedia',
             'local' => 'external_strain_id',
             'foreign' => 'culture_medium_id'));

        $this->hasMany('MaintenanceStatus', array(
             'refClass' => 'ExternalStrainMaintenanceStatus',
             'local' => 'external_strain_id',
             'foreign' => 'maintenance_status_id'));

        $this->hasMany('Isolator as Isolators', array(
             'refClass' => 'ExternalStrainIsolators',
             'local' => 'external_strain_id',
             'foreign' => 'isolator_id'));

        $this->hasMany('Project as Projects', array(
             'local' => 'id',
             'foreign' => 'external_strain_id'));

        $this->hasMany('ExternalStrainRelative as Relatives', array(
             'local' => 'id',
             'foreign' => 'external_strain_id'));

        $this->hasMany('ExternalStrainContainers', array(
             'local' => 'id',
             'foreign' => 'external_strain_id'));

        $this->hasMany('ExternalStrainCultureMedia', array(
             'local' => 'id',
             'foreign' => 'external_strain_id'));

        $this->hasMany('ExternalStrainIsolators', array(
             'local' => 'id',
             'foreign' => 'external_strain_id'));

        $this->hasMany('ExternalStrainMaintenanceStatus', array(
             'local' => 'id',
             'foreign' => 'external_strain_id'));

        $this->hasMany('Isolation as Isolations', array(
             'local' => 'id',
             'foreign' => 'external_strain_id'));

        $this->hasMany('Cryopreservation as Cryopreservations', array(
             'local' => 'id',
             'foreign' => 'external_strain_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $date0 = new Date();
        $this->actAs($timestampable0);
        $this->actAs($date0);
    }
}