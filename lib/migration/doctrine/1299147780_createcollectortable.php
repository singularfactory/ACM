<?php

class Createcollectortable extends Doctrine_Migration_Base
{
  public function up()
  {
		// Drop the foreign key that references sfGuardUser in Sample table
		$this->dropForeignKey('sample', 'sample_collector_id_sf_guard_user_id');
		
		// Create Collector table
		$this->createTable('collector', array(
			'id' => array('type' => 'integer', 'length' => 8, 'notnull' => true, 'primary' => true, 'autoincrement' => true),
			'name' => array('type' => 'string', 'length' => 127, 'notnull' => true),
			'surname' => array('type' => 'string', 'length' => 127, 'notnull' => true),
			'email' => array('type' => 'string', 'length' => 255),
			'created_at' => array('type' => 'timestamp', 'notnull' => true),
			'updated_at' => array('type' => 'timestamp', 'notnull' => true),
		),
		array('type' => 'INNODB', 'charset' => 'utf8', 'indexes' => array())
		);
		
		// Create a foreign key that references Collector in Sample table
		$this->createForeignKey('sample', 'sample_collector_id_collector_id', array(
			'name' => 'sample_collector_id_collector_id',
			'local' => 'collector_id',
			'foreign' => 'id',
			'foreignTable' => 'collector',
		));
  }

  public function down()
  {
		// Drop the foreign key that references Collector in Sample table
		$this->dropForeignKey('sample', 'sample_collector_id_collector_id');
		
		// Drop Collector table
		$this->dropTable('collector');
		
		// Create a foreign key that references sfGuardUser in Sample table
		$this->createForeignKey('sample', 'sample_collector_id_sf_guard_user_id', array(
			'name' => 'sample_collector_id_sf_guard_user_id',
			'local' => 'collector_id',
			'foreign' => 'id',
			'foreignTable' => 'sf_guard_user',
		));
  }
}
