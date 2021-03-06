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
class Version138 extends Doctrine_Migration_Base {

	public function up() {
		echo ">> up(): creating foreign key on `project_name_id` column in `project` table\n";
		$this->createForeignKey('project', 'project_project_name_id_project_name_id', array(
			'name' => 'project_project_name_id_project_name_id',
			'local' => 'project_name_id',
			'foreign' => 'id',
			'foreignTable' => 'project_name',
		));

		echo ">> up(): dropping `name` column from `project` table\n";
		$this->removeColumn('project', 'name');
	}

	public function down() {
		$this->dropForeignKey('project', 'project_project_name_id_project_name_id');
		$this->addColumn('project', 'name', 'string', '200', array('notnull' => '1',));
	}

}