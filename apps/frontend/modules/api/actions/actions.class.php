<?php

/**
* api actions.
*
* @package    bna_green_house
* @subpackage api
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class apiActions extends sfActions {

	/**
	* Executes index action
	*
	* @param sfRequest $request A request object
	*/
	public function executeSamplingInformation(sfWebRequest $request) {
		$token = $request->getParameter('token');
		
		// Check that the user exists and has a valid token
		$user = sfGuardUserTable::getInstance()->findOneByToken($token);
		if ( !$user ) {
			throw new sfError404Exception("User with token $token does not exist or is not activated.");
		}
		
		// Retrieve the information
		$info = array();
		$entities = array(
			'Country' => 'CountryTable',
			'Region' => 'RegionTable',
			'Island' => 'IslandTable',
			'Environment' => 'EnvironmentTable',
			'Habitat' => 'HabitatTable',
			'Radiation' => 'RadiationTable',
			'Location' => 'LocationTable',
			'Collector' => 'CollectorTable',
		);
		
		foreach ( $entities as $entity => $table ) {
			$records = $table::getInstance()->findAll();
			
			$tmp = array();
			foreach ( $records as $record ) {
				$tmp['id'] = $record->getId();
				$tmp['name'] = $record->getName();
				
				switch ( $entity ) {
					case 'Country':
					case 'Region':
					case 'Island':
						$tmp['code'] = $record->getCode();
						break;
						
					case 'Location':
						$tmp['latitude'] = $record->getLatitude();
						$tmp['longitude'] = $record->getLongitude();
						$tmp['country_id'] = $record->getCountryId();
						$tmp['region_id'] = $record->getRegionId();
						$tmp['island_id'] = $record->getIslandId();
						break;
					
					case 'Collector':
						$tmp['surname'] = $record->getSurname();
						$tmp['email'] = $record->getEmail();
						break;
				}
				
				$info[sfInflector::tableize($entity)][] = $tmp;
			}
		}
		
		// Return the information as a JSON object
		$this->getResponse()->setContent(json_encode($info));
		return sfView::NONE;
	}
}
