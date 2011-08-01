<?php

/**
 * BasePcr
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $dna_extraction_id
 * @property integer $forward_dna_primer_id
 * @property integer $reverse_dna_primer_id
 * @property integer $dna_polymerase_id
 * @property integer $pcr_program_id
 * @property decimal $concentration
 * @property decimal $260_280_ratio
 * @property decimal $260_230_ratio
 * @property boolean $can_be_sequenced
 * @property string $remarks
 * @property DnaExtraction $DnaExtraction
 * @property DnaPolymerase $DnaPolymerase
 * @property DnaPrimer $ForwardPrimer
 * @property DnaPrimer $ReversePrimer
 * @property PcrProgram $PcrProgram
 * @property Doctrine_Collection $Gel
 * @property Doctrine_Collection $Sequence
 * 
 * @method integer             getId()                    Returns the current record's "id" value
 * @method integer             getDnaExtractionId()       Returns the current record's "dna_extraction_id" value
 * @method integer             getForwardDnaPrimerId()    Returns the current record's "forward_dna_primer_id" value
 * @method integer             getReverseDnaPrimerId()    Returns the current record's "reverse_dna_primer_id" value
 * @method integer             getDnaPolymeraseId()       Returns the current record's "dna_polymerase_id" value
 * @method integer             getPcrProgramId()          Returns the current record's "pcr_program_id" value
 * @method decimal             getConcentration()         Returns the current record's "concentration" value
 * @method decimal             get260280Ratio()           Returns the current record's "260_280_ratio" value
 * @method decimal             get260230Ratio()           Returns the current record's "260_230_ratio" value
 * @method boolean             getCanBeSequenced()        Returns the current record's "can_be_sequenced" value
 * @method string              getRemarks()               Returns the current record's "remarks" value
 * @method DnaExtraction       getDnaExtraction()         Returns the current record's "DnaExtraction" value
 * @method DnaPolymerase       getDnaPolymerase()         Returns the current record's "DnaPolymerase" value
 * @method DnaPrimer           getForwardPrimer()         Returns the current record's "ForwardPrimer" value
 * @method DnaPrimer           getReversePrimer()         Returns the current record's "ReversePrimer" value
 * @method PcrProgram          getPcrProgram()            Returns the current record's "PcrProgram" value
 * @method Doctrine_Collection getGel()                   Returns the current record's "Gel" collection
 * @method Doctrine_Collection getSequence()              Returns the current record's "Sequence" collection
 * @method Pcr                 setId()                    Sets the current record's "id" value
 * @method Pcr                 setDnaExtractionId()       Sets the current record's "dna_extraction_id" value
 * @method Pcr                 setForwardDnaPrimerId()    Sets the current record's "forward_dna_primer_id" value
 * @method Pcr                 setReverseDnaPrimerId()    Sets the current record's "reverse_dna_primer_id" value
 * @method Pcr                 setDnaPolymeraseId()       Sets the current record's "dna_polymerase_id" value
 * @method Pcr                 setPcrProgramId()          Sets the current record's "pcr_program_id" value
 * @method Pcr                 setConcentration()         Sets the current record's "concentration" value
 * @method Pcr                 set260280Ratio()           Sets the current record's "260_280_ratio" value
 * @method Pcr                 set260230Ratio()           Sets the current record's "260_230_ratio" value
 * @method Pcr                 setCanBeSequenced()        Sets the current record's "can_be_sequenced" value
 * @method Pcr                 setRemarks()               Sets the current record's "remarks" value
 * @method Pcr                 setDnaExtraction()         Sets the current record's "DnaExtraction" value
 * @method Pcr                 setDnaPolymerase()         Sets the current record's "DnaPolymerase" value
 * @method Pcr                 setForwardPrimer()         Sets the current record's "ForwardPrimer" value
 * @method Pcr                 setReversePrimer()         Sets the current record's "ReversePrimer" value
 * @method Pcr                 setPcrProgram()            Sets the current record's "PcrProgram" value
 * @method Pcr                 setGel()                   Sets the current record's "Gel" collection
 * @method Pcr                 setSequence()              Sets the current record's "Sequence" collection
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePcr extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('pcr');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('dna_extraction_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('forward_dna_primer_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('reverse_dna_primer_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('dna_polymerase_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('pcr_program_id', 'integer', null, array(
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
        $this->hasColumn('can_be_sequenced', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('remarks', 'string', null, array(
             'type' => 'string',
             ));

        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('DnaExtraction', array(
             'local' => 'dna_extraction_id',
             'foreign' => 'id'));

        $this->hasOne('DnaPolymerase', array(
             'local' => 'dna_polymerase_id',
             'foreign' => 'id'));

        $this->hasOne('DnaPrimer as ForwardPrimer', array(
             'local' => 'forward_dna_primer_id',
             'foreign' => 'id'));

        $this->hasOne('DnaPrimer as ReversePrimer', array(
             'local' => 'reverse_dna_primer_id',
             'foreign' => 'id'));

        $this->hasOne('PcrProgram', array(
             'local' => 'pcr_program_id',
             'foreign' => 'id'));

        $this->hasMany('PcrGel as Gel', array(
             'local' => 'id',
             'foreign' => 'pcr_id',
             'orderBy' => 'number'));

        $this->hasMany('DnaSequence as Sequence', array(
             'local' => 'id',
             'foreign' => 'pcr_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}