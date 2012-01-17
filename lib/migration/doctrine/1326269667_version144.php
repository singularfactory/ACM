<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version144 extends Doctrine_Migration_Base {
	public function up() {
		$this->createForeignKey('strain_containers', 'strain_containers_strain_id_strain_id', array(
			'name' => 'strain_containers_strain_id_strain_id',
			'local' => 'strain_id',
			'foreign' => 'id',
			'foreignTable' => 'strain',
			'onUpdate' => '',
			'onDelete' => 'cascade',
		));
		$this->createForeignKey('strain_containers', 'strain_containers_container_id_container_id', array(
			'name' => 'strain_containers_container_id_container_id',
			'local' => 'container_id',
			'foreign' => 'id',
			'foreignTable' => 'container',
		));
		$this->addIndex('strain_containers', 'strain_containers_strain_id', array('fields' => array(0 => 'strain_id')));
		$this->addIndex('strain_containers', 'strain_containers_container_id', array('fields' => array(0 => 'container_id')));
	}

	public function down() {
		$this->dropForeignKey('strain_containers', 'strain_containers_strain_id_strain_id');
		$this->dropForeignKey('strain_containers', 'strain_containers_container_id_container_id');
		$this->removeIndex('strain_containers', 'strain_containers_strain_id', array('fields' => array(0 => 'strain_id')));
		$this->removeIndex('strain_containers', 'strain_containers_container_id', array('fields' => array(0 => 'container_id')));
	}
}