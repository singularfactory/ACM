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
 * MaintenanceDeposit
 *
 * @package ACM.Lib.Model
 * @since 1.0
 */
class MaintenanceDeposit extends BaseMaintenanceDeposit {
	public function getCode() {
		return sprintf('BEA M%s_%s',
			str_pad($this->getYearlyCount(), 2, '0', STR_PAD_LEFT),
			date('y', strtotime($this->getDepositionDate()))
		);
	}

	public function getNbCultureMedia() {
		return MaintenanceDepositCultureMediaTable::getInstance()->createQuery('cm')
			->where('cm.maintenance_deposit_id = ?', $this->getId())
			->count();
	}

	public function getNbCollectors() {
		return MaintenanceDepositCollectorsTable::getInstance()->createQuery('c')
			->where('c.maintenance_deposit_id = ?', $this->getId())
			->count();
	}

	public function getNbIsolators() {
		return MaintenanceDepositIsolatorsTable::getInstance()->createQuery('i')
			->where('i.maintenance_deposit_id = ?', $this->getId())
			->count();
	}

	public function getNbRelatives() {
		return MaintenanceDepositRelativeTable::getInstance()->createQuery('r')
			->where('r.maintenance_deposit_id = ?', $this->getId())
			->count();
	}

	public function hasDna() {
		if ($this->_get('has_dna')) {
			return true;
		}
		return false;
	}

	public function isAxenic() {
		if ($this->_get('is_axenic')) {
			return true;
		}
		return false;
	}

	public function getFormattedEnvironment() {
		if ($this->getEnvironment()->exists()) {
			return $this->getEnvironment()->getName();
		}
		return sfConfig::get('app_no_data_message');
	}

	public function getFormattedHabitat() {
		if ($this->getHabitat()->exists()) {
			return $this->getHabitat()->getName();
		}
		return sfConfig::get('app_no_data_message');
	}

	public function getFormattedHasDna() {
		if ($this->hasDna()) {
			return 'yes';
		}
		return 'no';
	}

	public function getFormattedIsBlend() {
		if ($this->getIsBlend()) {
			return 'yes';
		}
		return 'no';
	}

	public function getFormattedIsEpitype() {
		if ($this->getIsEpitype()) {
			return 'yes';
		}
		return 'no';
	}

	public function getFormattedIsAxenic() {
		if ($this->isAxenic()) {
			return 'yes';
		}
		return 'no';
	}

	public function getFormattedCitations() {
		if ($citations = $this->_get('citations')) {
			return $citations;
		}
		return sfConfig::get('app_no_data_message');
	}

	public function getFormattedViabilityTest() {
		if ($test = $this->_get('viability_test')) {
			return $test;
		}
		return sfConfig::get('app_no_data_message');
	}

	public function getFormattedTransferInterval() {
		if ($transferInterval = $this->_get('transfer_interval')) {
			return "$transferInterval weeks";
		}
		return sfConfig::get('app_no_data_message');
	}

	public function getFormattedObservation() {
		if ($observation = $this->_get('observation')) {
			return $observation;
		}
		return sfConfig::get('app_no_data_message');
	}

	public function getDepositionDate() {
		if ($date = $this->_get('deposition_date')) {
			return $this->formatDate($date);
		}
		else {
			return sfConfig::get('app_no_data_message');
		}
	}

	public function getIsolationDate() {
		if ($date = $this->_get('isolation_date')) {
			return $this->formatDate($date);
		}
		else {
			return sfConfig::get('app_no_data_message');
		}
	}

	public function getCollectionDate() {
		if ( $date = $this->_get('collection_date')) {
			return $this->formatDate($date);
		}
		else {
			return sfConfig::get('app_no_data_message');
		}
	}

	public function getMf1DocumentUrl() {
		$path = sfConfig::get('app_documents_dir').sfConfig::get('app_maintenance_deposit_dir');
		$filename = $this->getMf1Document();

		if ( empty($filename) ) {
			return null;
		}
		else {
			return "$path/$filename";
		}
	}

	public function getGenusAndSpecies() {
		return sprintf('%s %s', $this->getGenus(), $this->getSpecies());
	}

	public function getNbCryopreservations() {
		return CryopreservationTable::getInstance()->createQuery('c')
			->where('c.maintenance_deposit_id = ?', $this->getId())
			->count();
	}

	public function isCryopreserved() {
		return $this->getNbCryopreservations() > 0;
	}

	public function getFormattedMaintenanceStatusList() {
		$statuses = array();
		foreach ($this->getMaintenanceStatus() as $status) {
			$statuses[] = $status;
		}
		if ($this->isCryopreserved()) {
			$statuses[] = 'Cryopreserved';
		}
		return implode(', ', $statuses);
	}
}
