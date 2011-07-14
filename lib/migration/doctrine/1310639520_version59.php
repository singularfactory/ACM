<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version59 extends Doctrine_Migration_Base {
	public function up() {
		$this->createTable('dna_sequence', array(
			'id' => 
		array(
			'type' => 'integer',
			'primary' => '1',
			'autoincrement' => '1',
			'length' => '8',
			),
			'gen' => 
		array(
			'type' => 'string',
			'notnull' => '1',
			'length' => '10',
			),
			'date' => 
		array(
			'type' => 'date',
			'notnull' => '1',
			'length' => '25',
			),
			'worked' => 
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
			'pcr_id' => 
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
		$this->dropForeignKey('pcr_reaction', 'pcr_reaction_pcr_id_pcr_id');
		$this->removeColumn('pcr_reaction', 'pcr_id');
		$this->addColumn('pcr_reaction', 'dna_sequence_id', 'integer', '8', array('notnull' => '1'));
	}

	public function down() {
		$this->dropTable('dna_sequence');
		$this->addColumn('pcr_reaction', 'pcr_id', 'integer', '8', array('notnull' => '1',));
		$this->createForeignKey('pcr_reaction', 'pcr_reaction_pcr_id_pcr_id', array(
			'name' => 'pcr_reaction_pcr_id_pcr_id',
			'local' => 'pcr_id',
			'foreign' => 'id',
			'foreignTable' => 'pcr',
			'onUpdate' => '',
			'onDelete' => 'cascade',
		));
		$this->removeColumn('pcr_reaction', 'dna_sequence_id');
	}
}