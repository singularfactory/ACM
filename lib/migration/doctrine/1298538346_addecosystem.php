<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addecosystem extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('ecosystem', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => true,
              'autoincrement' => true,
              'length' => 8,
             ),
             'name' => 
             array(
              'type' => 'string',
              'notnull' => true,
              'length' => 255,
             ),
             'latitude_degrees' => 
             array(
              'type' => 'integer',
              'length' => 8,
             ),
             'longitude_degrees' => 
             array(
              'type' => 'integer',
              'length' => 8,
             ),
             'latitude_minutes' => 
             array(
              'type' => 'float',
              'length' => NULL,
             ),
             'longitude_minutes' => 
             array(
              'type' => 'float',
              'length' => NULL,
             ),
             'country_id' => 
             array(
              'type' => 'integer',
              'notnull' => true,
              'length' => 8,
             ),
             'province_id' => 
             array(
              'type' => 'integer',
              'length' => 8,
             ),
             'city' => 
             array(
              'type' => 'string',
              'notnull' => true,
              'length' => 255,
             ),
             'remarks' => 
             array(
              'type' => 'string',
              'length' => NULL,
             ),
             'created_at' => 
             array(
              'notnull' => true,
              'type' => 'timestamp',
              'length' => 25,
             ),
             'updated_at' => 
             array(
              'notnull' => true,
              'type' => 'timestamp',
              'length' => 25,
             ),
             ), array(
             'type' => 'INNODB',
             'indexes' => 
             array(
             ),
             'primary' => 
             array(
              0 => 'id',
             ),
             ));
    }

    public function down()
    {
        $this->dropTable('ecosystem');
    }
}