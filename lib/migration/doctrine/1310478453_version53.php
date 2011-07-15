<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version53 extends Doctrine_Migration_Base {
	
	public function up() {
		$this->dropForeignKey('island', 'island_region_id_region_id');
		$this->dropForeignKey('region', 'region_country_id_country_id');
		
		$this->createForeignKey('island', 'island_region_id_region_id_1', array(
			'name' => 'island_region_id_region_id_1',
			'local' => 'region_id',
			'foreign' => 'id',
			'foreignTable' => 'region',
			'onUpdate' => '',
			'onDelete' => 'cascade',
		));
		$this->createForeignKey('region', 'region_country_id_country_id_1', array(
			'name' => 'region_country_id_country_id_1',
			'local' => 'country_id',
			'foreign' => 'id',
			'foreignTable' => 'country',
			'onUpdate' => '',
			'onDelete' => 'cascade',
		));
	}

	public function down() {
		$this->dropForeignKey('island', 'island_region_id_region_id_1');
		$this->dropForeignKey('region', 'region_country_id_country_id_1');
		
		$this->createForeignKey('island', 'island_region_id_region_id', array(
			'name' => 'island_region_id_region_id',
			'local' => 'region_id',
			'foreign' => 'id',
			'foreignTable' => 'region',
		));
		$this->createForeignKey('region', 'region_country_id_country_id', array(
			'name' => 'region_country_id_country_id',
			'local' => 'country_id',
			'foreign' => 'id',
			'foreignTable' => 'country',
		));
	}
}