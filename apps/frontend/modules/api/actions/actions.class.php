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
	
	protected function validateToken($token = '') {
		$user = sfGuardUserTable::getInstance()->findOneByToken($token);
		if ( !$user ) {
			throw new sfError404Exception("User with token $token does not exist or is not activated.");
		}
		
		return true;
	}

	public function executeSamplingInformation(sfWebRequest $request) {
		$this->validateToken($request->getParameter('token'));
		
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
			$tableInstance = call_user_func(array($table, 'getInstance'));
			$records = $tableInstance->findAll();
			
			$tmp = array();
			foreach ( $records as $record ) {
				$tmp['id'] = $record->getId();
				$tmp['name'] = $record->getName();
				
				switch ( $entity ) {
					case 'Country':
						$tmp['code'] = $record->getCode();
						break;
					case 'Region':
						$tmp['code'] = $record->getCode();
						$tmp['country_id'] = $record->getCountryId();
						break;
					case 'Island':
						$tmp['code'] = $record->getCode();
						$tmp['region_id'] = $record->getRegionId();
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
	
	public function executeSyncSamplingInformation(sfWebRequest $request) {
		$this->validateToken($request->getParameter('token'));
		
		$info = json_decode($request->getParameter('json'));
		if ( !is_array($info) ) {
			throw new sfError404Exception("JSON content could not be decoded.");
		}
		
		$status = 0;
		foreach ( $info as $entity => $records ) {
			foreach ( $records as $record ) {
				
			}
		}
		
		$this->getResponse()->setContent($status);
		return sfView::NONE;
	}
}
