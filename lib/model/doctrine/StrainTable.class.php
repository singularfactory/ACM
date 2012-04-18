<?php
/**
 * Model class
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
 * @package       ACM.Lib.Model
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */


/**
 * StrainTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class StrainTable extends Doctrine_Table {
	/**
	* Returns an instance of this class.
	*
	* @return object StrainTable
	*/
	public static function getInstance() {
		return Doctrine_Core::getTable('Strain');
	}

	public function getDefaultStrainId() {
		$strain = $this->createQuery('s')->fetchOne();
		if ( $strain ) {
			return (int)$strain->getId();
		}

		return 0;
	}

	public function findByTerm($term = '') {
		if ( preg_match('/0*(\d+)/', $term, $matches) ) {
			return $this->createQuery('s')
				->where('s.code LIKE ?', $matches[1])
				->execute();
		}
		else {
			return $this->createQuery('s')->execute();
		}
	}
}