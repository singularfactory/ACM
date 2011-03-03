<?php

class Createcollectortable extends Doctrine_Migration_Base
{
	public function up()
	{
		// Create Collector table
		$this->createTable('collector',
		array(
			'id' => array('type' => 'integer', 'length' => 8, 'notnull' => true, 'primary' => true, 'autoincrement' => true),
			'name' => array('type' => 'string', 'length' => 127, 'notnull' => true),
			'surname' => array('type' => 'string', 'length' => 127, 'notnull' => true),
			'email' => array('type' => 'string', 'length' => 255),
			'created_at' => array('type' => 'timestamp', 'notnull' => true),
			'updated_at' => array('type' => 'timestamp', 'notnull' => true),
			),
		array(
			'type' => 'INNODB',
			'charset' => 'utf8',
			'indexes' => array()
			)
			);
	}

	public function down()
	{
		// Drop Collector table
		$this->dropTable('collector');
	}
}
