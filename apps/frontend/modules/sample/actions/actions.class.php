<?php

/**
* sample actions.
*
* @package    bna_green_house
* @subpackage sample
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class sampleActions extends MyActions {
	
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'Sample', array('init' => false, 'sort_column' => 'id'));
		
		// Deal with search criteria
		if ( $text = $request->getParameter('criteria') ) {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Location l")
				->leftJoin("{$this->mainAlias()}.Environment e")
				->leftJoin("{$this->mainAlias()}.Habitat h")
				->leftJoin("{$this->mainAlias()}.Radiation r")
				->leftJoin("{$this->mainAlias()}.Collector c")
				->where("{$this->mainAlias()}.id LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.remarks LIKE ?", "%$text%")
				->orWhere('l.name LIKE ?', "%$text%")
				->orWhere('e.name LIKE ?', "%$text%")
				->orWhere('h.name LIKE ?', "%$text%")
				->orWhere('r.name LIKE ?', "%$text%")
				->orWhere('c.name LIKE ?', "%$text%")
				->orWhere('c.surname LIKE ?', "%$text%");
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Location l")
				->leftJoin("{$this->mainAlias()}.Collector c");
		}
		$this->pager->setQuery($query);
		$this->pager->init();
		
		// Keep track of the last page used in list
		$this->getUser()->setAttribute('sample.index_page', $request->getParameter('page'));
		
		// Add a form to filter results
		$this->form = new SampleForm();
	}

	/**
	 * Find the locations that matches a search term when creating or editing a sample
	 *
	 * @param sfWebRequest $request 
	 * @return JSON object with location id, name and GPS coordinates
	 * @author Eliezer Talon
	 * @version 2011-04-20
	 */
	public function executeFindLocations(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$results = Doctrine_Core::getTable('Location')->findByTerm($request->getParameter('term'));
			$locations = array();
			foreach ($results as $location) {
				$locations[] = array(
					'id' => $location->getId(),
					'label' => $location->getName(),	// This attribute must be named label due to the jQuery Autocomplete plugin
					'latitude' => $location->getLatitude(),
					'longitude' => $location->getLongitude(),
				);
			}
			$this->getResponse()->setContent(json_encode($locations));
		}
		return sfView::NONE;
	}
	
	public function executeShow(sfWebRequest $request) {
		$this->sample = Doctrine_Core::getTable('Sample')->find(array($request->getParameter('id')));
		
		// Configure a Google Map to show the location
		$this->googleMap = new MyGoogleMap();
		$coordinates = $this->sample->getGPSCoordinates();
		$location = $this->sample->getLocation();
		$information = array(
			'title' => $location->getName(),
			'description' => "{$location->getName()}, {$location->getRegion()->getName()}, {$location->getIsland()->getName()}",
			'notes' => $this->sample->getRemarks());
		if ( $coordinates['latitude'] && $coordinates['longitude'] ) {
			$marker = $this->googleMap->getMarkerFromCoordinates($coordinates['latitude'], $coordinates['longitude'], $information);
		}
		else {
			$marker = $this->googleMap->getMarkerFromAddress("{$information['description']}, {$location->getCountry()->getName()}", $information);
		}
		$this->googleMap->addMarker($marker);
		$this->googleMap->addMarker($this->googleMap->getHomeMarker());
		$this->googleMap->centerAndZoomOnMarkers(1);
		
		$this->forward404Unless($this->sample);
	}

	public function executeNew(sfWebRequest $request) {
		if ( $lastSample = $this->getUser()->getAttribute('sample.last_object_created') ) {
			$sample = new Sample();
			$sample->setLocationId($lastSample->getLocationId());
			$sample->setLatitude($lastSample->getLatitude());
			$sample->setLongitude($lastSample->getLongitude());
			$sample->setEnvironmentId($lastSample->getEnvironmentId());
			$sample->setIsExtremophile($lastSample->getIsExtremophile());
			$sample->setHabitatId($lastSample->getHabitatId());
			$sample->setPh($lastSample->getPh());
			$sample->setConductivity($lastSample->getConductivity());
			$sample->setTemperature($lastSample->getTemperature());
			$sample->setSalinity($lastSample->getSalinity());
			$sample->setAltitude($lastSample->getAltitude());
			$sample->setRadiationId($lastSample->getRadiationId());
			$sample->setCollectorId($lastSample->getCollectorId());
			$sample->setCollectionDate($lastSample->getCollectionDate());
			$sample->setRemarks($lastSample->getRemarks());
			
			$this->form = new SampleForm($sample);
			$this->getUser()->setAttribute('sample.last_object_created', null);
		}
		else {
			$this->form = new SampleForm();
		}
		
		$this->hasLocations = (Doctrine::getTable('Location')->count() > 0)?true:false;
	}

	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new SampleForm();
		$this->hasLocations = (Doctrine::getTable('Location')->count() > 0)?true:false;

		$this->processForm($request, $this->form);
		
		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($sample = Doctrine_Core::getTable('Sample')->find(array($request->getParameter('id'))), sprintf('Object sample does not exist (%s).', $request->getParameter('id')));
		$this->form = new SampleForm($sample);
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($sample = Doctrine_Core::getTable('Sample')->find(array($request->getParameter('id'))), sprintf('Object sample does not exist (%s).', $request->getParameter('id')));
		$this->form = new SampleForm($sample);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request) {
		$request->checkCSRFProtection();

		$this->forward404Unless($sample = Doctrine_Core::getTable('Sample')->find(array($request->getParameter('id'))), sprintf('Object sample does not exist (%s).', $request->getParameter('id')));
		$sample->delete();

		$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log'));
		$this->getUser()->setFlash('notice', 'Sample deleted successfully');
		$this->redirect('@sample?page='.$this->getUser()->getAttribute('sample.index_page'));
	}

	protected function processForm(sfWebRequest $request, sfForm $form) {
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		$uploadedFiles = $request->getFiles();
		
		// Count field pictures uploaded in form
		$nbValidFieldPictures = 0;
		if ( $uploadedFiles['sample']['new_FieldPictures'] ) {
			foreach ( $uploadedFiles['sample']['new_FieldPictures'] as $file ) {
				if ( !empty($file['filename']['name']) ) {
					$nbValidFieldPictures += 1;
				}
			}
		}
		$nbFieldPictures = $form->getObject()->getNbFieldPictures() + $nbValidFieldPictures;
		
		// Count detailed pictures uploaded in form
		$nbValidDetailedPictures = 0;
		if ( $uploadedFiles['sample']['new_DetailedPictures'] ) {
			foreach ( $uploadedFiles['sample']['new_DetailedPictures'] as $file ) {
				if ( !empty($file['filename']['name']) ) {
					$nbValidDetailedPictures += 1;
				}
			}
		}
		$nbDetailedPictures = $form->getObject()->getNbDetailedPictures() + $nbValidDetailedPictures;
		
		// Count microscopic pictures uploaded in form
		$nbValidMicroscopicPictures = 0;
		if ( $uploadedFiles['sample']['new_MicroscopicPictures'] ) {
			foreach ( $uploadedFiles['sample']['new_MicroscopicPictures'] as $file ) {
				if ( !empty($file['filename']['name']) ) {
					$nbValidMicroscopicPictures += 1;
				}
			}
		}
		$nbMicroscopicPictures = $form->getObject()->getNbMicroscopicPictures() + $nbValidMicroscopicPictures;
		
		// Detect invalid number of pictures
		$pictureCountIsValid = ($nbFieldPictures <= sfConfig::get('app_max_sample_field_pictures')) &&
													($nbDetailedPictures <= sfConfig::get('app_max_sample_detailed_pictures')) &&
													($nbMicroscopicPictures <= sfConfig::get('app_max_sample_microscopic_pictures'));
													
		// Validate form
		if ( $form->isValid() && $pictureCountIsValid ) {
			$flashMessage = null;
			$url = null;
			$isNew = $form->getObject()->isNew();
			
			// Detect pictures that must be deleted
			$removablePictures = $this->getRemovablePictures($form, 'FieldPictures');
			$removablePictures = array_merge($removablePictures, $this->getRemovablePictures($form, 'DetailedPictures'));
			$removablePictures = array_merge($removablePictures, $this->getRemovablePictures($form, 'MicroscopicPictures'));
			
			// Save object
			try {
				$sample = $form->save();
				if ( $request->hasParameter('_save_and_add') ) {
					$message = 'Sample created successfully. Now you can add another one';
					$url = '@sample_new';
					
					// Reuse last object values
					$this->getUser()->setAttribute('sample.last_object_created', $sample);
				}
				elseif ( !$isNew ) {
					$message = 'Changes saved';
					$url = '@sample_show?id='.$sample->getId();
				}
				else {
					$message = 'Sample created successfully';
					$url = '@sample_show?id='.$sample->getId();
				}
				
				// Remove Location pictures
				$this->removePicturesFromFilesystem($removablePictures, sfConfig::get('app_sample_pictures_dir'));		
			}
			catch (Exception $e) {
				$message = $e->getMessage();
			}
			
			$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $sample->getId())));
			$this->getUser()->setFlash('notice', $message);
			if ( $url !== null ) {
				$this->redirect($url);
			}
		}
		
		$this->getUser()->setFlash('notice', 'The information on this sample has some errors you need to fix', false);
	}
}
