<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version47 extends Doctrine_Migration_Base {
	public function up() {
		$this->createTable('dna_polymerase', array(
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
			));
		$this->createTable('dna_primer', array(
			'id' => 
		array(
			'type' => 'integer',
			'primary' => '1',
			'autoincrement' => '1',
			'length' => '8',
			),
			'forward' => 
		array(
			'type' => 'string',
			'notnull' => '1',
			'length' => '10',
			),
			'reverse' => 
		array(
			'type' => 'string',
			'notnull' => '1',
			'length' => '10',
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
			));
		$this->createTable('dna_sequence', array(
			'id' => 
		array(
			'type' => 'integer',
			'primary' => '1',
			'autoincrement' => '1',
			'length' => '8',
			),
			'pcr_id' => 
		array(
			'type' => 'integer',
			'notnull' => '1',
			'length' => '8',
			),
			'gen' => 
		array(
			'type' => 'string',
			'notnull' => '1',
			'length' => '127',
			),
			'date' => 
		array(
			'type' => 'date',
			'notnull' => '1',
			'length' => '25',
			),
			'is_valid' => 
		array(
			'type' => 'boolean',
			'notnull' => '1',
			'default' => '0',
			'length' => '25',
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
			));
		$this->createTable('dna_sequence_reaction', array(
			'id' => 
		array(
			'type' => 'integer',
			'primary' => '1',
			'autoincrement' => '1',
			'length' => '8',
			),
			'primer' => 
		array(
			'type' => 'string',
			'notnull' => '1',
			'length' => '10',
			),
			'is_valid' => 
		array(
			'type' => 'boolean',
			'notnull' => '1',
			'default' => '0',
			'length' => '25',
			),
			'dna_sequence_id' => 
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
			));
		$this->createTable('pcr', array(
			'id' => 
		array(
			'type' => 'integer',
			'primary' => '1',
			'autoincrement' => '1',
			'length' => '8',
			),
			'dna_extraction_id' => 
		array(
			'type' => 'integer',
			'notnull' => '1',
			'length' => '8',
			),
			'dna_primer_id' => 
		array(
			'type' => 'integer',
			'notnull' => '1',
			'length' => '8',
			),
			'dna_polymerase_id' => 
		array(
			'type' => 'integer',
			'notnull' => '1',
			'length' => '8',
			),
			'concentration' => 
		array(
			'type' => 'decimal',
			'length' => '18',
			),
			'260_280_ratio' => 
		array(
			'type' => 'decimal',
			'length' => '18',
			),
			'260_230_ratio' => 
		array(
			'type' => 'decimal',
			'length' => '18',
			),
			'can_be_sequenced' => 
		array(
			'type' => 'boolean',
			'notnull' => '1',
			'default' => '0',
			'length' => '25',
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
			));
		$this->createTable('pcr_gel', array(
			'id' => 
		array(
			'type' => 'integer',
			'primary' => '1',
			'autoincrement' => '1',
			'length' => '8',
			),
			'ratio' => 
		array(
			'type' => 'decimal',
			'length' => '18',
			),
			'pcr_id' => 
		array(
			'type' => 'integer',
			'notnull' => '1',
			'length' => '8',
			),
			'is_valid' => 
		array(
			'type' => 'boolean',
			'notnull' => '1',
			'default' => '0',
			'length' => '25',
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
			));
	}

	public function down() {
		$this->dropTable('dna_polymerase');
		$this->dropTable('dna_primer');
		$this->dropTable('dna_sequence');
		$this->dropTable('dna_sequence_reaction');
		$this->dropTable('pcr');
		$this->dropTable('pcr_gel');
	}
}