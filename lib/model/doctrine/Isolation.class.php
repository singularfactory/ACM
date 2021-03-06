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
 * Isolation
 *
 * @package ACM.Lib.Model
 * @since 1.0
 */
class Isolation extends BaseIsolation {
	public function getRelatedCode() {
		if ( $code = $this->getExternalCode() ) {
			return $code;
		}
		else if ( $sample = $this->getSample() ) {
			return $sample->getCode();
		}
		else if ( $strain = $this->getStrain() ) {
			return $strain->getFullCode();
		}
		elseif ($externalStrain = $this->getExternalStrain()) {
			return $externalStrain->getFullCode();
		}
	}

	public function getCode() {
		return sprintf('BEA IS%s_%s',
			str_pad($this->getYearlyCount(), 2, '0', STR_PAD_LEFT),
			date('y', strtotime($this->getReceptionDate()))
		);
	}

	public function getReceptionDate() {
		if ( $date = $this->_get('reception_date') ) {
			return $this->formatDate($date);
		}
		else {
			return sfConfig::get('app_no_data_message');
		}
	}

	public function getIsolationDate() {
		if ( $date = $this->_get('isolation_date') ) {
			return $this->formatDate($date);
		}
		else {
			return sfConfig::get('app_no_data_message');
		}
	}

	public function getDeliveryDate() {
		if ( $date = $this->_get('delivery_date') ) {
			return $this->formatDate($date);
		}
		else {
			return sfConfig::get('app_no_data_message');
		}
	}

	public function getFormattedTaxonomicClass() {
		if ( $object = $this->getTaxonomicClass() ) {
			if ( $object->exists() ) {
				return $object->getName();
			}
		}

		return sfConfig::get('app_no_data_message');
	}

	public function getFormattedGenus() {
		if ( $object = $this->getGenus() ) {
			if ( $object->exists() ) {
				return $object->getName();
			}
		}

		return sfConfig::get('app_no_data_message');
	}

	public function getFormattedSpecies() {
		if ( $object = $this->getSpecies() ) {
			if ( $object->exists() ) {
				return $object->getName();
			}
		}

		return sfConfig::get('app_no_data_message');
	}

	public function getFormattedAuthority() {
		if ( $object = $this->getAuthority() ) {
			if ( $object->exists() ) {
				return $object->getName();
			}
		}

		return sfConfig::get('app_no_data_message');
	}

	public function getFormattedLocation() {
		if ( $object = $this->getLocation() ) {
			if ( $object->exists() ) {
				return $object->getName();
			}
		}

		return sfConfig::get('app_no_data_message');
	}

	public function getFormattedEnvironment() {
		if ( $object = $this->getEnvironment() ) {
			if ( $object->exists() ) {
				return $object->getName();
			}
		}

		return sfConfig::get('app_no_data_message');
	}

	public function getFormattedHabitat() {
		if ( $object = $this->getHabitat() ) {
			if ( $object->exists() ) {
				return $object->getName();
			}
		}

		return sfConfig::get('app_no_data_message');
	}

	public function getTaxonomicName() {
		return sprintf('%s %s %s', $this->getFormattedTaxonomicClass(), $this->getFormattedGenus(), $this->getFormattedSpecies());
	}

	public function getGenusAndSpecies() {
		return sprintf('%s %s', $this->getFormattedGenus(), $this->getSpecies());
	}

}
