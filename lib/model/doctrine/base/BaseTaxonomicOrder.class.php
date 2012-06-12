<?php

/**
 * BaseTaxonomicOrder
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property Doctrine_Collection $Strains
 * 
 * @method integer             getId()      Returns the current record's "id" value
 * @method string              getName()    Returns the current record's "name" value
 * @method Doctrine_Collection getStrains() Returns the current record's "Strains" collection
 * @method TaxonomicOrder      setId()      Sets the current record's "id" value
 * @method TaxonomicOrder      setName()    Sets the current record's "name" value
 * @method TaxonomicOrder      setStrains() Sets the current record's "Strains" collection
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTaxonomicOrder extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('taxonomic_order');
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


        $this->index('taxonomic_order_name', array(
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
        $this->hasMany('Strain as Strains', array(
             'local' => 'id',
             'foreign' => 'taxonomic_order_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}