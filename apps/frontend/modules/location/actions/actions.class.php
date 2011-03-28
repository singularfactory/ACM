<?php

/**
* location actions.
*
* @package    bna_green_house
* @subpackage location
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class locationActions extends MyActions
{	
	public function executeIndex(sfWebRequest $request) {
		$this->pager = $this->buildPagination($request, 'Location');
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
		$this->redirect('location/index');
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
		
		if ( $form->isValid() && $nbFiles <= sfConfig::get('app_max_location_pictures') ) {
			$location = $form->save();
			$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $location->getId())));
			
			if ($request->hasParameter('_save_and_add')) {
				
				$this->getUser()->setFlash('notice', $notice.' You can add another one below.');
				$this->redirect('@location_new');
			}
			else {
				$this->getUser()->setFlash('notice', 'Changes saved');
				$this->redirect('@location');
			}
		}
	}
}
