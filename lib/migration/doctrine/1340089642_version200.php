<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version200 extends Doctrine_Migration_Base {
	public function up() {
		$this->dropForeignKey('project', 'project_petitioner_id_sf_guard_user_id');
		$this->createForeignKey('project', 'project_petitioner_id_petitioners_id', array(
			'name' => 'project_petitioner_id_petitioners_id',
			'local' => 'petitioner_id',
			'foreign' => 'id',
			'foreignTable' => 'petitioners',
		));
		//$this->addIndex('project', 'project_petitioner_id', array('fields' => array( 0 => 'petitioner_id',),));
	}

	public function down() {
		$this->dropForeignKey('project', 'project_petitioner_id_petitioners_id');
		$this->createForeignKey('project', 'project_petitioner_id_sf_guard_user_id', array(
			'name' => 'project_petitioner_id_sf_guard_user_id',
			'local' => 'petitioner_id',
			'foreign' => 'id',
			'foreignTable' => 'sf_guard_user',
		));
		//$this->removeIndex('project', 'project_petitioner_id', array('fields' => array( 0 => 'petitioner_id',),));
	}
}
