<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version209 extends Doctrine_Migration_Base {
	public function up() {
		$this->createTable('potential_usage', array(
			'id' => array( 'type' => 'integer', 'primary' => '1', 'autoincrement' => '1', 'length' => '8',),
			'name' => array( 'type' => 'string', 'notnull' => '1', 'length' => '128',),
			'created_at' => array( 'notnull' => '1', 'type' => 'timestamp', 'length' => '25',),
			'updated_at' => array( 'notnull' => '1', 'type' => 'timestamp', 'length' => '25',),
		), array(
			'type' => 'INNODB',
			'indexes' => array( 'usage_name' => array( 'fields' => array( 'name' => array( 'length' => '5',),),),),
			'primary' => array( 0 => 'id',),
			'collate' => 'utf8_general_ci',
			'charset' => 'utf8',
		));
		$this->createTable('strain_usage', array(
			'id' => array( 'type' => 'integer', 'primary' => '1', 'autoincrement' => '1', 'length' => '8',),
			'taxonomic_class_id' => array( 'type' => 'integer', 'notnull' => '1', 'length' => '8',),
			'genus_id' => array( 'type' => 'integer', 'notnull' => '1', 'length' => '8',),
			'species_id' => array( 'type' => 'integer', 'length' => '8',),
			'usage_id' => array( 'type' => 'integer', 'notnull' => '1', 'length' => '8',),
			'created_at' => array( 'notnull' => '1', 'type' => 'timestamp', 'length' => '25',),
			'updated_at' => array( 'notnull' => '1', 'type' => 'timestamp', 'length' => '25',),
		), array(
			'type' => 'INNODB',
			'indexes' => array('unique_strain_usage' => array('fields' => array(0 => 'taxonomic_class_id', 1 => 'genus_id', 2 => 'species_id', 3 => 'usage_id',), 'type' => 'unique')),
			'primary' => array( 0 => 'id',),
			'collate' => 'utf8_general_ci',
			'charset' => 'utf8',
		));
		$this->createTable('usage_area', array(
			'id' => array( 'type' => 'integer', 'primary' => '1', 'autoincrement' => '1', 'length' => '8',),
			'name' => array( 'type' => 'string', 'notnull' => '1', 'length' => '128',),
			'created_at' => array( 'notnull' => '1', 'type' => 'timestamp', 'length' => '25',),
			'updated_at' => array( 'notnull' => '1', 'type' => 'timestamp', 'length' => '25',),
		), array(
			'type' => 'INNODB',
			'indexes' => array( 'usage_area_name' => array( 'fields' => array( 'name' => array( 'length' => '5',),),),),
			'primary' => array( 0 => 'id',),
			'collate' => 'utf8_general_ci',
			'charset' => 'utf8',
		));
		$this->createTable('usage_area_usages', array(
			'id' => array( 'type' => 'integer', 'primary' => '1', 'autoincrement' => '1', 'length' => '8',),
			'usage_area_id' => array( 'type' => 'integer', 'notnull' => '1', 'length' => '8',),
			'usage_id' => array( 'type' => 'integer', 'notnull' => '1', 'length' => '8',),
			'created_at' => array( 'notnull' => '1', 'type' => 'timestamp', 'length' => '25',),
			'updated_at' => array( 'notnull' => '1', 'type' => 'timestamp', 'length' => '25',),
		), array(
			'type' => 'INNODB',
			'indexes' => array( 'unique_usage' => array( 'fields' => array( 0 => 'usage_area_id', 1 => 'usage_id',), 'type' => 'unique',),),
			'primary' => array( 0 => 'id',),
			'collate' => 'utf8_general_ci',
			'charset' => 'utf8',
		));
	}

	public function down() {
		$this->dropTable('potential_usage');
		$this->dropTable('strain_usage');
		$this->dropTable('usage_area');
		$this->dropTable('usage_area_usages');
	}
}
