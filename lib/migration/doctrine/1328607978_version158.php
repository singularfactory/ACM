<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version158 extends Doctrine_Migration_Base {
	public function up() {
		$this->dropForeignKey('event', 'event_user_id_sf_guard_user_id');
		$this->createForeignKey('event', 'event_user_id_sf_guard_user_id_1', array(
			'name' => 'event_user_id_sf_guard_user_id_1',
			'local' => 'user_id',
			'foreign' => 'id',
			'foreignTable' => 'sf_guard_user',
			'onUpdate' => '',
			'onDelete' => 'cascade',
			));
	}

	public function down() {
		$this->createForeignKey('event', 'event_user_id_sf_guard_user_id', array(
			'name' => 'event_user_id_sf_guard_user_id',
			'local' => 'user_id',
			'foreign' => 'id',
			'foreignTable' => 'sf_guard_user',
			));
		$this->dropForeignKey('event', 'event_user_id_sf_guard_user_id_1');
	}
}