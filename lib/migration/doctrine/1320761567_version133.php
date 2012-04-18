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
class Version133 extends Doctrine_Migration_Base {
	public function up() {
		$this->removeColumn('patent_deposit', 'bp1_link');
		$this->removeColumn('patent_deposit', 'bp4_link');
		$this->addColumn('patent_deposit', 'bp1_document', 'string', '255', array('notnull' => '1'));
		$this->addColumn('patent_deposit', 'bp4_document', 'string', '255', array('notnull' => '1'));
	}

	public function down() {
		$this->addColumn('patent_deposit', 'bp1_link', 'string', '1024', array('notnull' => '1'));
		$this->addColumn('patent_deposit', 'bp4_link', 'string', '1024', array('notnull' => '1'));
		$this->removeColumn('patent_deposit', 'bp1_document');
		$this->removeColumn('patent_deposit', 'bp4_document');
	}
}