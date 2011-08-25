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
	
	protected function validateTimestamp($timestamp = '') {
		// Check that the timestamp represents a valid date
		$timestamp = date("Y-m-d H:i:s", $timestamp);
		if ( !$timestamp ) {
			throw new sfError404Exception(sprintf('Timestamp %s is not valid.', $request->getParameter('timestamp')));
		}
		
		return $timestamp;
	}

	public function executeSamplingInformation(sfWebRequest $request) {
		$this->validateToken($request->getParameter('token'));
		$timestamp = $this->validateTimestamp($request->getParameter('timestamp'));
		
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
			$records = $tableInstance->createQuery('m')
				->where('m.updated_at >= ?', $timestamp)
				->fetchArray();
			
			$tmp = array();
			foreach ( $records as $record ) {
				$tmp['id'] = $record['id'];
				$tmp['name'] = $record['name'];
				
				switch ( $entity ) {
					case 'Country':
						$tmp['code'] = $record['code'];
						break;
					case 'Region':
						$tmp['code'] = $record['code'];
						$tmp['country_id'] = $record['country_id'];
						break;
					case 'Island':
						$tmp['code'] = $record['code'];
						$tmp['region_id'] = $record['region_id'];
						break;
					case 'Location':
						$tmp['latitude'] = $record['latitude'];
						$tmp['longitude'] = $record['longitude'];
						$tmp['country_id'] = $record['country_id'];
						$tmp['region_id'] = $record['region_id'];
						$tmp['island_id'] = $record['island_id'];
						break;
					case 'Collector':
						$tmp['surname'] = $record['surname'];
						$tmp['email'] = $record['email'];
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
