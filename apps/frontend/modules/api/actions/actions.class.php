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
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		$this->validateToken($request->getParameter('token'));

		$info = json_decode($request->getParameter('jsonData'), true);
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
	
	public function executeNewPurchaseOrder(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));	
		$this->validateToken($request->getParameter('token'));
		
		$json = json_decode($request->getParameter('json'), true);
		if ( !is_array($json) ) {
			throw new sfError404Exception("JSON content could not be decoded.");
		}
		
		$productTypes = array(
			'strain' => array('table' => 'StrainTable', 'regex' => sfConfig::get('app_strain_bea_code_regex'), 'amountMethod' => 'getAmount'),
			'culture_medium' => array('table' => 'CultureMediumTable', 'regex' => sfConfig::get('app_culture_medium_bea_code_regex'), 'amountMethod' => 'getAmount'),
			'genomic_dna' => array('table' => 'StrainTable', 'regex' => sfConfig::get('app_strain_bea_code_regex'), 'amountMethod' => 'getDnaAmount'),
		);
		
		// Configure initial conditions of this purchase order
		$purchaseOrder = new PurchaseOrder();
		$purchaseOrder->setStatus(sfConfig::get('app_purchase_order_pending'));
		$purchaseOrder->setCode($json['code']);
		$purchaseItems = $purchaseOrder->getItems();
		
		// Add items to the purchase order
		$errorMessages = array();
		unset($json['code']);
		foreach ( $json as $item => $details ) {
			$productType = $details['product_type'];
			
			// Check if this product is valid
			if ( !in_array($productType, array_keys($productTypes)) ) {
				$errorMessages[] = 'One or more products were not valid (unknow product type)';
				continue;
			}
			
			// Check if this product is available within the catalog
			$id = preg_replace($productTypes[$productType]['regex'], '$1', $details['id']);
			$tableInstance = call_user_func(array($productTypes[$productType]['table'], 'getInstance'));
			$model = $tableInstance->findOneById($id);
			if ( !$model ) {
				$errorMessages = 'One or more products were not available (unknow product code)';
				continue;
			}
			
			// Add a new purchase item
			$purchaseItem = new PurchaseItem();
			$purchaseItem->setStatus(sfConfig::get('app_purchase_item_pending'));
			$purchaseItem->setProduct($productType);
			$amountMethod = $productTypes[$productType]['amountMethod'];
			$purchaseItem->setAmount($model->$amountMethod());
			$purchaseItem->setProductId($model->getId());
			
			$purchaseItems->add($purchaseItem);
		}
		
		// Save the purchase order
		try {
			$purchaseOrder->save();
		}
		catch (Exception $e) {
			$this->getResponse()->setStatusCode(202);
			echo 'The purchase order could not be saved to the database, but was notified anyway';
			$errorMessages[] = "A new purchase order with code {$purchaseOrder->getCode()} was received but could not be processed";
		}
		
		// Notify users
		try {
			// Configure message
			$message = '';
			if ( $errorMessages ) {
				$message = 'A new purchase order request was received, but the request could not be fully processed due to the following errors: ';
				foreach ( $errorMessages as $error ) {
					$message .= "$error. ";
				}
			}
			else {
				$message = "A new purchase order request with code {$purchaseOrder->getCode()} was received. More details in purchase order section.";
			}
			
			// Send notification to users
			foreach ( sfGuardUserTable::getInstance()->findByNotifyNewOrder(true) as $user ) {
				$notification = new Notification();
				$notification->setMessage($message);
				$notification->setStatus(sfConfig::get('app_inbox_notification_new'));
				$notification->setUserId($user->getId());
				$notification->save();
			}
		}
		catch (Exception $e) {
			$this->getResponse()->setStatusCode(202);
			echo "The purchase order could was saved to the database, but notified could not be posted ({$e->getMessage()})";
		}
		
		return sfView::NONE;
	}
	
}
