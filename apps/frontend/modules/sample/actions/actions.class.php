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

		if ( $form->isValid() ) {
			$flashMessage = null;
			$url = null;
			$isNew = $form->getObject()->isNew();
			
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
		
		$this->getUser()->setFlash('notice', 'The information on this sample has some errors you need to fix');
	}
}
