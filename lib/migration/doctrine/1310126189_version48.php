<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version48 extends Doctrine_Migration_Base {
	public function up() {
		$this->createForeignKey('dna_sequence', 'dna_sequence_pcr_id_pcr_id', array(
			'name' => 'dna_sequence_pcr_id_pcr_id',
			'local' => 'pcr_id',
			'foreign' => 'id',
			'foreignTable' => 'pcr',
			));
		$this->createForeignKey('dna_sequence_reaction', 'dna_sequence_reaction_dna_sequence_id_dna_sequence_id', array(
			'name' => 'dna_sequence_reaction_dna_sequence_id_dna_sequence_id',
			'local' => 'dna_sequence_id',
			'foreign' => 'id',
			'foreignTable' => 'dna_sequence',
			));
		$this->createForeignKey('pcr', 'pcr_dna_extraction_id_dna_extraction_id', array(
			'name' => 'pcr_dna_extraction_id_dna_extraction_id',
			'local' => 'dna_extraction_id',
			'foreign' => 'id',
			'foreignTable' => 'dna_extraction',
			));
		$this->createForeignKey('pcr', 'pcr_dna_primer_id_dna_primer_id', array(
			'name' => 'pcr_dna_primer_id_dna_primer_id',
			'local' => 'dna_primer_id',
			'foreign' => 'id',
			'foreignTable' => 'dna_primer',
			));
		$this->createForeignKey('pcr', 'pcr_dna_polymerase_id_dna_polymerase_id', array(
			'name' => 'pcr_dna_polymerase_id_dna_polymerase_id',
			'local' => 'dna_polymerase_id',
			'foreign' => 'id',
			'foreignTable' => 'dna_polymerase',
			));
		$this->createForeignKey('pcr_gel', 'pcr_gel_pcr_id_pcr_id', array(
			'name' => 'pcr_gel_pcr_id_pcr_id',
			'local' => 'pcr_id',
			'foreign' => 'id',
			'foreignTable' => 'pcr',
			));
		$this->addIndex('dna_sequence', 'dna_sequence_pcr_id', array(
			'fields' => 
		array(
			0 => 'pcr_id',
			),
			));
		$this->addIndex('dna_sequence_reaction', 'dna_sequence_reaction_dna_sequence_id', array(
			'fields' => 
		array(
			0 => 'dna_sequence_id',
			),
			));
		$this->addIndex('pcr', 'pcr_dna_extraction_id', array(
			'fields' => 
		array(
			0 => 'dna_extraction_id',
			),
			));
		$this->addIndex('pcr', 'pcr_dna_primer_id', array(
			'fields' => 
		array(
			0 => 'dna_primer_id',
			),
			));
		$this->addIndex('pcr', 'pcr_dna_polymerase_id', array(
			'fields' => 
		array(
			0 => 'dna_polymerase_id',
			),
			));
		$this->addIndex('pcr_gel', 'pcr_gel_pcr_id', array(
			'fields' => 
		array(
			0 => 'pcr_id',
			),
			));
	}

	public function down() {
		$this->dropForeignKey('dna_sequence', 'dna_sequence_pcr_id_pcr_id');
		$this->dropForeignKey('dna_sequence_reaction', 'dna_sequence_reaction_dna_sequence_id_dna_sequence_id');
		$this->dropForeignKey('pcr', 'pcr_dna_extraction_id_dna_extraction_id');
		$this->dropForeignKey('pcr', 'pcr_dna_primer_id_dna_primer_id');
		$this->dropForeignKey('pcr', 'pcr_dna_polymerase_id_dna_polymerase_id');
		$this->dropForeignKey('pcr_gel', 'pcr_gel_pcr_id_pcr_id');
		$this->removeIndex('dna_sequence', 'dna_sequence_pcr_id', array(
			'fields' => 
		array(
			0 => 'pcr_id',
			),
			));
		$this->removeIndex('dna_sequence_reaction', 'dna_sequence_reaction_dna_sequence_id', array(
			'fields' => 
		array(
			0 => 'dna_sequence_id',
			),
			));
		$this->removeIndex('pcr', 'pcr_dna_extraction_id', array(
			'fields' => 
		array(
			0 => 'dna_extraction_id',
			),
			));
		$this->removeIndex('pcr', 'pcr_dna_primer_id', array(
			'fields' => 
		array(
			0 => 'dna_primer_id',
			),
			));
		$this->removeIndex('pcr', 'pcr_dna_polymerase_id', array(
			'fields' => 
		array(
			0 => 'dna_polymerase_id',
			),
			));
		$this->removeIndex('pcr_gel', 'pcr_gel_pcr_id', array(
			'fields' => 
		array(
			0 => 'pcr_id',
			),
			));
	}
}