<?php

/**
* api actions.
*
* @package    bna_green_house
* @subpackage api
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class apiActions extends GreenhouseAPI {
	
	public function executeSamplingInformation(sfWebRequest $request) {
		if ( !$this->validateRequestMethod($request, sfRequest::GET) ) {
			return $this->requestExitStatus(self::InvalidRequestMethod, 'This resource only admits GET requests');
		}
		
		if ( !$this->validateToken($request->getParameter('token')) ) {
			return $this->requestExitStatus(self::InvalidToken);
		}
		
		if ( !($timestamp = $this->validateTimestamp($request->getParameter('timestamp'))) ) {
			return $this->requestExitStatus(self::InvalidTimestamp, $request->getParameter('timestamp'));
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
			'LocationPicture' => 'LocationPictureTable',
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
				if ( isset($record['name']) ) {
					$tmp['name'] = $record['name'];
				}
				
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
					case 'LocationPicture':
						$tmp['filename'] = $record['filename'];
						$tmp['location_id'] = $record['location_id'];
						$tmp['image_data'] = $this->getBase64EncodedPicture($record['filename'], sfConfig::get('sf_upload_dir').sfConfig::get('app_location_pictures_dir'));
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
			return $this->requestExitStatus(self::InvalidRequestMethod, 'This resource only admits POST requests');
		}
		
		if ( !$this->validateToken($request->getParameter('token')) ) {
			return $this->requestExitStatus(self::InvalidToken);
		}
		
		$json = $this->validateJson($request->getParameter('jsonData'));
		if ( !is_array($json) ) {
			return $this->requestExitStatus(self::InvalidJSON, 'The data received in \'jsonData\' could not be decoded');
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
					
					if ( isset($records['name']) ) {
						$location->setName($records['name']);
					}
					if ( isset($records['latitude']) ) {
						$location->setLatitude($records['latitude']);
					}
					if ( isset($records['longitude']) ) {
						$location->setLongitude($records['longitude']);
					}
					if ( isset($records['country_id']) ) {
						$location->setCountryId($records['country_id']);
					}
					if ( isset($records['region_id']) ) {
						$location->setRegionId($records['region_id']);
					}
					if ( isset($records['island_id']) ) {
						$location->setIslandId($records['island_id']);
					}
					if ( isset($records['remarks']) ) {
						$location->setRemarks($records['remarks']);
					}
					
					$location->save();
					
					// Store the new ID of this location to compare with Sample.location_id
					$locations[$records['id']] = $location->getId();
				}
			}
			
			// Create samples
			$samples = array();
			if ( isset($json['sample']) ) {
				foreach ( $json['sample'] as $records ) {
					$sample = new Sample;
					
					if ( isset($records['latitude']) ) {
						$sample->setLatitude($records['latitude']);
					}
					if ( isset($records['longitude']) ) {
						$sample->setLongitude($records['longitude']);
					}
					if ( isset($records['environment_id']) ) {
						$sample->setEnvironmentId($records['environment_id']);
					}
					if ( isset($records['habitat_id']) ) {
						$sample->setHabitatId($records['habitat_id']);
					}
					if ( isset($records['ph']) ) {
						$sample->setPh($records['ph']);
					}
					if ( isset($records['conductivity']) ) {
						$sample->setConductivity($records['conductivity']);
					}
					if ( isset($records['temperature']) ) {
						$sample->setTemperature($records['temperature']);
					}
					if ( isset($records['salinity']) ) {
						$sample->setSalinity($records['salinity']);
					}
					if ( isset($records['altitude']) ) {
						$sample->setAltitude($records['altitude']);
					}
					if ( isset($records['radiation_id']) ) {
						$sample->setRadiationId($records['radiation_id']);
					}
					if ( isset($records['remarks']) ) {
						$sample->setRemarks($records['remarks']);
					}
					if ( isset($records['is_extremophile']) ) {
						$sample->setIsExtremophile($records['is_extremophile']);
					}
					if ( isset($records['notebook_code']) ) {
						$sample->setNotebookCode($records['notebook_code']);
					}
					if ( isset($records['collection_date']) ) {
						$sample->setCollectionDate(($records['collection_date'])?date('Y-m-d', $records['collection_date']):date('Y-m-d'));
					}
					
					// Manage the relationship with Location
					if ( isset($records['location_id']) ) {
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
					}
					
					$sample->save();
					
					// Store the new ID of this sample to compare with Picture.sample_id
					$samples[$records['id']] = $sample->getId();
					
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
			
			// Create pictures
			$pictureModels = array(
				'LocationPicture' => array('parent' => 'Location', 'array' => $locations),
				'FieldPicture' => array('parent' => 'Sample', 'array' => $samples),
				'DetailedPicture' => array('parent' => 'Sample', 'array' => $samples),
			);
			foreach ( $pictureModels as $model => $parentInformation ) {
				$key = sfInflector::underscore($model);
				
				if ( isset($json[$key]) ) {
					$parentModel = sfInflector::underscore($parentInformation['parent']);
					$foreignKey = sfInflector::foreign_key($parentModel, true);
					foreach ( $json[$key] as $records ) {
						if ( !isset($records['image_data']) || !isset($records[$foreignKey]) ) {
							continue;
						}
						
						$picture = new $model;
						$filename = $this->saveBase64EncodedPicture($records['image_data'], sfConfig::get('sf_upload_dir').sfConfig::get('app_'.$parentModel.'_pictures_dir'));
						$picture->setFilename($filename);
						
						$parentId = $records[$foreignKey];
						$foreignKeyArray = $parentInformation['array'];
						if ( isset($foreignKeyArray[$parentId]) ) {
							call_user_func(array($picture, 'set'.sfInflector::camelize($foreignKey)), $foreignKeyArray[$parentId]);
						}
						else if ( $parentId ) {
							call_user_func(array($picture, 'set'.sfInflector::camelize($foreignKey)), $parentId);
						}
						else {
							$this->removePicturesFromFilesystem(array($filename), sfConfig::get('app_'.$parentModel.'_pictures_dir'));
							throw new Exception("The picture {$records['id']} does not have a valid $foreignKey");
						}
						
						$picture->save();
					}
				}
			}
			
			$dbConnection->commit();
		}
		catch (Exception $e) {
			$dbConnection->rollback();
			return $this->requestExitStatus(self::ServerError, "The sampling information could not be saved to the database. {$e->getMessage()}");
		}
		
		return $this->requestExitStatus();
	}
	
	public function executeSyncLocationInformation(sfWebRequest $request) {
		if ( !$this->validateRequestMethod($request, sfRequest::POST) ) {
			return $this->requestExitStatus(self::InvalidRequestMethod, 'This resource only admits POST requests');
		}
		
		if ( !$this->validateToken($request->getParameter('token')) ) {
			return $this->requestExitStatus(self::InvalidToken);
		}
		
		$json = $this->validateJson($request->getParameter('jsonData'));
		if ( !is_array($json) ) {
			return $this->requestExitStatus(self::InvalidJSON, 'The data received in \'jsonData\' could not be decoded');
		}
		
		// Merging remote and local Location objects must be wrapped under a database transaction
		$dbConnection = Doctrine_Manager::connection();
		try {
			$dbConnection->beginTransaction();
			
			$skippedLocations = array();
			if ( isset($json['location']) ) {
				foreach ( $json['location'] as $records ) {
					if ( !($location = LocationTable::getInstance()->find($records['id'])) ) {
						continue;
					}
					
					// Decide if this location should be updated using timestamps
					if ( !isset($records['updated_at']) ) {
						throw new Exception("Missing updated_at field");
					}
					$updatedAt = date('Y-m-d H:i:s', $records['updated_at']);
					if ( $location->getUpdatedAt() > $updatedAt ) {
						$skippedLocations[] = $location->getId();
						continue;
					}
					
					if ( isset($records['name']) ) {
						$location->setName($records['name']);
					}
					
					if ( isset($records['latitude']) ) {
						$location->setLatitude($records['latitude']);
					}
					
					if ( isset($records['longitude']) ) {
						$location->setLongitude($records['longitude']);
					}
					
					if ( isset($records['country_id']) ) {
						$location->setCountryId($records['country_id']);
					}
					
					if ( isset($records['region_id']) ) {
						$location->setRegionId($records['region_id']);
					}
					
					if ( isset($records['island_id']) ) {
						$location->setIslandId($records['island_id']);
					}
					
					if ( isset($records['remarks']) ) {
						$location->setRemarks($records['remarks']);
					}
					
					$location->setUpdatedAt(date('Y-m-d H:i:s'));
					$location->save();
				}
			}
			
			if ( isset($json['location_picture']) ) {
				foreach ( $json['location_picture'] as $records ) {
					if ( in_array($records['location_id'], $skippedLocations) ) {
						continue;
					}
					
					if ( !($location = LocationTable::getInstance()->find($records['location_id'])) ) {
						continue;
					}

					// Delete actual pictures
					$filenames = array();
					$ids = array();
					foreach ( $location->getPictures() as $picture ) {
						$filenames[] = $picture->getFilename();
						$ids[] = $picture->getId();
					}
					LocationPictureTable::getInstance()->createQuery('q')->delete('LocationPicture lp')->whereIn('lp.id', $ids)->execute();
					$this->removePicturesFromFilesystem($filenames, sfConfig::get('app_location_pictures_dir'));
					
					// Create the new pictures
					$picture = new LocationPicture;
					$filename = $this->saveBase64EncodedPicture($records['image_data'], sfConfig::get('sf_upload_dir').sfConfig::get('app_location_pictures_dir'));
					$picture->setFilename($filename);
					
					if ( isset($records['location_id']) ) {
						$picture->setLocationId($records['location_id']);
					}
					else {
						$this->removePicturesFromFilesystem(array($filename), sfConfig::get('app_location_pictures_dir'));
						throw new Exception("The picture {$records['id']} does not have a valid location_id");
					}
					
					$picture->save();
				}
			}
			
			$dbConnection->commit();
		}
		catch (Exception $e) {
			$dbConnection->rollback();
			return $this->requestExitStatus(self::ServerError, "The location merging could not be saved to the database. {$e->getMessage()}");
		}
		
		return $this->requestExitStatus();
	}
	
	public function executeNewPurchaseOrder(sfWebRequest $request) {
		if ( !$this->validateRequestMethod($request, sfRequest::POST) ) {
			return $this->requestExitStatus(self::InvalidRequestMethod, 'This resource only admits POST requests');
		}
		
		if ( !$this->validateToken($request->getParameter('token')) ) {
			return $this->requestExitStatus(self::InvalidToken);
		}
		
		$json = $this->validateJson($request->getParameter('jsonData'));
		if ( !is_array($json) ) {
			return $this->requestExitStatus(self::InvalidJSON, 'The data received in \'jsonData\' could not be decoded');
		}
		
		$productTypes = array(
			'strain' => array('table' => 'StrainTable', 'regex' => sfConfig::get('app_strain_bea_code_regex')),
			'culture_medium' => array('table' => 'CultureMediumTable', 'regex' => sfConfig::get('app_culture_medium_bea_code_regex')),
			'genomic_dna' => array('table' => 'StrainTable', 'regex' => sfConfig::get('app_strain_bea_code_regex')),
		);
		
		if ( !isset($json['code']) ) {
			return $this->requestExitStatus(self::InvalidJSON, 'Missing purchase order code');
		}
		
		if ( !isset($json['items']) ) {
			return $this->requestExitStatus(self::InvalidJSON, 'Missing products information');
		}
		
		if ( !isset($json['customer']) ) {
			return $this->requestExitStatus(self::InvalidJSON, 'Missing customer information');
		}
		
		try {
			// Avoid duplication of purchase orders
			if ( PurchaseOrderTable::getInstance()->findByCode($json['code'])->count() ) {
				return $this->requestExitStatus(self::ServerError, "The purchase order {$json['code']} has already been created");
			}
			
			// Create a purchase order
			$purchaseOrder = new PurchaseOrder();
			$purchaseOrder->setStatus(sfConfig::get('app_purchase_order_pending'));
			$purchaseOrder->setCode($json['code']);
			$purchaseOrder->setCustomer($json['customer']);
			unset($json['code']);
			unset($json['customer']);
			
			// Add items to the purchase order
			$purchaseItems = $purchaseOrder->getItems();
			foreach ( $json['items'] as $details ) {
				if ( !isset($details['id']) ) {
					return $this->requestExitStatus(self::InvalidJSON, 'Missing product code');
				}
				
				$productType = $details['product_type'];
				if ( !in_array($productType, array_keys($productTypes)) ) {
					return $this->requestExitStatus(self::InvalidJSON, "Missing product type of item {$details['id']}");
				}
				
				if ( !isset($details['amount']) ) {
					return $this->requestExitStatus(self::InvalidJSON, "Missing product amount of item {$details['id']}");
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
			return $this->requestExitStatus(self::ServerError, "The purchase order could not be created. {$e->getMessage()}");
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
			return $this->requestExitStatus(self::ServerError, "The purchase order could not be saved to the database. {$e->getMessage()}");
		}
		
		return $this->requestExitStatus();
	}
	
	public function executeStoreCatalog(sfWebRequest $request) {
		if ( !$this->validateRequestMethod($request, sfRequest::GET) ) {
			return $this->requestExitStatus(self::InvalidRequestMethod, 'This resource only admits GET requests');
		}
		
		if ( !$this->validateToken($request->getParameter('token')) ) {
			return $this->requestExitStatus(self::InvalidToken);
		}
		
		// Get referenced models
		$habitats = array();
		foreach ( HabitatTable::getInstance()->createQuery('h')->innerJoin('h.Samples')->execute() as $habitat ) {
			$habitats[$habitat->getId()] = $habitat->getName();
		}
		unset($habitat);
		
		$countries = array();
		foreach ( CountryTable::getInstance()->createQuery('c')->innerJoin('c.Locations')->execute() as $country ) {
			$countries[$country->getId()] = $country->getName();
		}
		unset($country);
		
		$regions = array();
		foreach ( RegionTable::getInstance()->createQuery('r')->innerJoin('r.Locations')->execute() as $region ) {
			$regions[$region->getId()] = $region->getName();
		}
		unset($region);
		
		$islands = array();
		foreach ( IslandTable::getInstance()->createQuery('i')->innerJoin('i.Locations')->execute() as $island ) {
			$islands[$island->getId()] = $island->getName();
		}
		unset($island);
		
		$locations = array();
		foreach ( LocationTable::getInstance()->createQuery('l')->innerJoin('l.Samples')->execute() as $location ) {
			$id = $location->getId();
			$country = $countries[$location->getCountryId()];
			$region = sprintf(', %s', $regions[$location->getRegionId()]);
			$island = (isset($islands[$location->getIslandId()])) ? sprintf(', %s', $islands[$location->getIslandId()]) : '';
			
			$locations[$id] = sprintf('%s %s %s, %s', $country, $region, $island, $location->getName());
		}
		unset($location);
		
		$catalog = array();
		
		// Get culture media
		$catalog['culture_medium'] = array();
		foreach ( CultureMediumTable::getInstance()->findByIsPublic(1) as $medium ) {
			$catalog['culture_medium'][$medium->getId()] = array('name' => $medium->getName(), 'link' => $medium->getLink());
		}
		unset($medium);
		
		// Get isolators
		$catalog['isolators'] = array();
		foreach ( IsolatorTable::getInstance()->findAll() as $isolator ) {
			$catalog['isolators'][$isolator->getId()] = "$isolator";
		}
		unset($isolator);
		
		// Get maintenance status
		$catalog['maintenance_status'] = array();
		foreach ( MaintenanceStatusTable::getInstance()->findAll() as $status ) {
			$catalog['maintenance_status'][$status->getId()] = $status->getName();
		}
		unset($status);
				
		// Get strains
		foreach ( StrainTable::getInstance()->findByIsPublic(1) as $strain ) {
			$record = array(
				'id' => $strain->getId(),
				'culture_media' => array(),
				'isolators' => array(),
				'maintenance_status' => array(),
				'relatives' => array(),
				'location' => $locations[$strain->getSample()->getLocationId()],
				'habitat' => $habitats[$strain->getSample()->getHabitatId()],
				'is_epitype' => $strain->getIsEpitype(),
				'is_axenic' => $strain->getIsAxenic(),
				'taxonomic_class' => $strain->getTaxonomicClass()->getName(),
				'genus' => $strain->getGenus()->getName(),
				'species' => $strain->getSpecies()->getName(),
				'authority' => $strain->getAuthority()->getName(),
				'isolation_date' => $strain->getIsolationDate(),
				'identifier' => sprintf('%s %s', $strain->getIdentifier()->getName(), $strain->getIdentifier()->getSurname()),
				'cryopreservation_method' => $strain->getCryopreservationMethod()->getName(),
				'transfer_interval' => $strain->getTransferInterval(),
				'observation' => $strain->getObservation(),
				'citations' => $strain->getCitations(),
				'remarks' => $strain->getRemarks(),
				'web_notes' => $strain->getWebNotes(),
				'container' => $strain->getContainer()->getName(),
				'depositor' => sprintf('%s %s', $strain->getDepositor()->getName(), $strain->getDepositor()->getSurname()),
				'has_dna' => ($strain->hasDna() > 0),
				'aliquots' => $strain->getDnaAmount(),
			);
			
			// Get relatives of this strain
			foreach ( $strain->getRelatives() as $relative ) {
				$record['relatives'][] = $medium->getName();
			}
			
			// Get culture media of this strain
			foreach ( $strain->getCultureMedia() as $medium ) {
				$record['culture_media'][] = $medium->getId();
			}
			
			// Get isolators of this strain
			foreach ( $strain->getIsolators() as $isolator ) {
				$record['isolators'][] = $isolator->getId();
			}
			
			// Get maintenance statuses of this strain
			foreach ( $strain->getMaintenanceStatus() as $status ) {
				$record['maintenance_status'][] = $status->getId();
			}
			
			$catalog['strain'][$strain->getId()] = $record;
		}
		
		// Return the information as a JSON object
		return $this->requestExitStatus(self::RequestSuccess, json_encode($catalog));
	}
	
}
