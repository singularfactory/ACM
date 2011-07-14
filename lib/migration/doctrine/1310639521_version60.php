<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version60 extends Doctrine_Migration_Base {
	public function up() {
		$this->createForeignKey('dna_sequence', 'dna_sequence_pcr_id_pcr_id', array(
			'name' => 'dna_sequence_pcr_id_pcr_id',
			'local' => 'pcr_id',
			'foreign' => 'id',
			'foreignTable' => 'pcr',
			));
		$this->createForeignKey('pcr_reaction', 'pcr_reaction_dna_sequence_id_dna_sequence_id', array(
			'name' => 'pcr_reaction_dna_sequence_id_dna_sequence_id',
			'local' => 'dna_sequence_id',
			'foreign' => 'id',
			'foreignTable' => 'dna_sequence',
			));
		$this->addIndex('dna_sequence', 'dna_sequence_pcr_id', array(
			'fields' => 
		array(
			0 => 'pcr_id',
			),
			));
		$this->addIndex('pcr_reaction', 'pcr_reaction_dna_sequence_id', array(
			'fields' => 
		array(
			0 => 'dna_sequence_id',
			),
			));
	}

	public function down() {
		$this->dropForeignKey('dna_sequence', 'dna_sequence_pcr_id_pcr_id');
		$this->dropForeignKey('pcr_reaction', 'pcr_reaction_dna_sequence_id_dna_sequence_id');
		$this->removeIndex('dna_sequence', 'dna_sequence_pcr_id', array(
			'fields' => 
		array(
			0 => 'pcr_id',
			),
			));
		$this->removeIndex('pcr_reaction', 'pcr_reaction_dna_sequence_id', array(
			'fields' => 
		array(
			0 => 'dna_sequence_id',
			),
			));
	}
}