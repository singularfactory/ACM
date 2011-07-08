<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version46 extends Doctrine_Migration_Base {
	
	public function up() {
		$this->removeColumn('dna_extraction', 'dna_concentration_id');
		$this->dropTable('dna_concentration');
		
		$this->addColumn('dna_extraction', 'concentration', 'decimal', '18', array());
		$this->addColumn('dna_extraction', '260_280_ratio', 'decimal', '18', array());
		$this->addColumn('dna_extraction', '260_230_ratio', 'decimal', '18', array());
		$this->changeColumn('dna_extraction', 'extraction_date', 'date', '25', array());
	}

	public function down() {
		$this->createTable('dna_concentration', array(
			'id' => 
		array(
			'type' => 'integer',
			'primary' => '1',
			'autoincrement' => '1',
			'length' => '8',
			),
			'amount' => 
		array(
			'type' => 'decimal',
			'notnull' => '1',
			'length' => '18',
			),
			'260_280_ratio' => 
		array(
			'type' => 'decimal',
			'notnull' => '1',
			'length' => '18',
			),
			'260_230_ratio' => 
		array(
			'type' => 'decimal',
			'notnull' => '1',
			'length' => '18',
			),
			'dna_extraction_id' => 
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
			'indexes' => 
		array(
			),
			'primary' => 
		array(
			0 => 'id',
			),
			'collate' => '',
			'charset' => '',
			));
		$this->addColumn('dna_extraction', 'dna_concentration_id', 'integer', '8', array(
			'notnull' => '1',
			));
		$this->removeColumn('dna_extraction', 'concentration');
		$this->removeColumn('dna_extraction', '260_280_ratio');
		$this->removeColumn('dna_extraction', '260_230_ratio');
	}
}