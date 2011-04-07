<?php

/**
 * Sample
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class Sample extends BaseSample {
	public function getNumber() {
		$code = str_pad($this->getId(), 4, '0', STR_PAD_LEFT);
		
		$location = $this->getLocation();
		$countryCode = $location->getCountry()->getCode();
		$regionCode = str_pad($location->getRegion()->getCode(), 3, '_', STR_PAD_LEFT);
		$islandCode = $location->getIsland()->getCode();
		if ( empty($islandCode) )
			$islandCode = '00';
		$dateCode = date('ymd', strtotime($this->getCollectionDate()));
		
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
		return $this->getNotNullAttribute('conductivity');
	}
	
	public function getFormattedTemperature() {
		$temperature = $this->getNotNullAttribute('temperature');
		
		if ( $temperature !== sfConfig::get('app_no_data_message') ) {
			$temperature .= sfConfig::get('app_temperature_unit');
		}
		return $temperature;
	}
	
	public function getFormattedSalinity() {
		return $this->getNotNullAttribute('salinity');
	}
	
	public function getFormattedAltitude() {
		$altitude = $this->getNotNullAttribute('altitude');
		
		if ( $altitude !== sfConfig::get('app_no_data_message') ) {
			$altitude .= sfConfig::get('app_altitude_unit');
		}
		return $altitude;
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
}
