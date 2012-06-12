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
class Version165 extends Doctrine_Migration_Base {
	public function up() {
		$this->createForeignKey('external_strain', 'external_strain_taxonomic_class_id_taxonomic_class_id', array(
			'name' => 'external_strain_taxonomic_class_id_taxonomic_class_id',
			'local' => 'taxonomic_class_id',
			'foreign' => 'id',
			'foreignTable' => 'taxonomic_class',
		));
		$this->createForeignKey('external_strain', 'external_strain_genus_id_genus_id', array(
			'name' => 'external_strain_genus_id_genus_id',
			'local' => 'genus_id',
			'foreign' => 'id',
			'foreignTable' => 'genus',
		));
		$this->createForeignKey('external_strain', 'external_strain_species_id_species_id', array(
			'name' => 'external_strain_species_id_species_id',
			'local' => 'species_id',
			'foreign' => 'id',
			'foreignTable' => 'species',
		));
		$this->createForeignKey('external_strain', 'external_strain_authority_id_authority_id', array(
			'name' => 'external_strain_authority_id_authority_id',
			'local' => 'authority_id',
			'foreign' => 'id',
			'foreignTable' => 'authority',
		));
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
		$this->createForeignKey('external_strain', 'external_strain_identifier_id_identifier_id', array(
			'name' => 'external_strain_identifier_id_identifier_id',
			'local' => 'identifier_id',
			'foreign' => 'id',
			'foreignTable' => 'identifier',
		));
		$this->createForeignKey('external_strain', 'ecci', array(
			'name' => 'ecci',
			'local' => 'cryopreservation_method_id',
			'foreign' => 'id',
			'foreignTable' => 'cryopreservation_method',
		));
		$this->createForeignKey('external_strain', 'external_strain_container_id_container_id', array(
			'name' => 'external_strain_container_id_container_id',
			'local' => 'container_id',
			'foreign' => 'id',
			'foreignTable' => 'container',
		));
		$this->createForeignKey('external_strain_collectors', 'external_strain_collectors_external_strain_id_external_strain_id', array(
			'name' => 'external_strain_collectors_external_strain_id_external_strain_id',
			'local' => 'external_strain_id',
			'foreign' => 'id',
			'foreignTable' => 'external_strain',
			'onUpdate' => '',
			'onDelete' => 'cascade',
		));
		$this->createForeignKey('external_strain_containers', 'external_strain_containers_external_strain_id_external_strain_id', array(
			'name' => 'external_strain_containers_external_strain_id_external_strain_id',
			'local' => 'external_strain_id',
			'foreign' => 'id',
			'foreignTable' => 'external_strain',
			'onUpdate' => '',
			'onDelete' => 'cascade',
		));
		$this->createForeignKey('external_strain_containers', 'external_strain_containers_container_id_container_id', array(
			'name' => 'external_strain_containers_container_id_container_id',
			'local' => 'container_id',
			'foreign' => 'id',
			'foreignTable' => 'container',
		));
		$this->createForeignKey('external_strain_culture_media', 'eeei', array(
			'name' => 'eeei',
			'local' => 'external_strain_id',
			'foreign' => 'id',
			'foreignTable' => 'external_strain',
			'onUpdate' => '',
			'onDelete' => 'cascade',
		));
		$this->createForeignKey('external_strain_culture_media', 'ecci_1', array(
			'name' => 'ecci_1',
			'local' => 'culture_medium_id',
			'foreign' => 'id',
			'foreignTable' => 'culture_medium',
		));
		$this->createForeignKey('external_strain_isolators', 'external_strain_isolators_external_strain_id_external_strain_id', array(
			'name' => 'external_strain_isolators_external_strain_id_external_strain_id',
			'local' => 'external_strain_id',
			'foreign' => 'id',
			'foreignTable' => 'external_strain',
			'onUpdate' => '',
			'onDelete' => 'cascade',
		));
		$this->createForeignKey('external_strain_maintenance_status', 'eeei_2', array(
			'name' => 'eeei_2',
			'local' => 'external_strain_id',
			'foreign' => 'id',
			'foreignTable' => 'external_strain',
			'onUpdate' => '',
			'onDelete' => 'cascade',
		));
		$this->createForeignKey('external_strain_relative', 'external_strain_relative_external_strain_id_external_strain_id', array(
			'name' => 'external_strain_relative_external_strain_id_external_strain_id',
			'local' => 'external_strain_id',
			'foreign' => 'id',
			'foreignTable' => 'external_strain',
			'onUpdate' => '',
			'onDelete' => 'cascade',
		));
	}

	public function down() {
		$this->dropForeignKey('external_strain', 'external_strain_taxonomic_class_id_taxonomic_class_id');
		$this->dropForeignKey('external_strain', 'external_strain_genus_id_genus_id');
		$this->dropForeignKey('external_strain', 'external_strain_species_id_species_id');
		$this->dropForeignKey('external_strain', 'external_strain_authority_id_authority_id');
		$this->dropForeignKey('external_strain', 'external_strain_location_id_location_id');
		$this->dropForeignKey('external_strain', 'external_strain_environment_id_environment_id');
		$this->dropForeignKey('external_strain', 'external_strain_habitat_id_habitat_id');
		$this->dropForeignKey('external_strain', 'external_strain_identifier_id_identifier_id');
		$this->dropForeignKey('external_strain', 'ecci');
		$this->dropForeignKey('external_strain', 'external_strain_container_id_container_id');
		$this->dropForeignKey('external_strain_collectors', 'external_strain_collectors_external_strain_id_external_strain_id');
		$this->dropForeignKey('external_strain_containers', 'external_strain_containers_external_strain_id_external_strain_id');
		$this->dropForeignKey('external_strain_containers', 'external_strain_containers_container_id_container_id');
		$this->dropForeignKey('external_strain_culture_media', 'eeei');
		$this->dropForeignKey('external_strain_culture_media', 'ecci_1');
		$this->dropForeignKey('external_strain_isolators', 'external_strain_isolators_external_strain_id_external_strain_id');
		$this->dropForeignKey('external_strain_maintenance_status', 'eeei_2');
		$this->dropForeignKey('external_strain_relative', 'external_strain_relative_external_strain_id_external_strain_id');
	}
}