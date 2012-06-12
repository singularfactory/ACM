<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version179 extends Doctrine_Migration_Base {
	public function up() {
		$this->removeColumn('external_strain', 'has_dna');
		$this->removeColumn('external_strain', 'collection_date');
		
		$this->dropForeignKey('external_strain', 'external_strain_location_id_location_id');
		$this->dropForeignKey('external_strain', 'external_strain_environment_id_environment_id');
		$this->dropForeignKey('external_strain', 'external_strain_habitat_id_habitat_id');
		$this->dropForeignKey('external_strain', 'ecci');
		$this->removeColumn('external_strain', 'location_id');
		$this->removeColumn('external_strain', 'environment_id');
		$this->removeColumn('external_strain', 'habitat_id');
		$this->removeColumn('external_strain', 'cryopreservation_method_id');

		$this->addColumn('external_strain', 'sample_id', 'integer', '8', array());
		$this->addColumn('external_strain', 'depositor_id', 'integer', '8', array());
		$this->addColumn('external_strain', 'kingdom_id', 'integer', '8', array( 'notnull' => '1',));
		$this->addColumn('external_strain', 'subkingdom_id', 'integer', '8', array( 'notnull' => '1',));
		$this->addColumn('external_strain', 'phylum_id', 'integer', '8', array( 'notnull' => '1',));
		$this->addColumn('external_strain', 'taxonomic_order_id', 'integer', '8', array( 'notnull' => '1',));
		$this->addColumn('external_strain', 'family_id', 'integer', '8', array( 'notnull' => '1',));
		$this->addColumn('external_strain', 'temperature', 'decimal', '18', array());
		$this->addColumn('external_strain', 'photoperiod', 'decimal', '18', array());
		$this->addColumn('external_strain', 'irradiation', 'decimal', '18', array());
	}

	public function down() {
		$this->removeColumn('external_strain', 'sample_id');
		$this->removeColumn('external_strain', 'depositor_id');
		$this->removeColumn('external_strain', 'kingdom_id');
		$this->removeColumn('external_strain', 'subkingdom_id');
		$this->removeColumn('external_strain', 'phylum_id');
		$this->removeColumn('external_strain', 'taxonomic_order_id');
		$this->removeColumn('external_strain', 'family_id');
		$this->removeColumn('external_strain', 'temperature');
		$this->removeColumn('external_strain', 'photoperiod');
		$this->removeColumn('external_strain', 'irradiation');

		$this->addColumn('external_strain', 'has_dna', 'boolean', '25', array( 'notnull' => '1', 'default' => '0',));
		$this->addColumn('external_strain', 'location_id', 'integer', '8', array( 'notnull' => '1',));
		$this->addColumn('external_strain', 'environment_id', 'integer', '8', array());
		$this->addColumn('external_strain', 'habitat_id', 'integer', '8', array());
		$this->addColumn('external_strain', 'collection_date', 'date', '25', array());
		$this->addColumn('external_strain', 'cryopreservation_method_id', 'integer', '8', array());
		$this->createForeignKey('external_strain', 'external_strain_location_id_location_id', array(
			'name' => 'external_strain_location_id_location_id',
			'local' => 'location_id',
			'foreign' => 'id',
			'foreignTable' => 'location',
		));
		$this->createForeignKey('external_strain', 'external_strain_environment_id_environment_id', array(
			'name' => 'external_strain_environment_id_environment_id',
			'local' => 'environment_id',
			'foreign' => 'id',
			'foreignTable' => 'environment',
		));
		$this->createForeignKey('external_strain', 'external_strain_habitat_id_habitat_id', array(
			'name' => 'external_strain_habitat_id_habitat_id',
			'local' => 'habitat_id',
			'foreign' => 'id',
			'foreignTable' => 'habitat',
		));
		$this->createForeignKey('external_strain', 'ecci', array(
			'name' => 'ecci',
			'local' => 'cryopreservation_method_id',
			'foreign' => 'id',
			'foreignTable' => 'cryopreservation_method',
		));
	}
}
