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
 * Cryopreservation
 *
 * @package ACM.Lib.Model
 * @since 1.0
 */
class Cryopreservation extends BaseCryopreservation {
	public function getCode() {
		if ($this->getSample()->exists()) {
			return $this->getSample()->getCode();
		}
		elseif ($this->getStrain()->exists()) {
			return $thi->getStrain()->getFullCode();
		}
		elseif ($this->getExternalStrain()->exists()) {
			return $this->getExternalStrain()->getFullCode();
		}
		elseif ($this->getPatentDeposit()->exists()) {
			return $this->getPatentDeposit()->getCode();
		}
		elseif ($this->getMaintenanceDeposit()->exists()) {
			return $this->getMaintenanceDeposit()->getCode();
		}

		return sfConfig::get('app_no_data_message');
	}

	public function getCryopreservationDate() {
		if ( $date = $this->_get('cryopreservation_date') ) {
			return $this->formatDate($date);
		}
		else {
			return sfConfig::get('app_no_data_message');
		}
	}

	public function getRevivalDate() {
		if ( $date = $this->_get('revival_date') ) {
			return $this->formatDate($date);
		}
		else {
			return sfConfig::get('app_no_data_message');
		}
	}

	public function getFormattedDensity() {
		return sprintf('%.2f %s', $this->_get('density'), sfConfig::get('app_cryopreservation_density_unit'));
	}

	public function getFormattedViability() {
		if ( $this->_get('viability') ) {
			return 'Yes';
		}
		else {
			return 'No';
		}
	}
}
