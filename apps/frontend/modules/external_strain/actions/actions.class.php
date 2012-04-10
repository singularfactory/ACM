<?php

/**
* external_strain actions.
*
* @package    bna_green_house
* @subpackage external_strain
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class external_strainActions extends MyActions {
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'ExternalStrain', array('init' => false, 'sort_column' => 'id'));

		// Deal with search criteria
		if ( $text = $request->getParameter('criteria') ) {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.TaxonomicClass tc")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species s")
				->where("{$this->mainAlias()}.id LIKE ?", "%$text%")
				->orWhere('tc.name LIKE ?', "%$text%")
				->orWhere('g.name LIKE ?', "%$text%")
				->orWhere('s.name LIKE ?', "%$text%");

			// Keep track of search terms for pagination
			$this->getUser()->setAttribute('search.criteria', $text);
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.TaxonomicClass tc")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species s");

			$this->getUser()->setAttribute('search.criteria', null);
		}
		$this->pager->setQuery($query);
		$this->pager->init();

		// Keep track of the last page used in list
		$this->getUser()->setAttribute('external_strain.index_page', $request->getParameter('page'));

		// Add a form to filter results
		$this->form = new ExternalStrainForm();
	}

	public function executeShow(sfWebRequest $request) {
		$this->externalStrain = ExternalStrainTable::getInstance()->find(array($request->getParameter('id')));
		$this->forward404Unless($this->externalStrain);
	}

	public function executeNew(sfWebRequest $request) {
		if ( $lastStrain = $this->getUser()->getAttribute('external_strain.last_object_created') ) {
			$externalStrain = new ExternalStrain();
			$externalStrain->setTaxonomicClassId($lastStrain->getTaxonomicClassId());
			$externalStrain->setGenusId($lastStrain->getGenusId());
			$externalStrain->setSpeciesId($lastStrain->getSpeciesId());
			$externalStrain->setAuthorityId($lastStrain->getAuthorityId());
			$externalStrain->setMaintenanceStatusId($lastStrain->getMaintenanceStatusId());
			$externalStrain->setCryopreservationMethodId($lastStrain->getCryopreservationMethodId());
			$externalStrain->setEnvironmentId($lastStrain->getEnvironmentId());
			$externalStrain->setHabitatId($lastStrain->getHabitatId());
			$externalStrain->setDepositorId($lastStrain->getDepositorId());
			$externalStrain->setIdentifierId($lastStrain->getIdentifierId());
			$externalStrain->setCollectionDate($lastStrain->getCollectionDate());
			$externalStrain->setIsolationDate($lastStrain->getIsolationDate());
			$externalStrain->setTransferInterval($lastStrain->getTransferInterval());
			$externalStrain->setObservation($lastStrain->getObservation());
			$externalStrain->setCitations($lastStrain->getCitations());
			$externalStrain->setRemarks($lastStrain->getRemarks());

			$this->form = new ExternalStrainForm($externalStrain);
			$this->getUser()->setAttribute('external_strain.last_object_created', null);
		}
		else {
			$this->form = new ExternalStrainForm();
		}

		$this->hasIdentifiers = (IdentifierTable::getInstance()->count() > 0)?true:false;
		$this->hasLocations = (LocationTable::getInstance()->count() > 0)?true:false;
		$this->hasCultureMedia = (CultureMediumTable::getInstance()->count() > 0)?true:false;
  }

  public function executeCreate(sfWebRequest $request) {
  	$this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new ExternalStrainForm();
		$this->hasIdentifiers = (IdentifierTable::getInstance()->count() > 0)?true:false;
		$this->hasLocations = (LocationTable::getInstance()->count() > 0)?true:false;
		$this->hasCultureMedia = (CultureMediumTable::getInstance()->count() > 0)?true:false;

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($externalStrain = ExternalStrainTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object strain does not exist (%s).', $request->getParameter('id')));
		$this->form = new ExternalStrainForm($externalStrain);
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($externalStrain = ExternalStrainTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object strain does not exist (%s).', $request->getParameter('id')));
    $this->form = new ExternalStrainForm($externalStrain);

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

			$externalStrain = null;
			try {
				$externalStrain = $form->save();

				if ( $request->hasParameter('_save_and_add') ) {
					$message = 'Strain created successfully. Now you can add another one';
					$url = '@external_strain_new';

					// Reuse last object values
					$this->getUser()->setAttribute('external_strain.last_object_created', $sample);
				}
				elseif ( !$isNew ) {
					$message = 'Changes saved';
					$url = '@external_strain_show?id='.$externalStrain->getId();
				}
				else {
					$message = 'Deposit created successfully';
					$url = '@external_strain_show?id='.$externalStrain->getId();
				}
			}
			catch (Exception $e) {
				$message = $e->getMessage();
			}

			if ( $externalStrain != null ) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $externalStrain->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ( $url !== null ) {
					$this->redirect($url);
				}
			}
		}

		$this->getUser()->setFlash('notice', 'The information on this strain has some errors you need to fix', false);
	}
}
