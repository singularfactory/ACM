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
		$this->pager = $this->buildPagination($request, 'Location');
		
		// Keep track of the last page used in list
		$this->getUser()->setAttribute('location_index_page', $request->getParameter('page'));
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
		$this->googleMap->centerAndZoomOnMarkers(1);
				
		$this->forward404Unless($this->location);
	}

	public function executeNew(sfWebRequest $request) {
		$this->form = new LocationForm();
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

	public function executeDelete(sfWebRequest $request) {
		$request->checkCSRFProtection();

		$this->forward404Unless($location = Doctrine_Core::getTable('Location')->find(array($request->getParameter('id'))), sprintf('Object location does not exist (%s).', $request->getParameter('id')));
		$location->delete();

		$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log'));
		$this->getUser()->setFlash('notice', 'Location deleted successfully');
		$this->redirect('@location?page='.$this->getUser()->getAttribute('location_index_page'));
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
			
			// Save object
			try {
				$location = $form->save();
				if ( $request->hasParameter('_save_and_add') ) {
					$message = 'Location created successfully. Now you can add another one';
					$url = '@location_new';
				}
				elseif ( !$isNew ) {
					$message = 'Changes saved';
					$url = '@location_show?id='.$location->getId();
				}
				else {
					$message = 'Location created successfully';
					$url = '@location_show?id='.$location->getId();
				}
			}
			catch (Exception $e) {
				$message = $e->getMessage();
			}
			
			$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $location->getId())));
			$this->getUser()->setFlash('notice', $message);
			if ( $url !== null ) {
				$this->redirect($url);
			}
		}
	}
}
