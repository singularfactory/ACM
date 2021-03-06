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
 * Sample
 *
 * @package ACM.Lib.Model
 * @since 1.0
 */
class Sample extends BaseSample {
	public function getCode() {
		$id = $this->getId();
		if (!isset($id)) {
			return sfConfig::get('app_no_data_message');
		}

		$code = str_pad($id, 4, '0', STR_PAD_LEFT);
		$countryCode = $regionCode = $islandCode = '';
		$dateCode = date('ymd', strtotime($this->getCollectionDate()));

		if ($location = $this->getLocation()) {
			if ($country = $location->getCountry()) {
				$countryCode = $country->getCode();
			}

			if ($region = $location->getRegion()) {
				$regionCode = str_pad($region->getCode(), 3, '_', STR_PAD_LEFT);
			}

			if ($island = $location->getIsland()) {
				$islandCode = $island->getCode();
				if (empty($islandCode))
					$islandCode = '00';
			}
		}

		return $code.$countryCode.$regionCode.$islandCode.$dateCode;
	}

	protected function getNotNullAttribute($attribute) {
		$value = $this->_get($attribute);
		if ( $value === null ) {
			return sfConfig::get('app_no_data_message');
		}
		return $value;
	}

	public function getFormattedIsExtremophile() {
		if ( $this->getIsExtremophile() ) {
			return 'yes';
		}
		return 'no';
	}

	public function getFormattedPh() {
		return $this->getNotNullAttribute('ph');
	}

	public function getFormattedConductivity() {
		$conductivity = $this->getNotNullAttribute('conductivity');

		if ( $conductivity !== sfConfig::get('app_no_data_message') ) {
			$conductivity .= ' '.sfConfig::get('app_conductivity_unit');
		}
		return $conductivity;
	}

	public function getFormattedTemperature() {
		$temperature = $this->getNotNullAttribute('temperature');

		if ( $temperature !== sfConfig::get('app_no_data_message') ) {
			$temperature .= ' '.sfConfig::get('app_temperature_unit');
		}
		return $temperature;
	}

	public function getFormattedSalinity() {
		$salinity = $this->getNotNullAttribute('salinity');

		if ( $salinity !== sfConfig::get('app_no_data_message') ) {
			$salinity .= ' '.sfConfig::get('app_salinity_unit');
		}
		return $salinity;
	}

	public function getFormattedAltitude() {
		$altitude = $this->getNotNullAttribute('altitude');

		if ( $altitude !== sfConfig::get('app_no_data_message') ) {
			$altitude .= ' '.sfConfig::get('app_altitude_unit');
		}
		return $altitude;
	}

	public function getFormattedEnvironment() {
		if ( $this->getEnvironment()->exists() ) {
			return $this->getEnvironment()->getName();
		}
		return sfConfig::get('app_no_data_message');
	}

	public function getFormattedHabitat() {
		if ( $this->getHabitat()->exists() ) {
			return $this->getHabitat()->getName();
		}
		return sfConfig::get('app_no_data_message');
	}

	public function getGPSCoordinates() {
		return array(
			'latitude' => $this->getLatitude(),
			'longitude' => $this->getLongitude(),
		);
	}

	public function getFormattedGPSCoordinates() {
		$coordinates = $this->getGPSCoordinates();

		if ( $coordinates['latitude'] === null || $coordinates['longitude'] === null ) {
			return sfConfig::get('app_no_data_message');
		}
		elseif ( $coordinates['latitude'] === '' || $coordinates['longitude'] === '' ) {
			return sfConfig::get('app_no_data_message');
		}
		return $coordinates['latitude'].', '.$coordinates['longitude'];
	}

	public function getLatitude() {
		$latitude = $this->_get('latitude');

		if ( $latitude === null ) {
			return $this->getLocation()->getLatitude();
		}
		elseif ( $latitude === '' ) {
			return $this->getLocation()->getLatitude();
		}

		return $latitude;
	}

	public function getLongitude() {
		$longitude = $this->_get('longitude');

		if ( $longitude === null ) {
			return $this->getLocation()->getLongitude();
		}
		elseif ( $longitude === '' ) {
			return $this->getLocation()->getLongitude();
		}

		return $longitude;
	}

	public function hasPictures() {
		return ( $this->getFieldPictures() || $this->getDetailedPictures() || $this->getMicroscopicPictures() );
	}

	public function getNbFieldPictures() {
		return Doctrine_Query::create()
			->from('FieldPicture fp')
			->where('fp.sample_id = ?', $this->getId())
			->count();
	}

	public function getNbDetailedPictures() {
		return Doctrine_Query::create()
			->from('DetailedPicture dp')
			->where('dp.sample_id = ?', $this->getId())
			->count();
	}

	public function getNbMicroscopicPictures() {
		return Doctrine_Query::create()
			->from('MicroscopicPicture mp')
			->where('mp.sample_id = ?', $this->getId())
			->count();
	}

	public function getNbStrains() {
		return Doctrine_Query::create()
			->from('Strain s')
			->where('s.sample_id = ?', $this->getId())
			->count();
	}

	public function getNbIsolations() {
		return Doctrine_Query::create()
			->from('Isolation i')
			->where('i.sample_id = ?', $this->getId())
			->count();
	}

	public function getNbCollectors() {
		return count($this->getCollectors());
	}

	public function getPictures() {
		$pictures = array();
		foreach ( $this->getFieldPictures() as $picture ) {
			$pictures[] = $picture;
		}
		foreach ( $this->getDetailedPictures() as $picture ) {
			$pictures[] = $picture;
		}
		foreach ( $this->getMicroscopicPictures() as $picture ) {
			$pictures[] = $picture;
		}

		return $pictures;
	}

	public function getFormattedCollectionDate() {
		return $this->formatDate($this->_get('collection_date'));
	}

	public function getFormattedCollectors() {
		$collectors = '';
		foreach ( $this->getCollectors() as $collector ) {
			$name = $collector->getName();
			$surname = $collector->getSurname();
			$collectors .= "$name $surname, ";
		}

		if ( empty($collectors) ) {
			return sfConfig::get('app_no_data_message');
		}
		else {
			return preg_replace('/, $/', '', $collectors);
		}
	}

	public function getLocationNameAndDetails() {
		if ( $details = $this->_get('location_details') ) {
			return sprintf('%s - %s', $this->getLocation()->getName(), $details);
		}
		return $this->getLocation()->getName();
	}

	public function getNbCryopreservations() {
		return CryopreservationTable::getInstance()->createQuery('c')
			->where('c.sample_id = ?', $this->getId())
			->count();
	}

	public function isCryopreserverd() {
		return $this->getNbCryopreservations() > 0;
	}
}
