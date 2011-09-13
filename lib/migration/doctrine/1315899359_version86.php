<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version86 extends Doctrine_Migration_Base {
	
	public function up() {
		$this->createTable('container', array(
			'id' => 
				array(
					'type' => 'integer',
					'primary' => '1',
					'autoincrement' => '1',
					'length' => '8',
					),
			'name' => 
				array(
					'type' => 'string',
					'notnull' => '1',
					'length' => '255',
					),
			'created_at' => 
				array(
					'notnull' => '1',
					'type' => 'timestamp',
					'length' => '25',
					),
			'updated_at' => 
				array(
					'notnull' => '1',
					'type' => 'timestamp',
					'length' => '25',
					),
		), array(
			'type' => 'INNODB',
			'indexes' => array('container_name' => array('fields' => array('name' => array('length' => '20')))),
			'primary' => array(0 => 'id',),
			'collate' => 'utf8_general_ci',
			'charset' => 'utf8',
		));
		
		$this->addColumn('strain', 'container_id', 'integer', '8', array());
	}

	public function down() {
		$this->dropTable('container');
		$this->removeColumn('strain', 'container_id');
	}
}