<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addcollector extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('collector', array(
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
              'length' => 127,
             ),
             'surname' => 
             array(
              'type' => 'string',
              'notnull' => true,
              'length' => 127,
             ),
             'email' => 
             array(
              'type' => 'string',
              'length' => 255,
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
        $this->dropTable('collector');
    }
}