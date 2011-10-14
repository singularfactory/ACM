<?php

/**
* patent_deposit actions.
*
* @package    bna_green_house
* @subpackage patent_deposit
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class patent_depositActions extends MyActions {
	
	public function executeIndex(sfWebRequest $request) {
		$this->patent_deposits = Doctrine_Core::getTable('PatentDeposit')
			->createQuery('a')
			->execute();
	}
	
	public function executeShow(sfWebRequest $request) {
		$this->patent_deposit = Doctrine_Core::getTable('PatentDeposit')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->patent_deposit);
	}
	
	/**
	 * Find the locations that matches a search term when creating or editing a patent deposit
	 *
	 * @param sfWebRequest $request 
	 * @return JSON object with location id, name and GPS coordinates
	 * @author Eliezer Talon
	 * @version 2011-10-14
	 */
	public function executeFindLocations(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$results = LocationTable::getInstance()->findByTerm($request->getParameter('term'));
			$locations = array();
			foreach ($results as $location) {
				$locations[] = array(
					'id' => $location->getId(),
					'label' => $location->getName(),	// This attribute must be named label due to the jQuery Autocomplete plugin
				);
			}
			$this->getResponse()->setContent(json_encode($locations));
		}
		return sfView::NONE;
	}
	
	public function executeNew(sfWebRequest $request) {
		if ( $lastDeposit = $this->getUser()->getAttribute('patent_deposit.last_object_created') ) {
			$patentDeposit = new PatentDeposit();
			$patentDeposit->setTaxonomicClassId($lastDeposit->getTaxonomicClassId());
			$patentDeposit->setGenusId($lastDeposit->getGenusId());
			$patentDeposit->setSpeciesId($lastDeposit->getSpeciesId());
			$patentDeposit->setAuthorityId($lastDeposit->getAuthorityId());
			$patentDeposit->setMaintenanceStatusId($lastDeposit->getMaintenanceStatusId());
			$patentDeposit->setCryopreservationMethodId($lastDeposit->getCryopreservationMethodId());
			$patentDeposit->setEnvironmentId($lastDeposit->getEnvironmentId());
			$patentDeposit->setHabitatId($lastDeposit->getHabitatId());
			$patentDeposit->setDepositorId($lastDeposit->getDepositorId());
			$patentDeposit->setIdentifierId($lastDeposit->getIdentifierId());
			$patentDeposit->setDepositionDate($lastDeposit->getDepositionDate());
			$patentDeposit->setCollectionDate($lastDeposit->getCollectionDate());
			$patentDeposit->setIsolationDate($lastDeposit->getIsolationDate());
			$patentDeposit->setTransferInterval($lastDeposit->getTransferInterval());
			$patentDeposit->setObservation($lastDeposit->getObservation());
			$patentDeposit->setCitations($lastDeposit->getCitations());
			$patentDeposit->setRemarks($lastDeposit->getRemarks());

			$this->form = new PatentDepositForm($patentDeposit);
			$this->getUser()->setAttribute('patent_deposit.last_object_created', null);
		}
		else {
			$this->form = new PatentDepositForm();
		}
		
		$this->hasIdentifiers = (IdentifierTable::getInstance()->count() > 0)?true:false;
		$this->hasDepositors = (DepositorTable::getInstance()->count() > 0)?true:false;
		$this->hasLocations = (LocationTable::getInstance()->count() > 0)?true:false;
		$this->hasCultureMedia = (CultureMediumTable::getInstance()->count() > 0)?true:false;
  }

  public function executeCreate(sfWebRequest $request) {
  	$this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PatentDepositForm();
		$this->hasIdentifiers = (IdentifierTable::getInstance()->count() > 0)?true:false;
		$this->hasDepositors = (DepositorTable::getInstance()->count() > 0)?true:false;
		$this->hasLocations = (LocationTable::getInstance()->count() > 0)?true:false;
		$this->hasCultureMedia = (CultureMediumTable::getInstance()->count() > 0)?true:false;
		
    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }
		
	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($patent_deposit = Doctrine_Core::getTable('PatentDeposit')->find(array($request->getParameter('id'))), sprintf('Object patent_deposit does not exist (%s).', $request->getParameter('id')));
		$this->form = new PatentDepositForm($patent_deposit);
	}
	
	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($patent_deposit = Doctrine_Core::getTable('PatentDeposit')->find(array($request->getParameter('id'))), sprintf('Object patent_deposit does not exist (%s).', $request->getParameter('id')));
		$this->form = new PatentDepositForm($patent_deposit);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}
	
	protected function processForm(sfWebRequest $request, sfForm $form) {
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
													
		// Validate form
		if ( $form->isValid() ) {
			$flashMessage = null;
			$url = null;
			$isNew = $form->getObject()->isNew();
			
			$patentDeposit = null;
			try {
				$patentDeposit = $form->save();
				
				if ( $request->hasParameter('_save_and_add') ) {
					$message = 'Deposited created successfully. Now you can add another one';
					$url = '@patent_deposit_new';
					
					// Reuse last object values
					$this->getUser()->setAttribute('patent_deposit.last_object_created', $sample);
				}
				elseif ( !$isNew ) {
					$message = 'Changes saved';
					$url = '@patent_deposit_show?id='.$patentDeposit->getId();
				}
				else {
					$message = 'Deposit created successfully';
					$url = '@patent_deposit_show?id='.$patentDeposit->getId();
				}
			}
			catch (Exception $e) {
				$message = $e->getMessage();
			}
			
			if ( $patentDeposit != null ) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $patentDeposit->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ( $url !== null ) {
					$this->redirect($url);
				}
			}
		}
		
		$this->getUser()->setFlash('notice', 'The information on this deposit has some errors you need to fix', false);
	}
	
}
