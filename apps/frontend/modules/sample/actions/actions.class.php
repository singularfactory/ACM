<?php

/**
* sample actions.
*
* @package    bna_green_house
* @subpackage sample
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class sampleActions extends MyActions
{
	public function executeIndex(sfWebRequest $request) {
		$this->pager = $this->buildPagination($request, 'Sample', 'id');
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
		$this->form = new SampleForm();
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
		$this->redirect('sample/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form) {
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

		if ($form->isValid()) {
			$sample = $form->save();
			$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $sample->getId())));
			
			if ($request->hasParameter('_save_and_add')) {
				
				$this->getUser()->setFlash('notice', $notice.' You can add another one below.');
				$this->redirect('@sample_new');
			}
			else {
				$this->getUser()->setFlash('notice', 'Changes saved');
				$this->redirect('@sample');
			}
		}
	}
}
