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
 * MaintenanceDepositTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class MaintenanceDepositTable extends Doctrine_Table {
	/**
	 * Returns an instance of this class.
	 *
	 * @return object MaintenanceDepositTable
	 */
	public static function getInstance() {
		return Doctrine_Core::getTable('MaintenanceDeposit');
	}

	public function findByTerm($term = '') {
		if ( preg_match('/^(BEA)?0*([1-9]\d*)/', $term, $matches) ) {
			return $this->createQuery('s')
				->where('s.depositor_code LIKE ?', "%{$matches[2]}%")
				->execute();
		}
		else {
			return $this->createQuery('s')->execute();
		}
	}

	public function availableSupervisorsQuery() {
		return sfGuardUserTable::getInstance()->createQuery('Supervisor')
			->distinct()
			->innerJoin('Supervisor.MaintenanceDeposits MaintenanceDeposit')
			->orderBy('Supervisor.initials');
	}

	public function availableTransferIntervalChoices($supervisor) {
		$deposits = MaintenanceDepositTable::getInstance()->createQuery('p')
			->distinct()
			->select('p.transfer_interval')
			->where('p.supervisor_id = ?', $supervisor)
			->orderBy('p.transfer_interval')
			->execute();

		$transferIntervals = array(0 => '');
		foreach ($deposits as $deposit) {
			$interval = $deposit->getTransferInterval();
			if ($interval && !array_key_exists($interval, $transferIntervals)) {
				$transferIntervals[$interval] = $interval;
			}
		}
		ksort($transferIntervals);
		return $transferIntervals;
	}

	public function availableGenusQuery($supervisor, $transferInterval) {
		return GenusTable::getInstance()->createQuery('g')
			->distinct()
			->innerJoin('g.MaintenanceDeposits p')
			->where('p.supervisor_id = ?', $supervisor)
			->andWhere("p.transfer_interval LIKE ?", $transferInterval)
			->orderBy('g.name');
	}

	public function availableCultureMediaQuery($supervisor, $transferInterval, $genus, $axenic) {
		$axenic = ($axenic == 2) ? 1 : 0;
		return CultureMediumTable::getInstance()->createQuery('c')
			->distinct()
			->innerJoin('c.MaintenanceDepositCultureMedia pc')
			->innerJoin('pc.MaintenanceDeposit p')
			->innerJoin('p.Genus g')
			->where('p.supervisor_id = ?', $supervisor)
			->andWhere("p.transfer_interval LIKE ?", $transferInterval)
			->andWhere('p.genus_id = ?', $genus)
			->andWhere('p.is_axenic = ?', $axenic)
			->orderBy('c.name');
	}

	public function availableMaintenanceDepositsForLabelConfiguration($configuration) {
		$axenic = ($configuration['is_axenic'] == 2) ? 1 : 0;
		return MaintenanceDepositTable::getInstance()->createQuery('s')
			->distinct()
			->innerJoin('s.MaintenanceDepositCultureMedia cm')
			->where('s.supervisor_id = ?', $configuration['supervisor_id'])
			->andWhere("s.transfer_interval LIKE ?", $configuration['transfer_interval'])
			->andWhere('s.genus_id = ?', $configuration['genus_id'])
			->andWhere('s.is_axenic = ?', $axenic)
			->andWhere('cm.culture_medium_id = ?', $configuration['culture_medium_id'])
			->orderBy('s.id')
			->execute();
	}
}
