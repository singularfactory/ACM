<?php

class AddEventsTable extends Doctrine_Migration_Base
{
  public function up()
  {
	// Create Event table
	$this->createTable('event',
		array(
			'id' => array('type' => 'integer', 'length' => 8, 'notnull' => true, 'primary' => true, 'autoincrement' => true),
			'action' => array('type' => 'string', 'length' => 40, 'notnull' => true),
			'description' => array('type' => 'string', 'length' => 255, 'notnull' => true),
			'user_id' => array('type' => 'integer', 'length' => 8, 'notnull' => true),
			'ip_address' => array('type' => 'string', 'length' => 15, 'notnull' => true),
			'created_at' => array('type' => 'timestamp', 'notnull' => true),
			'updated_at' => array('type' => 'timestamp', 'notnull' => true),
		),
		array(
			'type' => 'INNODB',
			'charset' => 'utf8',
			'indexes' => array(),
		)
	);
  }

  public function down()
  {
	// Drop Event table
	$this->dropTable('event');
  }
}
