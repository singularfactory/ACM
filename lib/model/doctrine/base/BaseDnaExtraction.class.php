<?php

/**
 * BaseDnaExtraction
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $strain_id
 * @property boolean $is_public
 * @property date $arrival_date
 * @property date $extraction_date
 * @property integer $extraction_kit_id
 * @property decimal $concentration
 * @property decimal $260_280_ratio
 * @property decimal $260_230_ratio
 * @property integer $aliquots
 * @property string $genbank_link
 * @property string $remarks
 * @property Strain $Strain
 * @property ExtractionKit $ExtractionKit
 * @property Doctrine_Collection $Pcr
 * 
 * @method integer             getId()                Returns the current record's "id" value
 * @method integer             getStrainId()          Returns the current record's "strain_id" value
 * @method boolean             getIsPublic()          Returns the current record's "is_public" value
 * @method date                getArrivalDate()       Returns the current record's "arrival_date" value
 * @method date                getExtractionDate()    Returns the current record's "extraction_date" value
 * @method integer             getExtractionKitId()   Returns the current record's "extraction_kit_id" value
 * @method decimal             getConcentration()     Returns the current record's "concentration" value
 * @method decimal             get260280Ratio()       Returns the current record's "260_280_ratio" value
 * @method decimal             get260230Ratio()       Returns the current record's "260_230_ratio" value
 * @method decimal             getPreservation()      Returns the current record's "Preservation" value
 * @method integer             getAliquots()          Returns the current record's "aliquots" value
 * @method string              getGenbankLink()       Returns the current record's "genbank_link" value
 * @method string              getRemarks()           Returns the current record's "remarks" value
 * @method Strain              getStrain()            Returns the current record's "Strain" value
 * @method ExtractionKit       getExtractionKit()     Returns the current record's "ExtractionKit" value
 * @method Doctrine_Collection getPcr()               Returns the current record's "Pcr" collection
 * @method DnaExtraction       setId()                Sets the current record's "id" value
 * @method DnaExtraction       setStrainId()          Sets the current record's "strain_id" value
 * @method DnaExtraction       setIsPublic()          Sets the current record's "is_public" value
 * @method DnaExtraction       setArrivalDate()       Sets the current record's "arrival_date" value
 * @method DnaExtraction       setExtractionDate()    Sets the current record's "extraction_date" value
 * @method DnaExtraction       setExtractionKitId()   Sets the current record's "extraction_kit_id" value
 * @method DnaExtraction       setConcentration()     Sets the current record's "concentration" value
 * @method DnaExtraction       setPreservation()      Sets the current record's "preservation" value
 * @method DnaExtraction       set260280Ratio()       Sets the current record's "260_280_ratio" value
 * @method DnaExtraction       set260230Ratio()       Sets the current record's "260_230_ratio" value
 * @method DnaExtraction       setAliquots()          Sets the current record's "aliquots" value
 * @method DnaExtraction       setGenbankLink()       Sets the current record's "genbank_link" value
 * @method DnaExtraction       setRemarks()           Sets the current record's "remarks" value
 * @method DnaExtraction       setStrain()            Sets the current record's "Strain" value
 * @method DnaExtraction       setExtractionKit()     Sets the current record's "ExtractionKit" value
 * @method DnaExtraction       setPcr()               Sets the current record's "Pcr" collection
 * 
 * @package    ACM
 * @subpackage model
 * @author     
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseDnaExtraction extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('dna_extraction');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('strain_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('is_public', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('arrival_date', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             ));
        $this->hasColumn('extraction_date', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('extraction_kit_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('concentration', 'decimal', null, array(
             'type' => 'decimal',
             ));
        $this->hasColumn('260_280_ratio', 'decimal', null, array(
             'type' => 'decimal',
             ));
        $this->hasColumn('260_230_ratio', 'decimal', null, array(
             'type' => 'decimal',
             ));
        $this->hasColumn('preservation', 'decimal', null, array(
             'type' => 'decimal',
             ));
        $this->hasColumn('aliquots', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('genbank_link', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('remarks', 'string', null, array(
             'type' => 'string',
             ));


        $this->index('dna_extraction_date1', array(
             'fields' => 
             array(
              0 => 'extraction_date',
             ),
             ));
        $this->index('dna_extraction_date2', array(
             'fields' => 
             array(
              0 => 'arrival_date',
             ),
             ));
        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Strain', array(
             'local' => 'strain_id',
             'foreign' => 'id',
             'onUpdate' => 'cascade'));

        $this->hasOne('ExtractionKit', array(
             'local' => 'extraction_kit_id',
             'foreign' => 'id'));

        $this->hasMany('Pcr', array(
             'local' => 'id',
             'foreign' => 'dna_extraction_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $date0 = new Date();
        $this->actAs($timestampable0);
        $this->actAs($date0);
    }
}