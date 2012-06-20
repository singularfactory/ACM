<?php

/**
 * BaseStrainRelative
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property integer $strain_id
 * @property Strain $Strain
 * 
 * @method integer        getId()        Returns the current record's "id" value
 * @method string         getName()      Returns the current record's "name" value
 * @method integer        getStrainId()  Returns the current record's "strain_id" value
 * @method Strain         getStrain()    Returns the current record's "Strain" value
 * @method StrainRelative setId()        Sets the current record's "id" value
 * @method StrainRelative setName()      Sets the current record's "name" value
 * @method StrainRelative setStrainId()  Sets the current record's "strain_id" value
 * @method StrainRelative setStrain()    Sets the current record's "Strain" value
 * 
 * @package    ACM
 * @subpackage model
 * @author     
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseStrainRelative extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('strain_relative');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('strain_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));

        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Strain', array(
             'local' => 'strain_id',
             'foreign' => 'id',
             'onDelete' => 'cascade',
             'onUpdate' => 'cascade'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}