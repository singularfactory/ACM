<?php

/**
 * BaseIsolation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property date $reception_date
 * @property enum $isolation_subject
 * @property integer $sample_id
 * @property integer $strain_id
 * @property string $external_code
 * @property integer $taxonomic_class_id
 * @property integer $genus_id
 * @property integer $species_id
 * @property integer $authority_id
 * @property integer $location_id
 * @property integer $environment_id
 * @property integer $habitat_id
 * @property date $delivery_date
 * @property integer $purification_method_id
 * @property string $purification_details
 * @property string $observation
 * @property string $remarks
 * @property Sample $Sample
 * @property Strain $Strain
 * @property TaxonomicClass $TaxonomicClass
 * @property Genus $Genus
 * @property Species $Species
 * @property Authority $Authority
 * @property Location $Location
 * @property Environment $Environment
 * @property Habitat $Habitat
 * @property PurificationMethod $PurificationMethod
 * @property Doctrine_Collection $Isolators
 * @property Doctrine_Collection $CultureMedia
 * @property Doctrine_Collection $IsolationCultureMedia
 * @property Doctrine_Collection $IsolationIsolators
 * 
 * @method integer             getId()                     Returns the current record's "id" value
 * @method date                getReceptionDate()          Returns the current record's "reception_date" value
 * @method enum                getIsolationSubject()       Returns the current record's "isolation_subject" value
 * @method integer             getSampleId()               Returns the current record's "sample_id" value
 * @method integer             getStrainId()               Returns the current record's "strain_id" value
 * @method string              getExternalCode()           Returns the current record's "external_code" value
 * @method integer             getTaxonomicClassId()       Returns the current record's "taxonomic_class_id" value
 * @method integer             getGenusId()                Returns the current record's "genus_id" value
 * @method integer             getSpeciesId()              Returns the current record's "species_id" value
 * @method integer             getAuthorityId()            Returns the current record's "authority_id" value
 * @method integer             getLocationId()             Returns the current record's "location_id" value
 * @method integer             getEnvironmentId()          Returns the current record's "environment_id" value
 * @method integer             getHabitatId()              Returns the current record's "habitat_id" value
 * @method date                getDeliveryDate()           Returns the current record's "delivery_date" value
 * @method integer             getPurificationMethodId()   Returns the current record's "purification_method_id" value
 * @method string              getPurificationDetails()    Returns the current record's "purification_details" value
 * @method string              getObservation()            Returns the current record's "observation" value
 * @method string              getRemarks()                Returns the current record's "remarks" value
 * @method Sample              getSample()                 Returns the current record's "Sample" value
 * @method Strain              getStrain()                 Returns the current record's "Strain" value
 * @method TaxonomicClass      getTaxonomicClass()         Returns the current record's "TaxonomicClass" value
 * @method Genus               getGenus()                  Returns the current record's "Genus" value
 * @method Species             getSpecies()                Returns the current record's "Species" value
 * @method Authority           getAuthority()              Returns the current record's "Authority" value
 * @method Location            getLocation()               Returns the current record's "Location" value
 * @method Environment         getEnvironment()            Returns the current record's "Environment" value
 * @method Habitat             getHabitat()                Returns the current record's "Habitat" value
 * @method PurificationMethod  getPurificationMethod()     Returns the current record's "PurificationMethod" value
 * @method Doctrine_Collection getIsolators()              Returns the current record's "Isolators" collection
 * @method Doctrine_Collection getCultureMedia()           Returns the current record's "CultureMedia" collection
 * @method Doctrine_Collection getIsolationCultureMedia()  Returns the current record's "IsolationCultureMedia" collection
 * @method Doctrine_Collection getIsolationIsolators()     Returns the current record's "IsolationIsolators" collection
 * @method Isolation           setId()                     Sets the current record's "id" value
 * @method Isolation           setReceptionDate()          Sets the current record's "reception_date" value
 * @method Isolation           setIsolationSubject()       Sets the current record's "isolation_subject" value
 * @method Isolation           setSampleId()               Sets the current record's "sample_id" value
 * @method Isolation           setStrainId()               Sets the current record's "strain_id" value
 * @method Isolation           setExternalCode()           Sets the current record's "external_code" value
 * @method Isolation           setTaxonomicClassId()       Sets the current record's "taxonomic_class_id" value
 * @method Isolation           setGenusId()                Sets the current record's "genus_id" value
 * @method Isolation           setSpeciesId()              Sets the current record's "species_id" value
 * @method Isolation           setAuthorityId()            Sets the current record's "authority_id" value
 * @method Isolation           setLocationId()             Sets the current record's "location_id" value
 * @method Isolation           setEnvironmentId()          Sets the current record's "environment_id" value
 * @method Isolation           setHabitatId()              Sets the current record's "habitat_id" value
 * @method Isolation           setDeliveryDate()           Sets the current record's "delivery_date" value
 * @method Isolation           setPurificationMethodId()   Sets the current record's "purification_method_id" value
 * @method Isolation           setPurificationDetails()    Sets the current record's "purification_details" value
 * @method Isolation           setObservation()            Sets the current record's "observation" value
 * @method Isolation           setRemarks()                Sets the current record's "remarks" value
 * @method Isolation           setSample()                 Sets the current record's "Sample" value
 * @method Isolation           setStrain()                 Sets the current record's "Strain" value
 * @method Isolation           setTaxonomicClass()         Sets the current record's "TaxonomicClass" value
 * @method Isolation           setGenus()                  Sets the current record's "Genus" value
 * @method Isolation           setSpecies()                Sets the current record's "Species" value
 * @method Isolation           setAuthority()              Sets the current record's "Authority" value
 * @method Isolation           setLocation()               Sets the current record's "Location" value
 * @method Isolation           setEnvironment()            Sets the current record's "Environment" value
 * @method Isolation           setHabitat()                Sets the current record's "Habitat" value
 * @method Isolation           setPurificationMethod()     Sets the current record's "PurificationMethod" value
 * @method Isolation           setIsolators()              Sets the current record's "Isolators" collection
 * @method Isolation           setCultureMedia()           Sets the current record's "CultureMedia" collection
 * @method Isolation           setIsolationCultureMedia()  Sets the current record's "IsolationCultureMedia" collection
 * @method Isolation           setIsolationIsolators()     Sets the current record's "IsolationIsolators" collection
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseIsolation extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('isolation');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('reception_date', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             ));
        $this->hasColumn('isolation_subject', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'sample',
              1 => 'strain',
              2 => 'external',
             ),
             ));
        $this->hasColumn('sample_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('strain_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('external_code', 'string', 128, array(
             'type' => 'string',
             'length' => 128,
             ));
        $this->hasColumn('taxonomic_class_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('genus_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('species_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('authority_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('location_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('environment_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('habitat_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('delivery_date', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('purification_method_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('purification_details', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('observation', 'string', null, array(
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

        $this->hasOne('Strain', array(
             'local' => 'strain_id',
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

        $this->hasOne('Location', array(
             'local' => 'location_id',
             'foreign' => 'id'));

        $this->hasOne('Environment', array(
             'local' => 'environment_id',
             'foreign' => 'id'));

        $this->hasOne('Habitat', array(
             'local' => 'habitat_id',
             'foreign' => 'id'));

        $this->hasOne('PurificationMethod', array(
             'local' => 'purification_method_id',
             'foreign' => 'id'));

        $this->hasMany('Isolator as Isolators', array(
             'refClass' => 'IsolationIsolators',
             'local' => 'isolation_id',
             'foreign' => 'isolator_id'));

        $this->hasMany('CultureMedium as CultureMedia', array(
             'refClass' => 'IsolationCultureMedia',
             'local' => 'isolation_id',
             'foreign' => 'culture_medium_id'));

        $this->hasMany('IsolationCultureMedia', array(
             'local' => 'id',
             'foreign' => 'isolation_id'));

        $this->hasMany('IsolationIsolators', array(
             'local' => 'id',
             'foreign' => 'isolation_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $date0 = new Date();
        $this->actAs($timestampable0);
        $this->actAs($date0);
    }
}