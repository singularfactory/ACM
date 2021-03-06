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
 * IsolationTable
 *
 */
class IsolationTable extends Doctrine_Table {
	/**
	 * Returns an instance of this class.
	 *
	 * @return object IsolationTable
	 */
	public static function getInstance() {
		return Doctrine_Core::getTable('Isolation');
	}

	public function findByTerm($term = '') {
		if ( preg_match('/^(BEA)?0*([1-9]\d*)/', $term, $matches) ) {
			return $this->createQuery('i')
				->leftJoin('i.Sample sa')
				->leftJoin('i.Strain st')
				->leftJoin('i.ExternalStrain est')
				->where('i.external_code LIKE ?', "%{$matches[2]}%")
				->orWhere('sa.id LIKE ?', "%{$matches[2]}%")
				->orWhere('st.id LIKE ?', "%{$matches[2]}%")
				->orWhere('est.id LIKE ?', "%{$matches[2]}%")
				->execute();
		}
		else {
			return $this->createQuery('s')->execute();
		}
	}

	public function getNextYearlyCount($year) {
		$minDate = sprintf('%s-01-01', $year);
		$maxDate = sprintf('%s-12-31', $year);
		$isolations = $this->createQuery('i')
			->where('i.reception_date >= ?', $minDate)
			->andWhere('i.reception_date <= ?', $maxDate)
			->orderBy('i.reception_date DESC, i.yearly_count DESC')
			->limit(1)
			->execute();

		if ($isolations->count()) {
			return $isolations->getFirst()->getYearlyCount() + 1;
		} else {
			return 1;
		}
	}
}
