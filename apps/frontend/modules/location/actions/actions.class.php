<?php

/**
* location actions.
*
* @package    bna_green_house
* @subpackage location
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class locationActions extends MyActions {	
	
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'Location', array('init' => false));
		
		// Deal with search criteria
		if ( $text = $request->getParameter('criteria') ) {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Country c")
				->leftJoin("{$this->mainAlias()}.Region r")
				->leftJoin("{$this->mainAlias()}.Island i")
				->leftJoin("{$this->mainAlias()}.Samples s")
				->leftJoin("{$this->mainAlias()}.Category cat")
				->where("{$this->mainAlias()}.name LIKE ?", "%$text%")
				->orWhere("c.name LIKE ?", "%$text%")
				->orWhere("r.name LIKE ?", "%$text%")
				->orWhere("i.name LIKE ?", "%$text%")
				->orWhere("cat.name LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.remarks LIKE ?", "%$text%");
				
			// Keep track of search terms for pagination
			$this->getUser()->setAttribute('search.criteria', $text);
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Country c")
				->leftJoin("{$this->mainAlias()}.Region r")
				->leftJoin("{$this->mainAlias()}.Island i")
				->leftJoin("{$this->mainAlias()}.Samples s");
			
			$this->getUser()->setAttribute('search.criteria', null);
		}
		
		$this->pager->setQuery($query);
		$this->pager->init();
		
		// Keep track of the last page used in list
		$this->getUser()->setAttribute('location.index_page', $request->getParameter('page'));
		
		// Add a form to filter results
		$this->form = new LocationForm();
	}
	
	public function executeShow(sfWebRequest $request) {
		$this->location = Doctrine_Core::getTable('Location')->find(array($request->getParameter('id')));
		
		// Configure a Google Map to show the location
		$this->googleMap = new MyGoogleMap();
		$coordinates = $this->location->getGPSCoordinates();
		$information = array(
			'title' => $this->location->getName(),
			'description' => "{$this->location->getRegion()->getName()}, {$this->location->getIsland()->getName()}",
			'notes' => $this->location->getRemarks());
		if ( $coordinates['latitude'] && $coordinates['longitude'] ) {
			$marker = $this->googleMap->getMarkerFromCoordinates($coordinates['latitude'], $coordinates['longitude'], $information);
		}
		else {
			$marker = $this->googleMap->getMarkerFromAddress("{$information['title']}, {$information['description']}, {$this->location->getCountry()->getName()}", $information);
		}
		
		$this->googleMap->addMarker($marker);
		$this->googleMap->addMarker($this->googleMap->getHomeMarker());
		$this->googleMap->centerAndZoomOnMarkers();
		$this->googleMap->setZoom($this->googleMap->getZoom() - 2);
				
		$this->forward404Unless($this->location);
	}

	public function executeNew(sfWebRequest $request) {
		if ( $lastLocation = $this->getUser()->getAttribute('location.last_object_created') ) {
			$location = new Location();
			$location->setCountryId($lastLocation->getCountryId());
			$location->setRegionId($lastLocation->getRegionId());
			$location->setLatitude($lastLocation->getLatitude());
			$location->setLongitude($lastLocation->getLongitude());
			$location->setRemarks($lastLocation->getRemarks());
			
			$this->form = new LocationForm($location);
			$this->form->setIslandChoicesByRegion($lastLocation->getRegionId());
			$this->form->setDefault('island_id', $lastLocation->getIslandId());
			
			$this->getUser()->setAttribute('location.last_object_created', null);
		}
		else {
			$this->form = new LocationForm();
			$countryId = CountryTable::getInstance()->getDefaultCountryId();
			$regionId = RegionTable::getInstance()->getDefaultRegionId($countryId);
			$islandId = IslandTable::getInstance()->getDefaultIslandId($regionId);
			$this->form->setDefault('country_id', $countryId);
			$this->form->setDefault('region_id', $regionId);
			$this->form->setDefault('island_id', $islandId);
		}		
	}

	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new LocationForm();

		$this->processForm($request, $this->form);
		
		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($location = Doctrine_Core::getTable('Location')->find(array($request->getParameter('id'))), sprintf('Object location does not exist (%s).', $request->getParameter('id')));
		$this->form = new LocationForm($location);
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($location = Doctrine_Core::getTable('Location')->find(array($request->getParameter('id'))), sprintf('Object location does not exist (%s).', $request->getParameter('id')));
		$this->form = new LocationForm($location);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	protected function processForm(sfWebRequest $request, sfForm $form) {
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		
		// Count files uploaded in form
		$uploadedFiles = $request->getFiles();
		$nbValidFiles = 0;
		if ( $uploadedFiles['location']['new_Pictures'] ) {
			foreach ( $uploadedFiles['location']['new_Pictures'] as $file ) {
				if ( !empty($file['filename']['name']) ) {
					$nbValidFiles += 1;
				}
			}
		}
		$nbFiles = $form->getObject()->getNbPictures() + $nbValidFiles;
		
		// Validate form
		if ( $form->isValid() && $nbFiles <= sfConfig::get('app_max_location_pictures') ) {
			$flashMessage = null;
			$url = null;
			$isNew = $form->getObject()->isNew();
			
			// Detect pictures that must be deleted
			$removablePictures = $this->getRemovablePictures($form);
			
			// Save object
			$location = null;
			try {
				$location = $form->save();
				if ( $request->hasParameter('_save_and_add') ) {
					$message = 'Location created successfully. Now you can add another one';
					$url = '@location_new';
					$this->getUser()->setAttribute('location.last_object_created', $location);
				}
				elseif ( !$isNew ) {
					$message = 'Changes saved';
					$url = '@location_show?id='.$location->getId();
				}
				else {
					$message = 'Location created successfully';
					$url = '@location_show?id='.$location->getId();
				}
				
				// Remove Location pictures
				$this->removePicturesFromFilesystem($removablePictures, sfConfig::get('app_location_pictures_dir'));
				
				// Update GPS coordinates of every sample (temporary measure)
				foreach ($location->getSamples() as $sample) {
					$sample->setLatitude($location->getLatitude());
					$sample->setLongitude($location->getLongitude());
					$sample->trySave();
				}
			}
			catch (Exception $e) {
				$message = $e->getMessage();
			}
			
			if ( $location != null ) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $location->getId())));
			}
			$this->getUser()->setFlash('notice', $message);
			if ( $url !== null ) {
				$this->redirect($url);
			}
		}
		
		$this->getUser()->setFlash('notice', 'The information on this location has some errors you need to fix', false);
	}
	
}
