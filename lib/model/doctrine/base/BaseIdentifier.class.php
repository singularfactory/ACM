<?php

/**
 * BaseIdentifier
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property Doctrine_Collection $Strains
 * @property Doctrine_Collection $PatentDeposits
 * @property Doctrine_Collection $MaintenanceDeposits
 * @property Doctrine_Collection $ExternalStrains
 * 
 * @method integer             getId()                  Returns the current record's "id" value
 * @method string              getName()                Returns the current record's "name" value
 * @method string              getSurname()             Returns the current record's "surname" value
 * @method string              getEmail()               Returns the current record's "email" value
 * @method Doctrine_Collection getStrains()             Returns the current record's "Strains" collection
 * @method Doctrine_Collection getPatentDeposits()      Returns the current record's "PatentDeposits" collection
 * @method Doctrine_Collection getMaintenanceDeposits() Returns the current record's "MaintenanceDeposits" collection
 * @method Doctrine_Collection getExternalStrains()     Returns the current record's "ExternalStrains" collection
 * @method Identifier          setId()                  Sets the current record's "id" value
 * @method Identifier          setName()                Sets the current record's "name" value
 * @method Identifier          setSurname()             Sets the current record's "surname" value
 * @method Identifier          setEmail()               Sets the current record's "email" value
 * @method Identifier          setStrains()             Sets the current record's "Strains" collection
 * @method Identifier          setPatentDeposits()      Sets the current record's "PatentDeposits" collection
 * @method Identifier          setMaintenanceDeposits() Sets the current record's "MaintenanceDeposits" collection
 * @method Identifier          setExternalStrains()     Sets the current record's "ExternalStrains" collection
 * 
 * @package    ACM
 * @subpackage model
 * @author     
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseIdentifier extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('identifier');
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
        $this->hasColumn('surname', 'string', 127, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 127,
             ));
        $this->hasColumn('email', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));


        $this->index('identifier_name', array(
             'fields' => 
             array(
              'name' => 
              array(
              'length' => 20,
              ),
             ),
             ));
        $this->index('identifier_surname', array(
             'fields' => 
             array(
              'surname' => 
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
             'foreign' => 'identifier_id'));

        $this->hasMany('PatentDeposit as PatentDeposits', array(
             'local' => 'id',
             'foreign' => 'identifier_id'));

        $this->hasMany('MaintenanceDeposit as MaintenanceDeposits', array(
             'local' => 'id',
             'foreign' => 'identifier_id'));

        $this->hasMany('ExternalStrain as ExternalStrains', array(
             'local' => 'id',
             'foreign' => 'identifier_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}