<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version147 extends Doctrine_Migration_Base {

	public function up() {
		$this->createForeignKey('location', 'location_category_id_location_category_id', array(
			'name' => 'location_category_id_location_category_id',
			'local' => 'category_id',
			'foreign' => 'id',
			'foreignTable' => 'location_category',
		));
		$this->addIndex('location', 'location_category_id', array('fields' => array(0 => 'category_id',),));
	}

	public function down() {
		$this->dropForeignKey('location', 'location_category_id_location_category_id');
		$this->removeIndex('location', 'location_category_id', array('fields' => array(0 => 'category_id')));
	}

}