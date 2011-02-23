<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version6 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('ecosystem_picture', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '8',
             ),
             'name' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '255',
             ),
             'ecosystem_id' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '8',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'type' => 'INNODB',
             'primary' => 
             array(
              0 => 'id',
             ),
             ));
        $this->removeColumn('ecosystem', 'picture_1');
        $this->removeColumn('ecosystem', 'picture_2');
        $this->removeColumn('ecosystem', 'picture_3');
        $this->removeColumn('ecosystem', 'picture_4');
        $this->removeColumn('ecosystem', 'picture_5');
    }

    public function down()
    {
        $this->dropTable('ecosystem_picture');
        $this->addColumn('ecosystem', 'picture_1', 'string', '255', array(
             ));
        $this->addColumn('ecosystem', 'picture_2', 'string', '255', array(
             ));
        $this->addColumn('ecosystem', 'picture_3', 'string', '255', array(
             ));
        $this->addColumn('ecosystem', 'picture_4', 'string', '255', array(
             ));
        $this->addColumn('ecosystem', 'picture_5', 'string', '255', array(
             ));
    }
}