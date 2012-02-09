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
		$this->pager = $this->buildPagination($request, 'Strain', array('init' => false, 'sort_column' => 'code'));
		
		// Deal with search criteria
		if ( ($text = $request->getParameter('criteria')) && $text != 'deceased' ) {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Sample s")
				->leftJoin("{$this->mainAlias()}.TaxonomicClass c")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species sp")
				->leftJoin("{$this->mainAlias()}.Supervisor su")
				->orWhere('c.name LIKE ?', "%$text%")
				->orWhere('g.name LIKE ?', "%$text%")
				->orWhere('sp.name LIKE ?', "%$text%")
				->orWhere('su.first_name LIKE ?', "%$text%")
				->orWhere('su.last_name LIKE ?', "%$text%");
					
			// Parse search term to catch strain codes
			if ( preg_match('/([Bb][Ee][Aa])?\s*(\d{1,4})\s*[Bb]?/', $text, $matches) ) {
				$query = $query->orWhere("{$this->mainAlias()}.code = ?", (int)$matches[2]);
			}
			else {
				$query = $query->orWhere("{$this->mainAlias()}.code LIKE ?", "%$text%");
			}
			
			// Parse search term to catch sample codes
			if ( preg_match('/0*(\d+)(\w{1,3})_?(\w{1,3})?(\w{1,3}|00)?(\d{2,6})?/', $text, $matches) ) {
				$query = $query->orWhere("s.id = ?", (int)$matches[1]);
			}
			
			// Keep track of search terms for pagination
			$this->getUser()->setAttribute('search.criteria', $text);
		}
		else {
			$this->getUser()->setAttribute('search.criteria', null);
			
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Sample sa")
				->leftJoin("sa.Location loc")
				->leftJoin("loc.Country")
				->leftJoin("loc.Region")
				->leftJoin("loc.Island")
				->leftJoin("{$this->mainAlias()}.Isolators i")
				->leftJoin("{$this->mainAlias()}.TaxonomicClass c")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species sp");
			
			if ( $request->hasParameter('criteria') ) {
				$query->where("{$this->mainAlias()}.deceased = ?", 1);
				$this->getUser()->setAttribute('search.criteria', 'deceased');
			}
			elseif ( !$request->hasParameter('all') ) {
				$query->where("{$this->mainAlias()}.deceased = ?", 0);
			}
		}
		
		$this->pager->setQuery($query);
		$this->pager->init();
		
		// Keep track of the last page used in list
		$this->getUser()->setAttribute('strain.index_page', $request->getParameter('page'));
		
		// Add a form to filter results
		$this->form = new StrainForm(array(), array('search' => true));
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
	
	/**
	 * Find an existing strain that matches a search term
	 *
	 * @param sfWebRequest $request 
	 * @return JSON object with strain id and code
	 * @author Eliezer Talon
	 * @version 2011-07-07
	*/
	public function executeFindClone(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			
			$strains = StrainTable::getInstance()->createQuery('s')
				->where('s.code LIKE ?', '%'.$request->getParameter('term').'%')
				->andWhere('s.clone_number IS NULL')
				->execute();
			
			$data = array();
			foreach ($strains as $strain) {
				$data[] = array(
					'label' => $strain->getCode(),
					'sample_code' => $strain->getSample()->getCode(),
					'sample_id' => $strain->getSampleId(),
					'taxonomic_class_id' => $strain->getTaxonomicClassId(),
					'genus_id' => $strain->getGenusId(),
					'species_id' => $strain->getSpeciesId(),
				);
			}
			
			$this->getResponse()->setContent(json_encode($data));
		}
		return sfView::NONE;
	}
	
	/**
	 * Reorder the list of isolators of a strain
	 *
	 * @param sfWebRequest $request 
	 * @return JSON object with strain id and code
	 * @author Eliezer Talon
	 * @version 2011-11-10
	*/
	public function executeUpdateIsolatorsOrder(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			try {
				$table = StrainIsolatorsTable::getInstance();
				$order = 0;
				$strainId = $request->getParameter('strain_id');
				
				foreach ( $request->getParameter('isolators') as $id ) {
					$table->createQuery('si')
						->update()
						->set('si.sort_order', $order++)
						->where('si.isolator_id = ?', $id)
						->andWhere('si.strain_id = ?', $strainId)
						->execute();
				}
				
				$this->getResponse()->setContent('');
			}
			catch (Exception $e) {
				$this->getResponse()->setContent($e->getMessage());
			}
			
		}
		return sfView::NONE;
	}
	
  public function executeNew(sfWebRequest $request) {
		
		$lastStrain = false;
		if ( $request->hasParameter('id') ) {
			$lastStrain = StrainTable::getInstance()->find(array($request->getParameter('id')));
		}
		elseif ( $this->getUser()->hasAttribute('strain.last_object_created') ) {
			$lastStrain = $this->getUser()->getAttribute('strain.last_object_created');
		}
		
		if ( $lastStrain ) {
			$strain = new Strain();
			$strain->setSampleId($lastStrain->getSampleId());
			$strain->setTaxonomicClassId($lastStrain->getTaxonomicClassId());
			$strain->setGenusId($lastStrain->getGenusId());
			$strain->setSpeciesId($lastStrain->getSpeciesId());
			$strain->setAuthorityId($lastStrain->getAuthorityId());
			$strain->setIsEpitype($lastStrain->getIsEpitype());
			$strain->setIsPublic($lastStrain->getIsPublic());
			$strain->setContainerId($lastStrain->getContainerId());
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
		$this->hasCultureMedia = (Doctrine::getTable('CultureMedium')->count() > 0)?true:false;
		$this->sampleCode = ($request->hasParameter('strain_sample_search')) ? $request->getParameter('strain_sample_search') : null;

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($strain = StrainTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object strain does not exist (%s).', $request->getParameter('id')));
		$this->form = new StrainForm($strain);
		$this->sampleCode = $strain->getSample()->getCode();
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
		
		// Keep track of isolators
		$isolatorsOrder = array();
		if ( isset($taintedValues['isolators_list']) ) {
			if ( $form->getObject()->isNew() ) {
				$order = 0;
				foreach ( $taintedValues['isolators_list'] as $id ) {
					$isolatorsOrder[$id] = $order++;
				}
			}
			else {
				$strainId = $form->getObject()->getId();
				$table = StrainIsolatorsTable::getInstance();
				$nextOrder = $table->createQuery('si')->select('MAX(si.sort_order) as order')->where('si.strain_id = ?', $strainId)->fetchOne()->order + 1;
				foreach ( $taintedValues['isolators_list'] as $id ) {
					if ( $table->createQuery('si')->where('si.isolator_id = ?', $id)->andWhere('si.strain_id = ?', $strainId)->count() <= 0 ) {
						$isolatorsOrder[$id] = $nextOrder++;
					}
				}
			}
		}
				
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
			$dbConnection = Doctrine_Manager::connection();
			try {
				$dbConnection->beginTransaction();
				$strain = $form->save();
				
				// Initialize sort_order of new records in StrainIsolator
				foreach ( $isolatorsOrder as $id => $order ) {
					StrainIsolatorsTable::getInstance()->createQuery('si')
						->update()
						->set('si.sort_order', $order)
						->where('si.isolator_id = ?', $id)
						->andWhere('si.strain_id = ?', $strain->getId())
						->execute();
				}
				
				// Normalize sort_order values
				$isolators = StrainIsolatorsTable::getInstance()->createQuery('si')->where('si.strain_id = ?', $strain->getId())->orderBy('si.sort_order')->execute();
				$order = 0;
				foreach ($isolators as $isolator) {
					$isolator->setSortOrder($order++);
					$isolator->save();
				}
					
				$dbConnection->commit();
				
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
				$dbConnection->rollback();
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
