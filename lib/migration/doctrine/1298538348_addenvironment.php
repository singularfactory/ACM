<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addenvironment extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('environment', array(
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
        $this->dropTable('environment');
    }
}