<?php

/**
* maintenance_deposit actions.
*
* @package    bna_green_house
* @subpackage maintenance_deposit
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class maintenance_depositActions extends MyActions {
	
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'MaintenanceDeposit', array('init' => false, 'sort_column' => 'depositor_code'));
		
		// Deal with search criteria
		if ( $text = $request->getParameter('criteria') ) {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.TaxonomicClass tc")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species s")
				->leftJoin("{$this->mainAlias()}.Depositor d")
				->where("{$this->mainAlias()}.id LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.depositor_code LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.deposition_date LIKE ?", "%$text%")
				->orWhere('tc.name LIKE ?', "%$text%")
				->orWhere('g.name LIKE ?', "%$text%")
				->orWhere('s.name LIKE ?', "%$text%")
				->orWhere('d.name LIKE ?', "%$text%")
				->orWhere('d.surname LIKE ?', "%$text%");
				
			// Keep track of search terms for pagination
			$this->getUser()->setAttribute('search.criteria', $text);
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.TaxonomicClass tc")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species s")
				->leftJoin("{$this->mainAlias()}.Depositor d");
			
			$this->getUser()->setAttribute('search.criteria', null);
		}
		$this->pager->setQuery($query);
		$this->pager->init();
		
		// Keep track of the last page used in list
		$this->getUser()->setAttribute('maintenance_deposit.index_page', $request->getParameter('page'));
		
		// Add a form to filter results
		$this->form = new MaintenanceDepositForm();
	}
	
	public function executeShow(sfWebRequest $request) {
		$this->maintenanceDeposit = MaintenanceDepositTable::getInstance()->find(array($request->getParameter('id')));
		$this->forward404Unless($this->maintenanceDeposit);
	}
		
	public function executeNew(sfWebRequest $request) {
		if ( $lastDeposit = $this->getUser()->getAttribute('maintenance_deposit.last_object_created') ) {
			$maintenanceDeposit = new MaintenanceDeposit();
			$maintenanceDeposit->setTaxonomicClassId($lastDeposit->getTaxonomicClassId());
			$maintenanceDeposit->setGenusId($lastDeposit->getGenusId());
			$maintenanceDeposit->setSpeciesId($lastDeposit->getSpeciesId());
			$maintenanceDeposit->setAuthorityId($lastDeposit->getAuthorityId());
			$maintenanceDeposit->setMaintenanceStatusId($lastDeposit->getMaintenanceStatusId());
			$maintenanceDeposit->setCryopreservationMethodId($lastDeposit->getCryopreservationMethodId());
			$maintenanceDeposit->setEnvironmentId($lastDeposit->getEnvironmentId());
			$maintenanceDeposit->setHabitatId($lastDeposit->getHabitatId());
			$maintenanceDeposit->setDepositorId($lastDeposit->getDepositorId());
			$maintenanceDeposit->setIdentifierId($lastDeposit->getIdentifierId());
			$maintenanceDeposit->setDepositionDate($lastDeposit->getDepositionDate());
			$maintenanceDeposit->setCollectionDate($lastDeposit->getCollectionDate());
			$maintenanceDeposit->setIsolationDate($lastDeposit->getIsolationDate());
			$maintenanceDeposit->setTransferInterval($lastDeposit->getTransferInterval());
			$maintenanceDeposit->setObservation($lastDeposit->getObservation());
			$maintenanceDeposit->setCitations($lastDeposit->getCitations());
			$maintenanceDeposit->setRemarks($lastDeposit->getRemarks());

			$this->form = new MaintenanceDepositForm($maintenanceDeposit);
			$this->getUser()->setAttribute('maintenance_deposit.last_object_created', null);
		}
		else {
			$this->form = new MaintenanceDepositForm();
		}
		
		$this->hasIdentifiers = (IdentifierTable::getInstance()->count() > 0)?true:false;
		$this->hasDepositors = (DepositorTable::getInstance()->count() > 0)?true:false;
		$this->hasLocations = (LocationTable::getInstance()->count() > 0)?true:false;
		$this->hasCultureMedia = (CultureMediumTable::getInstance()->count() > 0)?true:false;
  }

  public function executeCreate(sfWebRequest $request) {
  	$this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new MaintenanceDepositForm();
		$this->hasIdentifiers = (IdentifierTable::getInstance()->count() > 0)?true:false;
		$this->hasDepositors = (DepositorTable::getInstance()->count() > 0)?true:false;
		$this->hasLocations = (LocationTable::getInstance()->count() > 0)?true:false;
		$this->hasCultureMedia = (CultureMediumTable::getInstance()->count() > 0)?true:false;
		
    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }
		
	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($maintenanceDeposit = MaintenanceDepositTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object maintenance deposit does not exist (%s).', $request->getParameter('id')));
		$this->form = new MaintenanceDepositForm($maintenanceDeposit);
	}
	
	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($maintenanceDeposit = MaintenanceDepositTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object maintenance deposit does not exist (%s).', $request->getParameter('id')));
    $this->form = new MaintenanceDepositForm($maintenanceDeposit);

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
			
			$maintenanceDeposit = null;
			try {
				$maintenanceDeposit = $form->save();
				
				if ( $request->hasParameter('_save_and_add') ) {
					$message = 'Deposited created successfully. Now you can add another one';
					$url = '@maintenance_deposit_new';
					
					// Reuse last object values
					$this->getUser()->setAttribute('maintenance_deposit.last_object_created', $sample);
				}
				elseif ( !$isNew ) {
					$message = 'Changes saved';
					$url = '@maintenance_deposit_show?id='.$maintenanceDeposit->getId();
				}
				else {
					$message = 'Deposit created successfully';
					$url = '@maintenance_deposit_show?id='.$maintenanceDeposit->getId();
				}
			}
			catch (Exception $e) {
				$message = $e->getMessage();
			}
			
			if ( $maintenanceDeposit != null ) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $maintenanceDeposit->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ( $url !== null ) {
					$this->redirect($url);
				}
			}
		}
		
		$this->getUser()->setFlash('notice', 'The information on this deposit has some errors you need to fix', false);
	}
	
}
