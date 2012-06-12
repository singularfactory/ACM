<?php

/**
 * BaseDnaPolymerase
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property Doctrine_Collection $Pcr
 * 
 * @method integer             getId()   Returns the current record's "id" value
 * @method string              getName() Returns the current record's "name" value
 * @method Doctrine_Collection getPcr()  Returns the current record's "Pcr" collection
 * @method DnaPolymerase       setId()   Sets the current record's "id" value
 * @method DnaPolymerase       setName() Sets the current record's "name" value
 * @method DnaPolymerase       setPcr()  Sets the current record's "Pcr" collection
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseDnaPolymerase extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('dna_polymerase');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('name', 'string', 127, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 127,
             ));


        $this->index('dna_polymerase_name', array(
             'fields' => 
             array(
              'name' => 
              array(
              'length' => 20,
              ),
             ),
             ));
        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Pcr', array(
             'local' => 'id',
             'foreign' => 'dna_polymerase_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}