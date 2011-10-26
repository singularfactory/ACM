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
				->leftJoin("{$this->mainAlias()}.Isolators i")
				->where("{$this->mainAlias()}.id LIKE ?", "%$text%")
				->orWhere('s.id LIKE ?', "%$text%")
				->orWhere('c.name LIKE ?', "%$text%")
				->orWhere('g.name LIKE ?', "%$text%")
				->orWhere('sp.name LIKE ?', "%$text%")
				->orWhere('i.name LIKE ?', "%$text%")
				->orWhere('i.surname LIKE ?', "%$text%");
				
			// Parse search term to catch boolean-type columns
			if ( preg_match('/\d[Bb]/', $text) ) {
				$query = $query->orWhere("{$this->mainAlias()}.is_axenic = 0");
			}
		
			// Parse search term to catch strain codes
			if ( preg_match('/([Bb][Ee][Aa])?(\d{1,4})[Bb]?/', $text, $matches) ) {
				$query = $query->orWhere("{$this->mainAlias()}.id = ?", (int)$matches[2]);
			}
			
			// Keep track of search terms for pagination
			$this->getUser()->setAttribute('search.criteria', $text);
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Sample s")
				->leftJoin("{$this->mainAlias()}.Isolators i");
			
			$this->getUser()->setAttribute('search.criteria', null);
		}
		$this->pager->setQuery($query);
		$this->pager->init();
		
		// Keep track of the last page used in list
		$this->getUser()->setAttribute('strain.index_page', $request->getParameter('page'));
		
		// Add a form to filter results
		$this->form = new StrainForm();
  }
	
  public function executeShow(sfWebRequest $request) {
		$this->strain = StrainTable::getInstance()->find(array($request->getParameter('id')));
		$this->forward404Unless($this->strain);
  }
	
	public function executeNewRelatedModelEmbeddedForm(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$this->setLayout(false);
			return $this->renderPartial('embeddedForm', array('model' => $request->getParameter('related_model')));
		}
		else {
			return sfView::NONE;
		}
	}
	
  public function executeNew(sfWebRequest $request) {
		if ( $lastStrain = $this->getUser()->getAttribute('strain.last_object_created') ) {
			$strain = new Strain();
			$strain->setSampleId($lastStrain->getSample());
			$strain->setTaxonomicClassId($lastStrain->getTaxonomicClassId());
			$strain->setGenusId($lastStrain->getGenusId());
			$strain->setSpeciesId($lastStrain->getSpeciesId());
			$strain->setAuthorityId($lastStrain->getAuthorityId());
			$strain->setIsEpitype($lastStrain->getIsEpitype());
			$strain->setIsPublic($lastStrain->getIsPublic());
			$strain->setContainerId($lastStrain->getContainerId());
			$strain->setCryopreservationMethodId($lastStrain->getCryopreservationMethodId());
			$strain->setIsolationDate($lastStrain->getIsolationDate());
			$strain->setIdentifierId($lastStrain->getIdentifierId());
			$strain->setIsAxenic($lastStrain->getIsAxenic());
			$strain->setTransferInterval($lastStrain->getTransferInterval());
			$strain->setObservation($lastStrain->getObservation());
			$strain->setCitations($lastStrain->getCitations());
			$strain->setRemarks($lastStrain->getRemarks());
			$strain->setWebNotes($lastStrain->getWebNotes());
			
			$this->form = new StrainForm($strain);
			$this->sampleCode = $lastStrain->getSample()->getCode();
			$this->getUser()->setAttribute('strain.last_object_created', null);
		}
		else {
			$this->form = new StrainForm();
			$this->sampleCode = null;
		}
		
		$this->hasSamples = (Doctrine::getTable('Sample')->count() > 0)?true:false;
		$this->hasTaxonomicClasses = (Doctrine::getTable('TaxonomicClass')->count() > 0)?true:false;
		$this->hasGenus = (Doctrine::getTable('Genus')->count() > 0)?true:false;
		$this->hasSpecies = (Doctrine::getTable('Species')->count() > 0)?true:false;
		$this->hasAuthorities = (Doctrine::getTable('Authority')->count() > 0)?true:false;
		$this->hasIsolators = (Doctrine::getTable('Isolator')->count() > 0)?true:false;
		$this->hasCryopreservationMethods = (Doctrine::getTable('CryopreservationMethod')->count() > 0)?true:false;
		$this->hasCultureMedia = (Doctrine::getTable('CultureMedium')->count() > 0)?true:false;
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
		$this->hasCultureMedia = (Doctrine::getTable('CultureMedium')->count() > 0)?true:false;

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($strain = StrainTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object strain does not exist (%s).', $request->getParameter('id')));
		$this->form = new StrainForm($strain);
  }

  public function executeUpdate(sfWebRequest $request) {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($strain = StrainTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object strain does not exist (%s).', $request->getParameter('id')));
    $this->form = new StrainForm($strain);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }
	
  protected function processForm(sfWebRequest $request, sfForm $form) {
		$taintedValues = $request->getParameter($form->getName());
		
		// Look for related models embedded forms
		$relatedModels = array('taxonomic_class', 'genus', 'species', 'authority');
		foreach ( $relatedModels as $modelName ) {
			$modelInput = "new_$modelName";
			$modelClass = sfInflector::camelize($modelName);
			
			if ( array_key_exists($modelInput, $taintedValues) ) {
				$model = new $modelClass();
				$model->setName($taintedValues[$modelInput]['name']);
				unset($taintedValues[$modelInput]);

				if ( $model->trySave() ) {
					$taintedValues["{$modelName}_id"] = $model->getId();
				}
				else {
					$this->getUser()->setFlash('notice', "A related model ($model) could not be saved. Try again", false);
					return;
				}
			}
		}
		
		// Unset axenity tests if values are empty
		if ( isset($taintedValues['new_AxenityTests']) ) {
			$validTests = array();
			foreach ( $taintedValues['new_AxenityTests'] as $test ) { 
				if ( empty($test['date']['day']) || empty($test['date']['month']) || empty($test['date']['year']) ) {
					continue;
				}
				$validTests[] = $test;
			}
			
			$nValidTests = count($validTests);
			if ( $nValidTests == 0 ) {
				//unset($taintedValues['new_AxenityTests']);
				$taintedValues['new_AxenityTests'] = array();
			}
			else if ( $nValidTests > 0 && $nValidTests < count($taintedValues['new_AxenityTests']) ) {
				$taintedValues['new_AxenityTests'] = $validTests;
			}
		}
		
		// Bind input fields with files uploaded
		$form->bind($taintedValues, $request->getFiles($form->getName()));
		
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
			$message = null;
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
