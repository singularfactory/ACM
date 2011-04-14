<?php

/**
* MyGoogleMap class.
*
* @package    bna_green_house
* @subpackage frontend
* @author     Eliezer Talon <elitalon@inventiaplus.com>
*/
class MyGoogleMap extends GMap {
	
	public function buildMarkerWindow($options = array()) {
		$html = '';
		
		if ( array_key_exists('title', $options) ) {
			$html .= '<h1 class="marker_title">'.$options['title'].'</h1>';
		}
		
		if ( array_key_exists('description', $options) ) {
			$html .= '<h2 class="marker_description">'.$options['description'].'</h2>';
		}
		
		if ( array_key_exists('notes', $options) ) {
			$html .= '<h3 class="marker_notes">'.$options['notes'].'</h3>';
		}
		
		return new GMapInfoWindow($html);
	}
	
	public function getHomeMarker() {
		$marker = new GMapMarker(
			sfConfig::get('app_default_latitude'),
			sfConfig::get('app_default_longitude'),
			array('icon' => new GMapMarkerImage(sfConfig::get('app_map_pictures_dir').'/bea.png', array('width' => 18, 'height' => 25))));

	    $marker->addHtmlInfoWindow($this->buildMarkerWindow(array(
	    	'title' => 'Banco Español de Algas',
			'description' => 'Headquarters of Banco Español de Algas',
			'notes' => 'Muelle de Taliarte s/n'
	    )));
		
		return $marker;
	}
	
	public function getMarkerFromCoordinates($latitude, $longitude, $window_options = array()) {
		if ( preg_match('/^-?\d+º\d+\'\d+("|\'\')$/', $latitude) ) {
			$latitude = MyGoogleMap::dms_to_decimal_degrees($latitude);
		}
		
		if ( preg_match('/^-?\d+º\d+\'\d+("|\'\')$/', $longitude) ) {
			$longitude = MyGoogleMap::dms_to_decimal_degrees($longitude);
		}
		
		$marker = new GMapMarker(
			$latitude,
			$longitude,
			array('icon' => new GMapMarkerImage(sfConfig::get('app_map_pictures_dir').'/location.png', array('width' => 18, 'height' => 25))));

		$marker->addHtmlInfoWindow($this->buildMarkerWindow($window_options));
		return $marker;
	}
	
	public function getMarkerFromAddress($address, $window_options = array()) {
	    $geocodedAddress = new GMapGeocodedAddress($address);
	    $geocodedAddress->geocode($this->getGMapClient());

		$marker = new GMapMarker(
			$geocodedAddress->getLat(),
			$geocodedAddress->getLng(),
			array('icon' => new GMapMarkerImage(sfConfig::get('app_map_pictures_dir').'/location.png', array('width' => 18, 'height' => 25))));
		
		if ( array_key_exists('notes', $window_options) && !empty($window_options['notes']) ) {
			$window_options['notes'] .= '<br />This location is <strong>not accurate</strong>. GPS coordinates were estimated from available information';
		}
		else {
			$window_options['notes'] = 'This location is <strong>not accurate</strong>. GPS coordinates were estimated from available information';
		}
		$marker->addHtmlInfoWindow($this->buildMarkerWindow($window_options));
		return $marker;
	}
	
	/**
	 * Converts degrees, minutes and seconds into decimal degrees
	 *
	 * @param string $coordinate
	 * @return double
	 * @author Eliezer Talon
	 * @version 2011-04-14
	 */
	public static function dms_to_decimal_degrees($coordinate) {
		if ( empty($coordinate) ) {
			return 0.0;
		}

		if ( preg_match('/^(-?\d+)º(\d+)\'(\d+)("|\'\')$/', $coordinate, $matches) ) {
			return $matches[1] + ($matches[2] / 60.0) + ($matches[3] / 3600.0);
		}
		else {
			return 0.0;
		}
	}
}
