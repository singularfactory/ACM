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