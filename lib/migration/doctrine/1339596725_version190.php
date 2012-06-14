<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version190 extends Doctrine_Migration_Base {
	public function up() {
		$this->createTable('petitioners', array(
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
				'length' => '127',
			),
			'surname' => 
			array(
				'type' => 'string',
				'notnull' => '1',
				'length' => '127',
			),
			'email' => 
			array(
				'type' => 'string',
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
			'indexes' => 
			array(
				'petitioner_name' => 
				array(
					'fields' => 
					array(
						'name' => 
						array(
							'length' => '20',
						),
					),
				),
				'petitioner_surname' => 
				array(
					'fields' => 
					array(
						'surname' => 
						array(
							'length' => '20',
						),
					),
				),
			),
			'primary' => 
			array(
				0 => 'id',
			),
			'collate' => 'utf8_general_ci',
			'charset' => 'utf8',
		));
	}

	public function down() {
		$this->dropTable('petitioners');
	}
}
