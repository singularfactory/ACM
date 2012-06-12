<?php

/**
 * BaseProjectName
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $obligations
 * @property Doctrine_Collection $Projects
 * 
 * @method integer             getId()          Returns the current record's "id" value
 * @method string              getName()        Returns the current record's "name" value
 * @method string              getDescription() Returns the current record's "description" value
 * @method string              getObligations() Returns the current record's "obligations" value
 * @method Doctrine_Collection getProjects()    Returns the current record's "Projects" collection
 * @method ProjectName         setId()          Sets the current record's "id" value
 * @method ProjectName         setName()        Sets the current record's "name" value
 * @method ProjectName         setDescription() Sets the current record's "description" value
 * @method ProjectName         setObligations() Sets the current record's "obligations" value
 * @method ProjectName         setProjects()    Sets the current record's "Projects" collection
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseProjectName extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('project_name');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('name', 'string', 200, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 200,
             ));
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('obligations', 'string', null, array(
             'type' => 'string',
             ));


        $this->index('project_name_name', array(
             'fields' => 
             array(
              0 => 'name',
             ),
             ));
        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Project as Projects', array(
             'local' => 'id',
             'foreign' => 'project_name_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}