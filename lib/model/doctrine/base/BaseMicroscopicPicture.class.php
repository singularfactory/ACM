<?php

/**
 * BaseMicroscopicPicture
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $filename
 * @property integer $sample_id
 * @property Sample $Sample
 * 
 * @method integer            getId()        Returns the current record's "id" value
 * @method string             getFilename()  Returns the current record's "filename" value
 * @method integer            getSampleId()  Returns the current record's "sample_id" value
 * @method Sample             getSample()    Returns the current record's "Sample" value
 * @method MicroscopicPicture setId()        Sets the current record's "id" value
 * @method MicroscopicPicture setFilename()  Sets the current record's "filename" value
 * @method MicroscopicPicture setSampleId()  Sets the current record's "sample_id" value
 * @method MicroscopicPicture setSample()    Sets the current record's "Sample" value
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseMicroscopicPicture extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('microscopic_picture');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('filename', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('sample_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));

        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Sample', array(
             'local' => 'sample_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $picture0 = new Picture(array(
             'moduleName' => 'sample',
             ));
        $this->actAs($timestampable0);
        $this->actAs($picture0);
    }
}