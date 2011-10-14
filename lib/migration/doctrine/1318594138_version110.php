<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version110 extends Doctrine_Migration_Base {
	public function up() {
		$this->createForeignKey('maintenance_deposit', 'maintenance_deposit_taxonomic_class_id_taxonomic_class_id', array(
			'name' => 'maintenance_deposit_taxonomic_class_id_taxonomic_class_id',
			'local' => 'taxonomic_class_id',
			'foreign' => 'id',
			'foreignTable' => 'taxonomic_class',
		));
		$this->createForeignKey('maintenance_deposit', 'maintenance_deposit_genus_id_genus_id', array(
			'name' => 'maintenance_deposit_genus_id_genus_id',
			'local' => 'genus_id',
			'foreign' => 'id',
			'foreignTable' => 'genus',
		));
		$this->createForeignKey('maintenance_deposit', 'maintenance_deposit_species_id_species_id', array(
			'name' => 'maintenance_deposit_species_id_species_id',
			'local' => 'species_id',
			'foreign' => 'id',
			'foreignTable' => 'species',
		));
		$this->createForeignKey('maintenance_deposit', 'maintenance_deposit_authority_id_authority_id', array(
			'name' => 'maintenance_deposit_authority_id_authority_id',
			'local' => 'authority_id',
			'foreign' => 'id',
			'foreignTable' => 'authority',
		));
		$this->createForeignKey('maintenance_deposit', 'maintenance_deposit_location_id_location_id', array(
			'name' => 'maintenance_deposit_location_id_location_id',
			'local' => 'location_id',
			'foreign' => 'id',
			'foreignTable' => 'location',
		));
		$this->createForeignKey('maintenance_deposit', 'maintenance_deposit_environment_id_environment_id', array(
			'name' => 'maintenance_deposit_environment_id_environment_id',
			'local' => 'environment_id',
			'foreign' => 'id',
			'foreignTable' => 'environment',
		));
		$this->createForeignKey('maintenance_deposit', 'maintenance_deposit_habitat_id_habitat_id', array(
			'name' => 'maintenance_deposit_habitat_id_habitat_id',
			'local' => 'habitat_id',
			'foreign' => 'id',
			'foreignTable' => 'habitat',
		));
		$this->createForeignKey('maintenance_deposit', 'maintenance_deposit_identifier_id_identifier_id', array(
			'name' => 'maintenance_deposit_identifier_id_identifier_id',
			'local' => 'identifier_id',
			'foreign' => 'id',
			'foreignTable' => 'identifier',
		));
		$this->createForeignKey('maintenance_deposit', 'maintenance_deposit_depositor_id_depositor_id', array(
			'name' => 'maintenance_deposit_depositor_id_depositor_id',
			'local' => 'depositor_id',
			'foreign' => 'id',
			'foreignTable' => 'depositor',
		));
		$this->createForeignKey('maintenance_deposit', 'maintenance_deposit_maintenance_status_id_maintenance_status_id', array(
			'name' => 'maintenance_deposit_maintenance_status_id_maintenance_status_id',
			'local' => 'maintenance_status_id',
			'foreign' => 'id',
			'foreignTable' => 'maintenance_status',
		));
		$this->createForeignKey('maintenance_deposit', 'mcci', array(
			'name' => 'mcci',
			'local' => 'cryopreservation_method_id',
			'foreign' => 'id',
			'foreignTable' => 'cryopreservation_method',
		));
		$this->createForeignKey('maintenance_deposit_collectors', 'mmmi', array(
			'name' => 'mmmi',
			'local' => 'maintenance_deposit_id',
			'foreign' => 'id',
			'foreignTable' => 'maintenance_deposit',
			'onUpdate' => '',
			'onDelete' => 'cascade',
		));
		$this->createForeignKey('maintenance_deposit_collectors', 'maintenance_deposit_collectors_collector_id_collector_id', array(
			'name' => 'maintenance_deposit_collectors_collector_id_collector_id',
			'local' => 'collector_id',
			'foreign' => 'id',
			'foreignTable' => 'collector',
		));
		$this->createForeignKey('maintenance_deposit_culture_media', 'mmmi_2', array(
			'name' => 'mmmi_2',
			'local' => 'maintenance_deposit_id',
			'foreign' => 'id',
			'foreignTable' => 'maintenance_deposit',
			'onUpdate' => '',
			'onDelete' => 'cascade',
		));
		$this->createForeignKey('maintenance_deposit_culture_media', 'mcci_1', array(
			'name' => 'mcci_1',
			'local' => 'culture_medium_id',
			'foreign' => 'id',
			'foreignTable' => 'culture_medium',
		));
		$this->createForeignKey('maintenance_deposit_isolators', 'mmmi_4', array(
			'name' => 'mmmi_4',
			'local' => 'maintenance_deposit_id',
			'foreign' => 'id',
			'foreignTable' => 'maintenance_deposit',
			'onUpdate' => '',
			'onDelete' => 'cascade',
		));
		$this->createForeignKey('maintenance_deposit_isolators', 'maintenance_deposit_isolators_isolator_id_isolator_id', array(
			'name' => 'maintenance_deposit_isolators_isolator_id_isolator_id',
			'local' => 'isolator_id',
			'foreign' => 'id',
			'foreignTable' => 'isolator',
		));
		$this->createForeignKey('maintenance_deposit_relative', 'mmmi_6', array(
			'name' => 'mmmi_6',
			'local' => 'maintenance_deposit_id',
			'foreign' => 'id',
			'foreignTable' => 'maintenance_deposit',
			'onUpdate' => '',
			'onDelete' => 'cascade',
		));
		$this->addIndex('maintenance_deposit', 'maintenance_deposit_taxonomic_class_id', array('fields' => array(0 => 'taxonomic_class_id')));
		$this->addIndex('maintenance_deposit', 'maintenance_deposit_genus_id', array('fields' => array(0 => 'genus_id')));
		$this->addIndex('maintenance_deposit', 'maintenance_deposit_species_id', array('fields' => array(0 => 'species_id')));
		$this->addIndex('maintenance_deposit', 'maintenance_deposit_authority_id', array('fields' => array(0 => 'authority_id')));
		$this->addIndex('maintenance_deposit', 'maintenance_deposit_location_id', array('fields' => array(0 => 'location_id')));
		$this->addIndex('maintenance_deposit', 'maintenance_deposit_environment_id', array('fields' => array(0 => 'environment_id')));
		$this->addIndex('maintenance_deposit', 'maintenance_deposit_habitat_id', array('fields' => array(0 => 'habitat_id')));
		$this->addIndex('maintenance_deposit', 'maintenance_deposit_identifier_id', array('fields' => array(0 => 'identifier_id')));
		$this->addIndex('maintenance_deposit', 'maintenance_deposit_depositor_id', array('fields' => array(0 => 'depositor_id')));
		$this->addIndex('maintenance_deposit', 'maintenance_deposit_maintenance_status_id', array('fields' => array(0 => 'maintenance_status_id')));
		$this->addIndex('maintenance_deposit', 'maintenance_deposit_cryopreservation_method_id', array('fields' => array(0 => 'cryopreservation_method_id')));
		$this->addIndex('maintenance_deposit_collectors', 'maintenance_deposit_collectors_maintenance_deposit_id', array('fields' => array(0 => 'maintenance_deposit_id')));
		$this->addIndex('maintenance_deposit_collectors', 'maintenance_deposit_collectors_collector_id', array('fields' => array(0 => 'collector_id')));
		$this->addIndex('maintenance_deposit_culture_media', 'maintenance_deposit_culture_media_maintenance_deposit_id', array('fields' => array(0 => 'maintenance_deposit_id')));
		$this->addIndex('maintenance_deposit_culture_media', 'maintenance_deposit_culture_media_culture_medium_id', array('fields' => array(0 => 'culture_medium_id')));
		$this->addIndex('maintenance_deposit_isolators', 'maintenance_deposit_isolators_maintenance_deposit_id', array('fields' => array(0 => 'maintenance_deposit_id')));
		$this->addIndex('maintenance_deposit_isolators', 'maintenance_deposit_isolators_isolator_id', array('fields' => array(0 => 'isolator_id')));
		$this->addIndex('maintenance_deposit_relative', 'maintenance_deposit_relative_maintenance_deposit_id', array('fields' => array(0 => 'maintenance_deposit_id')));
	}

	public function down() {
		$this->dropForeignKey('maintenance_deposit', 'maintenance_deposit_taxonomic_class_id_taxonomic_class_id');
		$this->dropForeignKey('maintenance_deposit', 'maintenance_deposit_genus_id_genus_id');
		$this->dropForeignKey('maintenance_deposit', 'maintenance_deposit_species_id_species_id');
		$this->dropForeignKey('maintenance_deposit', 'maintenance_deposit_authority_id_authority_id');
		$this->dropForeignKey('maintenance_deposit', 'maintenance_deposit_location_id_location_id');
		$this->dropForeignKey('maintenance_deposit', 'maintenance_deposit_environment_id_environment_id');
		$this->dropForeignKey('maintenance_deposit', 'maintenance_deposit_habitat_id_habitat_id');
		$this->dropForeignKey('maintenance_deposit', 'maintenance_deposit_identifier_id_identifier_id');
		$this->dropForeignKey('maintenance_deposit', 'maintenance_deposit_depositor_id_depositor_id');
		$this->dropForeignKey('maintenance_deposit', 'maintenance_deposit_maintenance_status_id_maintenance_status_id');
		$this->dropForeignKey('maintenance_deposit', 'mcci');
		$this->dropForeignKey('maintenance_deposit_collectors', 'mmmi');
		$this->dropForeignKey('maintenance_deposit_collectors', 'maintenance_deposit_collectors_collector_id_collector_id');
		$this->dropForeignKey('maintenance_deposit_culture_media', 'mmmi_2');
		$this->dropForeignKey('maintenance_deposit_culture_media', 'mcci_1');
		$this->dropForeignKey('maintenance_deposit_isolators', 'mmmi_4');
		$this->dropForeignKey('maintenance_deposit_isolators', 'maintenance_deposit_isolators_isolator_id_isolator_id');
		$this->dropForeignKey('maintenance_deposit_relative', 'mmmi_6');
		$this->removeIndex('maintenance_deposit', 'maintenance_deposit_taxonomic_class_id', array('fields' => array(0 => 'taxonomic_class_id')));
		$this->removeIndex('maintenance_deposit', 'maintenance_deposit_genus_id', array('fields' => array(0 => 'genus_id')));
		$this->removeIndex('maintenance_deposit', 'maintenance_deposit_species_id', array('fields' => array(0 => 'species_id')));
		$this->removeIndex('maintenance_deposit', 'maintenance_deposit_authority_id', array('fields' => array(0 => 'authority_id')));
		$this->removeIndex('maintenance_deposit', 'maintenance_deposit_location_id', array('fields' => array(0 => 'location_id')));
		$this->removeIndex('maintenance_deposit', 'maintenance_deposit_environment_id', array('fields' => array(0 => 'environment_id')));
		$this->removeIndex('maintenance_deposit', 'maintenance_deposit_habitat_id', array('fields' => array(0 => 'habitat_id')));
		$this->removeIndex('maintenance_deposit', 'maintenance_deposit_identifier_id', array('fields' => array(0 => 'identifier_id')));
		$this->removeIndex('maintenance_deposit', 'maintenance_deposit_depositor_id', array('fields' => array(0 => 'depositor_id')));
		$this->removeIndex('maintenance_deposit', 'maintenance_deposit_maintenance_status_id', array('fields' => array(0 => 'maintenance_status_id')));
		$this->removeIndex('maintenance_deposit', 'maintenance_deposit_cryopreservation_method_id', array('fields' => array(0 => 'cryopreservation_method_id')));
		$this->removeIndex('maintenance_deposit_collectors', 'maintenance_deposit_collectors_maintenance_deposit_id', array('fields' => array(0 => 'maintenance_deposit_id')));
		$this->removeIndex('maintenance_deposit_collectors', 'maintenance_deposit_collectors_collector_id', array('fields' => array(0 => 'collector_id')));
		$this->removeIndex('maintenance_deposit_culture_media', 'maintenance_deposit_culture_media_maintenance_deposit_id', array('fields' => array(0 => 'maintenance_deposit_id')));
		$this->removeIndex('maintenance_deposit_culture_media', 'maintenance_deposit_culture_media_culture_medium_id', array('fields' => array(0 => 'culture_medium_id')));
		$this->removeIndex('maintenance_deposit_isolators', 'maintenance_deposit_isolators_maintenance_deposit_id', array('fields' => array(0 => 'maintenance_deposit_id')));
		$this->removeIndex('maintenance_deposit_isolators', 'maintenance_deposit_isolators_isolator_id', array('fields' => array(0 => 'isolator_id')));
		$this->removeIndex('maintenance_deposit_relative', 'maintenance_deposit_relative_maintenance_deposit_id', array('fields' => array(0 => 'maintenance_deposit_id')));
	}
}