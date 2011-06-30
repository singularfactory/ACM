<?php

/**
 * strain actions.
 *
 * @package    bna_green_house
 * @subpackage strain
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class strainActions extends MyActions {
	
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'Strain', array('init' => false, 'sort_column' => 'id'));
		
		// Deal with search criteria
		if ( $text = $request->getParameter('criteria') ) {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Sample s")
				->leftJoin("{$this->mainAlias()}.TaxonomicClass c")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species sp")
				->where("{$this->mainAlias()}.id LIKE ?", "%$text%")
				->orWhere('s.id LIKE ?', "%$text%")
				->orWhere('c.name LIKE ?', "%$text%")
				->orWhere('g.name LIKE ?', "%$text%")
				->orWhere('sp.name LIKE ?', "%$text%");
				
			// Parse search term to catch boolean-type columns
			if ( preg_match('/\d[Bb]/', $text) ) {
				$query = $query->orWhere("{$this->mainAlias()}.is_axenic = 0");
			}
		
			// Parse search term to catch strain codes
			if ( preg_match('/([Bb][Ee][Aa])?(\d{1,4})[Bb]?/', $text, $matches) ) {
				$query = $query->orWhere("{$this->mainAlias()}.id = ?", (int)$matches[2]);
			}
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Sample s");
		}
		$this->pager->setQuery($query);
		$this->pager->init();
		
		// Keep track of the last page used in list
		$this->getUser()->setAttribute('strain.index_page', $request->getParameter('page'));
		
		// Add a form to filter results
		$this->form = new StrainForm();
  }
	
	/**
	 * Find the samples that matches a search term when creating or editing a strain
	 *
	 * @param sfWebRequest $request 
	 * @return JSON object with sample id and number
	 * @author Eliezer Talon
	 * @version 2011-06-28
	 */
	public function executeFindSamples(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$results = Doctrine_Core::getTable('Sample')->findByTerm($request->getParameter('term'));
			$samples = array();
			foreach ($results as $sample) {
				$samples[] = array(
					'id' => $sample->getId(),
					'label' => $sample->getNumber(),	// This attribute must be named label due to the jQuery Autocomplete plugin
				);
			}
			$this->getResponse()->setContent(json_encode($samples));
		}
		return sfView::NONE;
	}
	
  public function executeShow(sfWebRequest $request) {
    $this->strain = Doctrine_Core::getTable('Strain')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->strain);
  }

  public function executeNew(sfWebRequest $request) {
    $this->form = new StrainForm();

		if ( $lastStrain = $this->getUser()->getAttribute('strain.last_object_created') ) {
			$strain = new Strain();
			$strain->setSampleId($lastStrain->getSample());
			$strain->setIsEpytipe($lastStrain->getIsEpytipe());
			$strain->setIsAxenic($lastStrain->getIsAxenic());
			$strain->setIsPublic($lastStrain->getIsPublic());
			$strain->setTaxonomicClassId($lastStrain->getTaxonomicClassId());
			$strain->setGenusId($lastStrain->getGenusId());
			$strain->setSpeciesId($lastStrain->getSpeciesId());
			$strain->setAuthorityId($lastStrain->getAuthorityId());
			$strain->setIsolatorId($lastStrain->getIsolatorId());
			$strain->setDepositorId($lastStrain->getDepositorId());
			$strain->setIdentifierId($lastStrain->getIdentifierId());
			$strain->setMaintenanceStatusId($lastStrain->getMaintenanceStatusId());
			$strain->setCryopreservationMethodId($lastStrain->getCryopreservationMethodId());
			$strain->setTransferInterval($lastStrain->getTransferInterval());
			$strain->setObservation($lastStrain->getObservation());
			$strain->setCitations($lastStrain->getCitations());
			$strain->setIsolationDate($lastStrain->getIsolationDate());
			$strain->setDepositionDate($lastStrain->getDepositionDate());
			$strain->setIdentifierDate($lastStrain->getIdentificationId());
			$strain->setRemarks($lastStrain->getRemarks());
			
			$this->form = new StrainForm($strain);
			$this->getUser()->setAttribute('strain.last_object_created', null);
		}
		else {
			$this->form = new StrainForm();
		}
		
		$this->hasSamples = (Doctrine::getTable('Sample')->count() > 0)?true:false;
		$this->hasTaxonomicClasses = (Doctrine::getTable('TaxonomicClass')->count() > 0)?true:false;
		$this->hasGenus = (Doctrine::getTable('Genus')->count() > 0)?true:false;
		$this->hasSpecies = (Doctrine::getTable('Species')->count() > 0)?true:false;
		$this->hasAuthorities = (Doctrine::getTable('Authority')->count() > 0)?true:false;
		$this->hasIsolators = (Doctrine::getTable('Isolator')->count() > 0)?true:false;
		$this->hasCryopreservationMethods = (Doctrine::getTable('CryopreservationMethod')->count() > 0)?true:false;
		$this->hasGrowthMediums = (Doctrine::getTable('GrowthMedium')->count() > 0)?true:false;
  }

  public function executeCreate(sfWebRequest $request) {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new StrainForm();
		$this->hasSamples = (Doctrine::getTable('Sample')->count() > 0)?true:false;
		$this->hasTaxonomicClasses = (Doctrine::getTable('TaxonomicClass')->count() > 0)?true:false;
		$this->hasGenus = (Doctrine::getTable('Genus')->count() > 0)?true:false;
		$this->hasSpecies = (Doctrine::getTable('Species')->count() > 0)?true:false;
		$this->hasAuthorities = (Doctrine::getTable('Authority')->count() > 0)?true:false;
		$this->hasIsolators = (Doctrine::getTable('Isolator')->count() > 0)?true:false;
		$this->hasCryopreservationMethods = (Doctrine::getTable('CryopreservationMethod')->count() > 0)?true:false;
		$this->hasGrowthMediums = (Doctrine::getTable('GrowthMedium')->count() > 0)?true:false;

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request) {
    $this->forward404Unless($strain = Doctrine_Core::getTable('Strain')->find(array($request->getParameter('id'))), sprintf('Object strain does not exist (%s).', $request->getParameter('id')));
    $this->form = new StrainForm($strain);
  }

  public function executeUpdate(sfWebRequest $request) {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($strain = Doctrine_Core::getTable('Strain')->find(array($request->getParameter('id'))), sprintf('Object strain does not exist (%s).', $request->getParameter('id')));
    $this->form = new StrainForm($strain);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request) {
    $request->checkCSRFProtection();

    $this->forward404Unless($strain = Doctrine_Core::getTable('Strain')->find(array($request->getParameter('id'))), sprintf('Object strain does not exist (%s).', $request->getParameter('id')));
    $strain->delete();

   	$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log'));
		$this->getUser()->setFlash('notice', 'Strain deleted successfully');
		$this->redirect('@strain?page='.$this->getUser()->getAttribute('strain.index_page'));
  }

  protected function processForm(sfWebRequest $request, sfForm $form) {
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		
		// Count files uploaded in form
		$uploadedFiles = $request->getFiles();
		$nbValidFiles = 0;
		if ( $uploadedFiles['strain']['new_Pictures'] ) {
			foreach ( $uploadedFiles['strain']['new_Pictures'] as $file ) {
				if ( !empty($file['filename']['name']) ) {
					$nbValidFiles += 1;
				}
			}
		}
		$nbFiles = $form->getObject()->getNbPictures() + $nbValidFiles;
		
		// Validate form
		if ( $form->isValid() && $nbFiles <= sfConfig::get('app_max_strain_pictures') ) {
			$flashMessage = null;
			$url = null;
			$isNew = $form->getObject()->isNew();
			
			// Detect pictures that must be deleted
			$removablePictures = $this->getRemovablePictures($form);
			
			// Save object
			$strain = null;
			try {
				$strain = $form->save();
				
				if ( $request->hasParameter('_save_and_add') ) {
					$message = 'Strain created successfully. Now you can add another one';
					$url = '@strain_new';
					
					// Reuse last object values
					$this->getUser()->setAttribute('strain.last_object_created', $strain);
				}
				elseif ( !$isNew ) {
					$message = 'Changes saved';
					$url = '@strain_show?id='.$strain->getId();
				}
				else {
					$message = 'Strain created successfully';
					$url = '@strain_show?id='.$strain->getId();
				}
				
				// Remove Location pictures
				$this->removePicturesFromFilesystem($removablePictures, sfConfig::get('app_strain_pictures_dir'));
			}
			catch (Exception $e) {
				$message = $e->getMessage();
				echo $message;
			}
			
			if ( $strain != null ) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $strain->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ( $url !== null ) {
					$this->redirect($url);
				}
			}
		}
		
		$this->getUser()->setFlash('notice', 'The information on this strain has some errors you need to fix', false);	
  }
}