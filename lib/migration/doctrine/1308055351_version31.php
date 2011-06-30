<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version31 extends Doctrine_Migration_Base {
    public function up() {
        $this->createTable('detailed_picture', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '8',
             ),
             'filename' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '255',
             ),
             'sample_id' => 
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
        $this->createTable('field_picture', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '8',
             ),
             'filename' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '255',
             ),
             'sample_id' => 
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
        $this->createTable('microscopic_picture', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '8',
             ),
             'filename' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '255',
             ),
             'sample_id' => 
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
        $this->removeColumn('sample', 'field_picture');
        $this->removeColumn('sample', 'detailed_picture');
        $this->removeColumn('sample', 'microscopic_picture');
    }

    public function down() {
        $this->dropTable('detailed_picture');
        $this->dropTable('field_picture');
        $this->dropTable('microscopic_picture');
        $this->addColumn('sample', 'field_picture', 'string', '255', array(
             ));
        $this->addColumn('sample', 'detailed_picture', 'string', '255', array(
             ));
        $this->addColumn('sample', 'microscopic_picture', 'string', '255', array(
             ));
    }
}