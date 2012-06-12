<?php

/**
 * BaseIdentification
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property date $identification_date
 * @property integer $sample_id
 * @property string $petitioner
 * @property string $sample_picture
 * @property string $microscopy_identification
 * @property string $molecular_identification
 * @property string $request_document
 * @property string $report_document
 * @property string $remarks
 * @property Sample $Sample
 * 
 * @method integer        getId()                        Returns the current record's "id" value
 * @method date           getIdentificationDate()        Returns the current record's "identification_date" value
 * @method integer        getSampleId()                  Returns the current record's "sample_id" value
 * @method string         getPetitioner()                Returns the current record's "petitioner" value
 * @method string         getSamplePicture()             Returns the current record's "sample_picture" value
 * @method string         getMicroscopyIdentification()  Returns the current record's "microscopy_identification" value
 * @method string         getMolecularIdentification()   Returns the current record's "molecular_identification" value
 * @method string         getRequestDocument()           Returns the current record's "request_document" value
 * @method string         getReportDocument()            Returns the current record's "report_document" value
 * @method string         getRemarks()                   Returns the current record's "remarks" value
 * @method Sample         getSample()                    Returns the current record's "Sample" value
 * @method Identification setId()                        Sets the current record's "id" value
 * @method Identification setIdentificationDate()        Sets the current record's "identification_date" value
 * @method Identification setSampleId()                  Sets the current record's "sample_id" value
 * @method Identification setPetitioner()                Sets the current record's "petitioner" value
 * @method Identification setSamplePicture()             Sets the current record's "sample_picture" value
 * @method Identification setMicroscopyIdentification()  Sets the current record's "microscopy_identification" value
 * @method Identification setMolecularIdentification()   Sets the current record's "molecular_identification" value
 * @method Identification setRequestDocument()           Sets the current record's "request_document" value
 * @method Identification setReportDocument()            Sets the current record's "report_document" value
 * @method Identification setRemarks()                   Sets the current record's "remarks" value
 * @method Identification setSample()                    Sets the current record's "Sample" value
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseIdentification extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('identification');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('identification_date', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             ));
        $this->hasColumn('sample_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('petitioner', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('sample_picture', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('microscopy_identification', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('molecular_identification', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('request_document', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('report_document', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('remarks', 'string', null, array(
             'type' => 'string',
             ));


        $this->index('identification_date', array(
             'fields' => 
             array(
              0 => 'identification_date',
             ),
             ));
        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Sample', array(
             'local' => 'sample_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $date0 = new Date();
        $picture0 = new Picture(array(
             'moduleName' => 'identification',
             ));
        $this->actAs($timestampable0);
        $this->actAs($date0);
        $this->actAs($picture0);
    }
}