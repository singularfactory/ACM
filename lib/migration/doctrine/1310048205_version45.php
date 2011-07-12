<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version45 extends Doctrine_Migration_Base {
	public function up() {
		$this->createForeignKey('dna_concentration', 'dna_concentration_dna_extraction_id_dna_extraction_id', array(
			'name' => 'dna_concentration_dna_extraction_id_dna_extraction_id',
			'local' => 'dna_extraction_id',
			'foreign' => 'id',
			'foreignTable' => 'dna_extraction',
			));
		$this->addIndex('dna_concentration', 'dna_concentration_dna_extraction_id', array(
			'fields' => 
		array(
			0 => 'dna_extraction_id',
			),
			));
	}

	public function down() {
		$this->dropForeignKey('dna_concentration', 'dna_concentration_dna_extraction_id_dna_extraction_id');
		$this->removeIndex('dna_concentration', 'dna_concentration_dna_extraction_id', array(
			'fields' => array(0 => 'dna_extraction_id',),
		));
	}
}