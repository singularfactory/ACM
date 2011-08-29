<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version77 extends Doctrine_Migration_Base {
	public function up() {
		$this->createTable('purchase_item', array(
			'id' => 
		array(
			'type' => 'integer',
			'primary' => '1',
			'autoincrement' => '1',
			'length' => '8',
			),
			'status' => 
		array(
			'type' => 'enum',
			'values' => 
		array(
			0 => 'pending',
			1 => 'processing',
			2 => 'ready',
			),
			'length' => '',
			),
			'product' => 
		array(
			'type' => 'enum',
			'values' => 
		array(
			0 => 'strain',
			1 => 'culture_medium',
			2 => 'genomic_dna',
			),
			'length' => '',
			),
			'amount' => 
		array(
			'type' => 'integer',
			'notnull' => '1',
			'default' => '0',
			'length' => '8',
			),
			'remarks' => 
		array(
			'type' => 'string',
			'length' => '',
			),
			'purchase_order_id' => 
		array(
			'type' => 'integer',
			'notnull' => '1',
			'length' => '8',
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
			'primary' => 
		array(
			0 => 'id',
			),
			'collate' => 'utf8_general_ci',
			'charset' => 'utf8',
			));
		$this->createTable('purchase_order', array(
			'id' => 
		array(
			'type' => 'integer',
			'primary' => '1',
			'autoincrement' => '1',
			'length' => '8',
			),
			'status' => 
		array(
			'type' => 'enum',
			'values' => 
		array(
			0 => 'pending',
			1 => 'processing',
			2 => 'ready',
			3 => 'sent',
			),
			'length' => '',
			),
			'code' => 
		array(
			'type' => 'string',
			'length' => '40',
			),
			'remarks' => 
		array(
			'type' => 'string',
			'length' => '',
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
			'primary' => 
		array(
			0 => 'id',
			),
			'collate' => 'utf8_general_ci',
			'charset' => 'utf8',
			));
	}

	public function down() {
		$this->dropTable('purchase_item');
		$this->dropTable('purchase_order');
	}
}