<?php
/**
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
 * @package       ACM.Frontend
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */
?>
<?php

/**
 * MyGoogleMap class.
 *
 * @package ACM.Frontend
 * @subpackage frontend
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 */
class MyGoogleMap extends GMap {

	public $coordinates = array('latitude' => null, 'longitude' => null);

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
		$coordinates = $this->guessGPSCoordinates($address);

		$marker = new GMapMarker(
			$coordinates[1],
			$coordinates[0],
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
			$coordinate = abs($matches[1]) + ($matches[2] / 60.0) + ($matches[3] / 3600.0);
			if ( $matches[1] < 0.0 ) {
				$coordinate = $coordinate * -1.0;
			}

			return $coordinate;
		}
		else {
			return 0.0;
		}
	}

	/**
	 * Returns the guessed GPS coordinates given a place description
	 *
	 * @param string description
	 * @return void
	 * @author Eliezer Talon
	 */
	public function guessGPSCoordinates($description = '') {
		$apiKeys = sfConfig::get('app_google_maps_api_keys');
		$url = "http://maps.google.com/maps/geo?q=".urlencode($description)."&amp;output=json&amp;key=".$apiKeys[$_SERVER['SERVER_NAME']];

		$data = json_decode(file_get_contents($url), true);

		if ( is_array($data) && !empty($data['Placemark']) ) {
			$coordinates = $data['Placemark'][0]['Point']['coordinates'];
			$this->coordinates['latitude'] = $coordinates[1];
			$this->coordinates['longitude'] =$coordinates[0];

			return $coordinates;
		}

		return null;
	}

}
