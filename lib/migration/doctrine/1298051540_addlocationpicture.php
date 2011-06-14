<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addlocationpicture extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('location_picture', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => true,
              'autoincrement' => true,
              'length' => 8,
             ),
             'filename' => 
             array(
              'type' => 'string',
              'notnull' => true,
              'length' => 255,
             ),
             'location_id' => 
             array(
              'type' => 'integer',
              'notnull' => true,
              'length' => 8,
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
        $this->dropTable('location_picture');
    }
}