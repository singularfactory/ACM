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
 * SampleTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class SampleTable extends Doctrine_Table {
	/**
	 * Returns an instance of this class.
	 *
	 * @return object SampleTable
	 */
	public static function getInstance() {
	    return Doctrine_Core::getTable('Sample');
	}

	public function getSortedByNameQuery() {
		return $this->createQuery('s')->orderBy('s.id ASC');
	}

	public function findByTerm($term = '') {
		// Parse ID
		$id = '';
		if ( preg_match('/0*(\d+)/', $term, $matches) ) {
			$id = $matches[1];
		}

		return $this->createQuery('s')
			->leftJoin('s.Location l')
			->leftJoin('l.Country c')
			->leftJoin('l.Region r')
			->leftJoin('l.Island i')
			->where('s.id LIKE ?', "%$id%")
			->orWhere('s.notebook_code LIKE ?', "%$term%")
			->orWhere('c.code LIKE ?', "%$term%")
			->orWhere('r.code LIKE ?', "%$term%")
			->orWhere('i.code LIKE ?', "%$term%")
			->execute();
	}

	public function getDefaultSampleId() {
		$sample = $this->createQuery('s')->fetchOne();
		if ( $sample ) {
			return (int)$sample->getId();
		}

		return 0;
	}

}