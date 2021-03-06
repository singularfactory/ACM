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
class Version149 extends Doctrine_Migration_Base {
	public function up() {
		$this->createForeignKey('cryopreservation', 'cryopreservation_sample_id_sample_id', array(
			'name' => 'cryopreservation_sample_id_sample_id',
			'local' => 'sample_id',
			'foreign' => 'id',
			'foreignTable' => 'sample',
		));
		$this->createForeignKey('cryopreservation', 'cryopreservation_strain_id_strain_id', array(
			'name' => 'cryopreservation_strain_id_strain_id',
			'local' => 'strain_id',
			'foreign' => 'id',
			'foreignTable' => 'strain',
		));
		$this->createForeignKey('cryopreservation', 'ccci', array(
			'name' => 'ccci',
			'local' => 'cryopreservation_method_id',
			'foreign' => 'id',
			'foreignTable' => 'cryopreservation_method',
		));
		$this->addIndex('cryopreservation', 'cryopreservation_sample_id', array('fields' => array(0 => 'sample_id',),));
		$this->addIndex('cryopreservation', 'cryopreservation_strain_id', array('fields' => array(0 => 'strain_id',),));
		$this->addIndex('cryopreservation', 'cryopreservation_cryopreservation_method_id', array('fields' => array(0 => 'cryopreservation_method_id',),));
	}

	public function down() {
		$this->dropForeignKey('cryopreservation', 'cryopreservation_sample_id_sample_id');
		$this->dropForeignKey('cryopreservation', 'cryopreservation_strain_id_strain_id');
		$this->dropForeignKey('cryopreservation', 'ccci');
		$this->removeIndex('cryopreservation', 'cryopreservation_sample_id', array('fields' => array(0 => 'sample_id',),));
		$this->removeIndex('cryopreservation', 'cryopreservation_strain_id', array('fields' => array(0 => 'strain_id',),));
		$this->removeIndex('cryopreservation', 'cryopreservation_cryopreservation_method_id', array('fields' => array(0 => 'cryopreservation_method_id',),));
	}
}