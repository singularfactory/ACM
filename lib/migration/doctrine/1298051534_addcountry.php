<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addcountry extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('country', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => true,
              'autoincrement' => true,
              'length' => 8,
             ),
             'code' => 
             array(
              'type' => 'string',
              'fixed' => 1,
              'notnull' => true,
              'length' => 3,
             ),
             'name' => 
             array(
              'type' => 'string',
              'notnull' => true,
              'length' => 60,
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
        $this->dropTable('country');
    }
}