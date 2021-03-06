<?php
/**
 * Migration file
 *
 * acm : Algae Culture Management (https://github.com/singularfactory/ACM)
 * Copyright 2012, Singular Factory <info@singularfactory.com>
 *
 * This file is part of ACM
 *
 * ACM is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ACM is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ACM.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright     Copyright 2012, Singular Factory <info@singularfactory.com>
 * @package       ACM.Lib.Migration
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version30 extends Doctrine_Migration_Base {
	public function up() {
		$this->createForeignKey('strain', 'strain_sample_id_sample_id', array(
			'name' => 'strain_sample_id_sample_id',
			'local' => 'sample_id',
			'foreign' => 'id',
			'foreignTable' => 'sample',
			));
		$this->createForeignKey('strain', 'strain_dna_id_dna_id', array(
			'name' => 'strain_dna_id_dna_id',
			'local' => 'dna_id',
			'foreign' => 'id',
			'foreignTable' => 'dna',
			));
		$this->createForeignKey('strain', 'strain_taxonomic_class_id_taxonomic_class_id', array(
			'name' => 'strain_taxonomic_class_id_taxonomic_class_id',
			'local' => 'taxonomic_class_id',
			'foreign' => 'id',
			'foreignTable' => 'taxonomic_class',
			));
		$this->createForeignKey('strain', 'strain_genus_id_genus_id', array(
			'name' => 'strain_genus_id_genus_id',
			'local' => 'genus_id',
			'foreign' => 'id',
			'foreignTable' => 'genus',
			));
		$this->createForeignKey('strain', 'strain_species_id_species_id', array(
			'name' => 'strain_species_id_species_id',
			'local' => 'species_id',
			'foreign' => 'id',
			'foreignTable' => 'species',
			));
		$this->createForeignKey('strain', 'strain_authority_id_authority_id', array(
			'name' => 'strain_authority_id_authority_id',
			'local' => 'authority_id',
			'foreign' => 'id',
			'foreignTable' => 'authority',
			));
		$this->createForeignKey('strain', 'strain_isolator_id_isolator_id', array(
			'name' => 'strain_isolator_id_isolator_id',
			'local' => 'isolator_id',
			'foreign' => 'id',
			'foreignTable' => 'isolator',
			));
		$this->createForeignKey('strain', 'strain_depositor_id_depositor_id', array(
			'name' => 'strain_depositor_id_depositor_id',
			'local' => 'depositor_id',
			'foreign' => 'id',
			'foreignTable' => 'depositor',
			));
		$this->createForeignKey('strain', 'strain_identifier_id_identifier_id', array(
			'name' => 'strain_identifier_id_identifier_id',
			'local' => 'identifier_id',
			'foreign' => 'id',
			'foreignTable' => 'identifier',
			));
		$this->createForeignKey('strain', 'strain_maintenance_status_id_maintenance_status_id', array(
			'name' => 'strain_maintenance_status_id_maintenance_status_id',
			'local' => 'maintenance_status_id',
			'foreign' => 'id',
			'foreignTable' => 'maintenance_status',
			));
		$this->createForeignKey('strain', 'strain_cryopreservation_method_id_cryopreservation_method_id', array(
			'name' => 'strain_cryopreservation_method_id_cryopreservation_method_id',
			'local' => 'cryopreservation_method_id',
			'foreign' => 'id',
			'foreignTable' => 'cryopreservation_method',
			));
		$this->createForeignKey('strain_growth_mediums', 'strain_growth_mediums_growth_medium_id_growth_medium_id', array(
			'name' => 'strain_growth_mediums_growth_medium_id_growth_medium_id',
			'local' => 'growth_medium_id',
			'foreign' => 'id',
			'foreignTable' => 'growth_medium',
			));
		$this->createForeignKey('strain_growth_mediums', 'strain_growth_mediums_strain_id_strain_id', array(
			'name' => 'strain_growth_mediums_strain_id_strain_id',
			'local' => 'strain_id',
			'foreign' => 'id',
			'foreignTable' => 'strain',
			'onDelete' => 'cascade',
			));
		$this->createForeignKey('strain_relative', 'strain_relative_strain_id_strain_id', array(
			'name' => 'strain_relative_strain_id_strain_id',
			'local' => 'strain_id',
			'foreign' => 'id',
			'foreignTable' => 'strain',
			'onUpdate' => '',
			'onDelete' => 'cascade',
			));
		$this->addIndex('strain', 'strain_sample_id', array(
			'fields' =>
		array(
			0 => 'sample_id',
			),
			));
		$this->addIndex('strain', 'strain_dna_id', array(
			'fields' =>
		array(
			0 => 'dna_id',
			),
			));
		$this->addIndex('strain', 'strain_taxonomic_class_id', array(
			'fields' =>
		array(
			0 => 'taxonomic_class_id',
			),
			));
		$this->addIndex('strain', 'strain_genus_id', array(
			'fields' =>
		array(
			0 => 'genus_id',
			),
			));
		$this->addIndex('strain', 'strain_species_id', array(
			'fields' =>
		array(
			0 => 'species_id',
			),
			));
		$this->addIndex('strain', 'strain_authority_id', array(
			'fields' =>
		array(
			0 => 'authority_id',
			),
			));
		$this->addIndex('strain', 'strain_isolator_id', array(
			'fields' =>
		array(
			0 => 'isolator_id',
			),
			));
		$this->addIndex('strain', 'strain_depositor_id', array(
			'fields' =>
		array(
			0 => 'depositor_id',
			),
			));
		$this->addIndex('strain', 'strain_identifier_id', array(
			'fields' =>
		array(
			0 => 'identifier_id',
			),
			));
		$this->addIndex('strain', 'strain_maintenance_status_id', array(
			'fields' =>
		array(
			0 => 'maintenance_status_id',
			),
			));
		$this->addIndex('strain', 'strain_cryopreservation_method_id', array(
			'fields' =>
		array(
			0 => 'cryopreservation_method_id',
			),
			));
		$this->addIndex('strain_growth_mediums', 'strain_growth_mediums_growth_medium_id', array(
			'fields' =>
		array(
			0 => 'growth_medium_id',
			),
			));
		$this->addIndex('strain_growth_mediums', 'strain_growth_mediums_strain_id', array(
			'fields' =>
		array(
			0 => 'strain_id',
			),
			));
		$this->addIndex('strain_relative', 'strain_relative_strain_id', array(
			'fields' =>
		array(
			0 => 'strain_id',
			),
			));
	}

	public function down() {
		$this->dropForeignKey('strain', 'strain_sample_id_sample_id');
		$this->dropForeignKey('strain', 'strain_dna_id_dna_id');
		$this->dropForeignKey('strain', 'strain_taxonomic_class_id_taxonomic_class_id');
		$this->dropForeignKey('strain', 'strain_genus_id_genus_id');
		$this->dropForeignKey('strain', 'strain_species_id_species_id');
		$this->dropForeignKey('strain', 'strain_authority_id_authority_id');
		$this->dropForeignKey('strain', 'strain_isolator_id_isolator_id');
		$this->dropForeignKey('strain', 'strain_depositor_id_depositor_id');
		$this->dropForeignKey('strain', 'strain_identifier_id_identifier_id');
		$this->dropForeignKey('strain', 'strain_maintenance_status_id_maintenance_status_id');
		$this->dropForeignKey('strain', 'strain_cryopreservation_method_id_cryopreservation_method_id');
		$this->dropForeignKey('strain_growth_mediums', 'strain_growth_mediums_growth_medium_id_growth_medium_id');
		$this->dropForeignKey('strain_growth_mediums', 'strain_growth_mediums_strain_id_strain_id');
		$this->dropForeignKey('strain_relative', 'strain_relative_strain_id_strain_id');
		$this->removeIndex('strain', 'strain_sample_id', array(
			'fields' =>
		array(
			0 => 'sample_id',
			),
			));
		$this->removeIndex('strain', 'strain_dna_id', array(
			'fields' =>
		array(
			0 => 'dna_id',
			),
			));
		$this->removeIndex('strain', 'strain_taxonomic_class_id', array(
			'fields' =>
		array(
			0 => 'taxonomic_class_id',
			),
			));
		$this->removeIndex('strain', 'strain_genus_id', array(
			'fields' =>
		array(
			0 => 'genus_id',
			),
			));
		$this->removeIndex('strain', 'strain_species_id', array(
			'fields' =>
		array(
			0 => 'species_id',
			),
			));
		$this->removeIndex('strain', 'strain_authority_id', array(
			'fields' =>
		array(
			0 => 'authority_id',
			),
			));
		$this->removeIndex('strain', 'strain_isolator_id', array(
			'fields' =>
		array(
			0 => 'isolator_id',
			),
			));
		$this->removeIndex('strain', 'strain_depositor_id', array(
			'fields' =>
		array(
			0 => 'depositor_id',
			),
			));
		$this->removeIndex('strain', 'strain_identifier_id', array(
			'fields' =>
		array(
			0 => 'identifier_id',
			),
			));
		$this->removeIndex('strain', 'strain_maintenance_status_id', array(
			'fields' =>
		array(
			0 => 'maintenance_status_id',
			),
			));
		$this->removeIndex('strain', 'strain_cryopreservation_method_id', array(
			'fields' =>
		array(
			0 => 'cryopreservation_method_id',
			),
			));
		$this->removeIndex('strain_growth_mediums', 'strain_growth_mediums_growth_medium_id', array(
			'fields' =>
		array(
			0 => 'growth_medium_id',
			),
			));
		$this->removeIndex('strain_growth_mediums', 'strain_growth_mediums_strain_id', array(
			'fields' =>
		array(
			0 => 'strain_id',
			),
			));
		$this->removeIndex('strain_relative', 'strain_relative_strain_id', array(
			'fields' =>
		array(
			0 => 'strain_id',
			),
			));
	}
}