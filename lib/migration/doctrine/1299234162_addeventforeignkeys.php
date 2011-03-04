<?php

class AddEventForeignKeys extends Doctrine_Migration_Base
{
  public function up()
  {
	$this->createForeignKey('event', 'event_user_id_sf_guard_user_id', array(
		'name' => 'event_user_id_sf_guard_user_id',
		'local' => 'user_id',
		'foreign' => 'id',
		'foreignTable' => 'sf_guard_user',
	));
	
	$this->addIndex('event', 'event_user_id', array(
		'fields' => array(0 => 'user_id'),
	));
  }

  public function down()
  {
	$this->dropForeignKey('event', 'event_user_id_sf_guard_user_id');
	$this->removeIndex('event', 'event_user_id', array(
		'fields' => array(0 => 'user_id'),
	));
  }
}
