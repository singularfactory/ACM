<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version189 extends Doctrine_Migration_Base {
	public function up() {
		$this->createForeignKey('isolation', 'isolation_supervisor_id_sf_guard_user_id', array(
			'name' => 'isolation_supervisor_id_sf_guard_user_id',
			'local' => 'supervisor_id',
			'foreign' => 'id',
			'foreignTable' => 'sf_guard_user',
		));
/*        $this->addIndex('isolation', 'isolation_supervisor_id', array(
						 'fields' => 
						 array(
							0 => 'supervisor_id',
						 ),
));*/
	}

	public function down() {
		$this->dropForeignKey('isolation', 'isolation_supervisor_id_sf_guard_user_id');
/*        $this->removeIndex('isolation', 'isolation_supervisor_id', array(
						 'fields' => 
						 array(
							0 => 'supervisor_id',
						 ),
));*/
	}
}
