<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addsample extends Doctrine_Migration_Base {
    public function up() {
        $this->createTable('sample', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => true,
              'autoincrement' => true,
              'length' => 8,
             ),
             'location_id' => 
             array(
              'type' => 'integer',
              'notnull' => true,
              'length' => 8,
             ),
             'latitude' => 
             array(
              'type' => 'string',
              'fixed' => 1,
              'length' => 10,
             ),
             'longitude' => 
             array(
              'type' => 'string',
              'fixed' => 1,
              'length' => 10,
             ),
             'environment_id' => 
             array(
              'type' => 'integer',
              'notnull' => true,
              'length' => 8,
             ),
             'habitat_id' => 
             array(
              'type' => 'integer',
              'notnull' => true,
              'length' => 8,
             ),
             'ph' => 
             array(
              'type' => 'float',
              'length' => NULL,
             ),
             'conductivity' => 
             array(
              'type' => 'float',
              'length' => NULL,
             ),
             'temperature' => 
             array(
              'type' => 'float',
              'length' => NULL,
             ),
             'salinity' => 
             array(
              'type' => 'float',
              'length' => NULL,
             ),
             'altitude' => 
             array(
              'type' => 'float',
              'length' => NULL,
             ),
             'radiation_id' => 
             array(
              'type' => 'integer',
              'notnull' => true,
              'length' => 8,
             ),
             'field_picture' => 
             array(
              'type' => 'string',
              'length' => 255,
             ),
             'detailed_picture' => 
             array(
              'type' => 'string',
              'length' => 255,
             ),
             'microscopic_picture' => 
             array(
              'type' => 'string',
              'length' => 255,
             ),
             'collector_id' => 
             array(
              'type' => 'integer',
              'notnull' => true,
              'length' => 8,
             ),
             'collection_date' => 
             array(
              'type' => 'date',
              'notnull' => true,
              'length' => 25,
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

    public function down() {
        $this->dropTable('sample');
    }
}