<?php

/**
 * BaseCultureMedium
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $link
 * @property boolean $is_public
 * @property integer $amount
 * @property Doctrine_Collection $Strains
 * 
 * @method integer             getId()          Returns the current record's "id" value
 * @method string              getName()        Returns the current record's "name" value
 * @method string              getDescription() Returns the current record's "description" value
 * @method string              getLink()        Returns the current record's "link" value
 * @method boolean             getIsPublic()    Returns the current record's "is_public" value
 * @method integer             getAmount()      Returns the current record's "amount" value
 * @method Doctrine_Collection getStrains()     Returns the current record's "Strains" collection
 * @method CultureMedium       setId()          Sets the current record's "id" value
 * @method CultureMedium       setName()        Sets the current record's "name" value
 * @method CultureMedium       setDescription() Sets the current record's "description" value
 * @method CultureMedium       setLink()        Sets the current record's "link" value
 * @method CultureMedium       setIsPublic()    Sets the current record's "is_public" value
 * @method CultureMedium       setAmount()      Sets the current record's "amount" value
 * @method CultureMedium       setStrains()     Sets the current record's "Strains" collection
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCultureMedium extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('culture_medium');
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
        $this->hasColumn('description', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('link', 'string', 1024, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 1024,
             ));
        $this->hasColumn('is_public', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('amount', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             ));

        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Strain as Strains', array(
             'refClass' => 'StrainCultureMedia',
             'local' => 'culture_medium_id',
             'foreign' => 'strain_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}