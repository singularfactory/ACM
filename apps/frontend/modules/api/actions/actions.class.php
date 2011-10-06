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
	
	// Error codes
	const HttpRequestSuccess = 200;
	const HttpInvalidRequestMethod = 405;
	const HttpInvalidToken = 401;
	const HttpInvalidTimestamp = 400;
	const HttpInvalidJSON = 400;
	const HttpServerError = 500;
	
	// HTTP status codes
	const RequestSuccess = 0;
	const InvalidRequestMethod = 1;
	const InvalidToken = 2;
	const InvalidTimestamp = 3;
	const InvalidJSON = 4;
	const ServerError = 5;
	
	protected function requestExitStatus($error = self::RequestSuccess, $content = '') {
		$exitStatus = self::HttpRequestSuccess;
		if ( empty($content) ) {
			switch ( $error ) {
				case self::InvalidRequestMethod:
					$content = 'Invalid request method';
					$exitStatus = self::HttpInvalidRequestMethod;
					break;
				case self::InvalidToken:
					$content = 'Invalid token';
					$exitStatus = self::HttpInvalidToken;
					break;
				case self::InvalidTimestamp:
					$content = 'Invalid timestamp';
					$exitStatus = self::HttpInvalidTimestamp;
					break;
				case self::InvalidJSON:
					$content = 'Invalid JSON';
					$exitStatus = self::HttpInvalidJSON;
					break;
				case self::ServerError:
					$content = 'Server error';
					$exitStatus = self::HttpServerError;
					break;
			}
		}
		
		$this->getResponse()->setStatusCode($exitStatus);
		$this->getResponse()->setContent($content);
		return sfView::NONE;
	}
	
	protected function validateToken($token = null) {
		return (sfGuardUserTable::getInstance()->findOneByToken($token) != false);
	}
	
	protected function validateTimestamp($timestamp = null) {
		return (date("Y-m-d H:i:s", $timestamp) != false);
	}
	
	protected function validateRequestMethod(sfWebRequest $request = null, $method) {
		return $request->isMethod($method);
	}
	
	protected function validateJson($data = '') {
		return json_decode($data, true);
	}
	
	public function executeSamplingInformation(sfWebRequest $request) {
		if ( !$this->validateRequestMethod($request, sfRequest::GET) ) {
			return $this->requestExitStatus(self::InvalidRequestMethod);
		}
		
		if ( !$this->validateToken($request->getParameter('token')) ) {
			return $this->requestExitStatus(self::InvalidToken);
		}
		
		$timestamp = $request->getParameter('timestamp');
		if ( !$this->validateTimestamp($timestamp) ) {
			return $this->requestExitStatus(self::InvalidTimestamp);
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
		return $this->requestExitStatus(self::RequestSuccess, json_encode($info));
	}
		
	public function executeAddSamplingInformation(sfWebRequest $request) {
		if ( !$this->validateRequestMethod($request, sfRequest::POST) ) {
			return $this->requestExitStatus(self::InvalidRequestMethod);
		}
		
		if ( !$this->validateToken($request->getParameter('token')) ) {
			return $this->requestExitStatus(self::InvalidToken);
		}
		
		$json = $this->validateJson($request->getParameter('jsonData'));
		if ( !is_array($json) ) {
			return $this->requestExitStatus(self::InvalidJSON);
		}
		
		// The creation of locations and samples must be wrapped under a database transaction
		$dbConnection = Doctrine_Manager::connection();
		try {
			$dbConnection->beginTransaction();
			
			// Create locations
			$locations = array();
			if ( isset($json['location']) ) {
				foreach ( $json['location'] as $records ) {
					$location = new Location;
					$location->setName($records['name']);
					$location->setLatitude($records['latitude']);
					$location->setLongitude($records['longitude']);
					$location->setCountryId($records['country_id']);
					$location->setRegionId($records['region_id']);
					$location->setIslandId($records['island_id']);
					$location->setRemarks($records['remarks']);
					$location->save();
					
					// Store the new ID of this location to compare with Sample.location_id
					$locations[$records['id']] = $location->getId();
				}
			}
			
			// Create samples
			if ( isset($json['sample']) ) {
				foreach ( $json['sample'] as $records ) {
					$sample = new Sample;
					$sample->setLatitude($records['latitude']);
					$sample->setLongitude($records['longitude']);
					$sample->setEnvironmentId($records['environment_id']);
					$sample->setHabitatId($records['habitat_id']);
					$sample->setPh($records['ph']);
					$sample->setConductivity($records['conductivity']);
					$sample->setTemperature($records['temperature']);
					$sample->setSalinity($records['salinity']);
					$sample->setAltitude($records['altitude']);
					$sample->setRadiationId($records['radiation_id']);
					$sample->setCollectionDate($records['collection_date']);
					$sample->setRemarks($records['remarks']);
					$sample->setIsExtremophile($records['is_extremophile']);
					$sample->setNotebookCode($records['notebook_code']);
					
					// Manage the relationship with Location
					$locationId = $records['location_id'];
					if ( isset($locations[$locationId]) ) {
						$sample->setLocationId($locations[$locationId]);
					}
					else if ( $locationId ) {
						$sample->setLocationId($locationId);
					}
					else {
						throw new Exception("The sample {$records['id']} does not have a valid location_id");
					}
					
					$sample->save();
					
					// Manage many-to-many relationships with Collector once the sample has been saved
					if ( isset($records['collector_id']) ) {
						$collectors = $records['collector_id'];
						if ( !is_array($collectors) ) {
							$collectors = array($collectors);
						}
						
						$sampleId = $sample->getId();
						foreach ( $collectors as $collector ) {
							$sampleCollectors = new SampleCollectors();
							$sampleCollectors->sample_id = $sampleId;
							$sampleCollectors->collector_id = $collector;
							$sampleCollectors->save();
						}
					}
					
				}
			}
			
			$dbConnection->commit();
		}
		catch (Exception $e) {
			$dbConnection->rollback();
			return $this->requestExitStatus(self::ServerError, "The sampling information could not be saved to the database (".$e->getMessage().")");
		}
		
		return $this->requestExitStatus();
	}
	
	public function executeSyncLocationInformation(sfWebRequest $request) {
		if ( !$this->validateRequestMethod($request, sfRequest::POST) ) {
			return $this->requestExitStatus(self::InvalidRequestMethod);
		}
		
		if ( !$this->validateToken($request->getParameter('token')) ) {
			return $this->requestExitStatus(self::InvalidToken);
		}
		
		$json = $this->validateJson($request->getParameter('jsonData'));
		if ( !is_array($json) ) {
			return $this->requestExitStatus(self::InvalidJSON);
		}
		
		// Merging remote and local Location objects must be wrapped under a database transaction
		$dbConnection = Doctrine_Manager::connection();
		try {
			$dbConnection->beginTransaction();
			
			if ( isset($json['location']) ) {
				foreach ( $json['location'] as $records ) {
					$location = new Location;
					$location->setName($records['name']);
					$location->setLatitude($records['latitude']);
					$location->setLongitude($records['longitude']);
					$location->setCountryId($records['country_id']);
					$location->setRegionId($records['region_id']);
					$location->setIslandId($records['island_id']);
					$location->setRemarks($records['remarks']);
					$location->save();
				}
			}
			
			$dbConnection->commit();
		}
		catch (Exception $e) {
			$dbConnection->rollback();
			return $this->requestExitStatus(self::ServerError, "The location merging could not be saved to the database (".$e->getMessage().")");
		}
		
		
		return $this->requestExitStatus();
	}
	
	public function executeNewPurchaseOrder(sfWebRequest $request) {
		if ( !$this->validateRequestMethod($request, sfRequest::POST) ) {
			return $this->requestExitStatus(self::InvalidRequestMethod);
		}
		
		if ( !$this->validateToken($request->getParameter('token')) ) {
			return $this->requestExitStatus(self::InvalidToken);
		}
		
		$json = $this->validateJson($request->getParameter('jsonData'));
		if ( !is_array($json) ) {
			return $this->requestExitStatus(self::InvalidJSON);
		}
		
		$productTypes = array(
			'strain' => array('table' => 'StrainTable', 'regex' => sfConfig::get('app_strain_bea_code_regex')),
			'culture_medium' => array('table' => 'CultureMediumTable', 'regex' => sfConfig::get('app_culture_medium_bea_code_regex')),
			'genomic_dna' => array('table' => 'StrainTable', 'regex' => sfConfig::get('app_strain_bea_code_regex')),
		);
		
		if ( !isset($json['code']) ) {
			return $this->requestExitStatus(self::InvalidJSON);
		}
		
		if ( !isset($json['items']) ) {
			return $this->requestExitStatus(self::InvalidJSON);
		}
		
		try {
			// Create a purchase order
			$purchaseOrder = new PurchaseOrder();
			$purchaseOrder->setStatus(sfConfig::get('app_purchase_order_pending'));
			$purchaseOrder->setCode($json['code']);
			unset($json['code']);
			
			// Add items to the purchase order
			$purchaseItems = $purchaseOrder->getItems();
			foreach ( $json['items'] as $details ) {
				// Check if the product type is valid
				$productType = $details['product_type'];
				if ( !in_array($productType, array_keys($productTypes)) ) {
					return $this->requestExitStatus(self::InvalidJSON);
				}

				// Create the purchase item
				$purchaseItem = new PurchaseItem();
				$purchaseItem->setStatus(sfConfig::get('app_purchase_item_pending'));
				$purchaseItem->setProduct($productType);
				$purchaseItem->setCode($details['id']);
				$purchaseItem->setAmount($details['amount']);

				// Check if the product exists
				$id = preg_replace($productTypes[$productType]['regex'], '$1', $details['id']);
				$tableInstance = call_user_func(array($productTypes[$productType]['table'], 'getInstance'));
				if ( $model = $tableInstance->findOneById($id) ) {
					$purchaseItem->setProductId($model->getId());
				}

				$purchaseItems->add($purchaseItem);
			}

			// Notify users about this purchase order
			$notifications = array();
			foreach ( sfGuardUserTable::getInstance()->findByNotifyNewOrder(true) as $user ) {
				$notification = new Notification();
				$notification->setMessage(
					"A new purchase order request with code {$purchaseOrder->getCode()} was received. See the details in the <a href=\"".$this->generateUrl('purchase_order')."\">purchase orders</a> section."
				);
				$notification->setStatus(sfConfig::get('app_inbox_notification_new'));
				$notification->setUserId($user->getId());
				$notifications[] = $notification;
			}
		}
		catch (Exception $e) {
			return $this->requestExitStatus(self::ServerError, "The purchase order could not be saved to the database. {$e->getMessage()}");
		}
		
		// The creation of a purchase order and notifications to users must be wrapped under a database transaction
		$dbConnection = Doctrine_Manager::connection();
		try {
			$dbConnection->beginTransaction();
			
			$purchaseOrder->save();
			foreach ($notifications as $notification) {
				$notification->save();
			}
			
			$dbConnection->commit();
		}
		catch (Exception $e) {
			$dbConnection->rollback();
			return $this->requestExitStatus(self::ServerError, 'The purchase order could not be saved to the database');
		}
		
		return $this->requestExitStatus();
	}
	
}
