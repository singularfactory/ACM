<?php
/**
 * acm : Algae Culture Management (https://github.com/singularfactory/ACM)
 * Copyright 2012, Singular Factory <info@singularfactory.com>
 *
 * This file is part of ACM
 *
 * ACM is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ACM is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ACM.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright     Copyright 2012, Singular Factory <info@singularfactory.com>
 * @package       ACM.Frontend
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */

/**
 * strain actions
 *
 * @package ACM.Frontend
 * @subpackage strain
 * @version 1.2
 */
class strainActions extends MyActions {
	/**
	 * Index action
	 */
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'Strain', array('init' => false, 'sort_column' => 'code'));
		$filters = $this->_processFilterConditions($request, 'strain');

		$query = null;
		if (count($filters)) {
			if (!empty($filters['group_by'])) {
				$query = StrainTable::getInstance()->createQuery($this->mainAlias())->select("{$this->mainAlias()}.*");
				$this->groupBy = $filters['group_by'];

				if (in_array($this->groupBy, array('transfer_interval', 'is_epitype', 'is_axenic', 'deceased', 'is_public'))) {
					$relatedAlias = $this->groupBy;
					$relatedForeignKey = $this->groupBy;
					$recursive = false;
				} else {
					$relatedAlias = sfInflector::camelize($this->groupBy);
					$relatedForeignKey = sfInflector::foreign_key($this->groupBy);
					$recursive = true;
				}

				$query = $query
					->addSelect("COUNT(DISTINCT {$this->mainAlias()}.id) as n_strains")
					->addSelect("COUNT(DISTINCT d.id) as n_dna_extractions")
					->leftJoin("{$this->mainAlias()}.DnaExtractions d")
					->groupBy("{$this->mainAlias()}.$relatedForeignKey");

				if ($recursive) {
					$query = $query->innerJoin("{$this->mainAlias()}.$relatedAlias m");
					if (in_array($this->groupBy, array('sample'))) {
						$query = $query->addSelect('m.id as value');
					} else {
						$query = $query->addSelect('m.name as value');
					}
				} else {
					$query = $query->addSelect("{$this->mainAlias()}.$relatedAlias as value");
				}
			} else {
				$query = $this->pager->getQuery();
			}

			$query = $query
				->leftJoin("{$this->mainAlias()}.Sample s")
				->leftJoin("{$this->mainAlias()}.TaxonomicClass c")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species sp")
				->leftJoin("{$this->mainAlias()}.Supervisor su")
				->where('1=1');

			foreach (array('taxonomic_class_id', 'genus_id', 'species_id', 'authority_id', 'supervisor_id') as $filter) {
				if (!empty($filters[$filter])) {
					$query = $query->andWhere("{$this->mainAlias()}.$filter = ?", $filters[$filter]);

					$table = ($filter === 'supervisor_id') ? 'sfGuardUserTable' : sprintf('%sTable', sfInflector::camelize(str_replace('_id', '', $filter)));
					$table = call_user_func(array($table, 'getInstance'));
					$this->filters[$filter] = $table->find($filters[$filter])->getName();
				}
			}

			foreach (array('maintenance_status_id', 'culture_medium_id', 'property_id') as $filter) {
				if (!empty($filters[$filter])) {
					$intermediateModel = '';
					switch ($filter) {
						case 'culture_medium_id':
							$intermediateModel = 'CultureMedia';
							break;
						case 'maintenance_status_id':
							$intermediateModel = 'MaintenanceStatus';
							break;
						case 'property_id':
							$intermediateModel = 'Properties';
							break;
					}
					$query = $query->andWhere("{$this->mainAlias()}.Strain$intermediateModel.{$filter} = ?", $filters[$filter]);

					if ($filter === 'property_id') {
						$table = 'StrainPropertyTable';
					} else {
						$table = sprintf('%sTable', sfInflector::camelize(str_replace('_id', '', $filter)));
					}
					$table = call_user_func(array($table, 'getInstance'));
					$this->filters[$filter] = $table->find($filters[$filter])->getName();
				}
			}

			if (!empty($filters['is_epitype']) && $filters['is_epitype'] > 0) {
				$this->filters['Epitype'] = ($filters['is_epitype'] == 1) ? 'no' : 'yes';
				$query = $query->andWhere("{$this->mainAlias()}.is_epitype = ?", ($filters['is_epitype'] == 1) ? 0 : 1);
			}

			if (!empty($filters['is_axenic']) && $filters['is_axenic'] > 0) {
				$this->filters['Axenic'] = ($filters['is_axenic'] == 1) ? 'no' : 'yes';
				$query = $query->andWhere("{$this->mainAlias()}.is_axenic = ?", ($filters['is_axenic'] == 1) ? 0 : 1);
			}

			if (!empty($filters['is_public']) && $filters['is_public'] > 0) {
				$this->filters['Public'] = ($filters['is_public'] == 1) ? 'no' : 'yes';
				$query = $query->andWhere("{$this->mainAlias()}.is_public = ?", ($filters['is_public'] == 1) ? 0 : 1);
			}

			if (!empty($filters['deceased']) && $filters['deceased'] > 0) {
				$this->filters['Deceased'] = ($filters['deceased'] == 1) ? 'no' : 'yes';
				$query = $query->andWhere("{$this->mainAlias()}.deceased = ?", ($filters['deceased'] == 1) ? 0 : 1);
			}

			if (!empty($filters['transfer_interval'])) {
				$this->filters['Transfer interval'] = $filters['transfer_interval'];
				$query = $query->andWhere("{$this->mainAlias()}.transfer_interval = ?", $filters['transfer_interval']);
			}

			if (!empty($filters['id'])) {
				$this->filters['Code'] = $filters['id'];
				preg_match('/^[Bb]?[Ee]?[Aa]?\s*(\d{1,4})\s*[bB]?.*$/', $filters['id'], $matches);
				$query = $query->andWhere("{$this->mainAlias()}.code = ?", $matches[1]);
			}
		} else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Sample sa")
				->leftJoin("sa.Location loc")
				->leftJoin("{$this->mainAlias()}.TaxonomicClass c")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species sp")
				->leftJoin("{$this->mainAlias()}.Supervisor su");
		}

		if (empty($filters['group_by'])) {
			$this->pager->setQuery($query);
			$this->pager->init();
			$this->results = $this->pager->getResults();
		} else {
			$this->results = $query->execute();
		}

		// Keep track of the last page used in list
		$this->getUser()->setAttribute('strain.index_page', $request->getParameter('page'));

		// Add a form to filter results
		$this->form = new StrainForm(array(), array('search' => true));
	}

	/**
	 * Show action
	 */
	public function executeShow(sfWebRequest $request) {
		$this->strain = StrainTable::getInstance()->find(array($request->getParameter('id')));
		$this->forward404Unless($this->strain);
	}

	/**
	 * NewRelatedModelEmbeddedForm action
	 */
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

	/**
	 * New action
	 */
	public function executeNew(sfWebRequest $request) {
		$lastStrain = false;
		if ($request->hasParameter('id')) {
			$lastStrain = StrainTable::getInstance()->find(array($request->getParameter('id')));
		}
		elseif ($this->getUser()->hasAttribute('strain.last_object_created')) {
			$lastStrain = $this->getUser()->getAttribute('strain.last_object_created');
		}

		if ($lastStrain) {
			$strain = new Strain();
			$strain->setSampleId($lastStrain->getSampleId());
			$strain->setTaxonomicClassId($lastStrain->getTaxonomicClassId());
			$strain->setGenusId($lastStrain->getGenusId());
			$strain->setSpeciesId($lastStrain->getSpeciesId());
			$strain->setAuthorityId($lastStrain->getAuthorityId());
			$strain->setIsEpitype($lastStrain->getIsEpitype());
			$strain->setIsPublic($lastStrain->getIsPublic());
			$strain->setCultureMediumId($lastStrain->getCultureMediumId());
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

	/**
	 * Create action
	 */
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

	/**
	 * Edit action
	 */
	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($strain = StrainTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object strain does not exist (%s).', $request->getParameter('id')));
		$this->form = new StrainForm($strain);
		$this->sampleCode = $strain->getSample()->getCode();
	}

	/**
	 * Update action
	 */
	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($strain = StrainTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object strain does not exist (%s).', $request->getParameter('id')));
		$this->form = new StrainForm($strain);
		$this->sampleCode = $strain->getSample()->getCode();

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	/**
	 * processForm action
	 */
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
		$relatedModels = array('taxonomic_class', 'genus', 'species', 'authority', 'taxonomic_order', 'phylum', 'family', 'kingdom', 'subkingdom');
		foreach ( $relatedModels as $modelName ) {
			$modelInput = "new_$modelName";
			$modelClass = sfInflector::camelize($modelName);

			if (array_key_exists($modelInput, $taintedValues)) {
				$model = new $modelClass();
				$model->setName($taintedValues[$modelInput]['name']);
				unset($taintedValues[$modelInput]);

				if ($model->trySave()) {
					$taintedValues["{$modelName}_id"] = $model->getId();
				} else {
					$this->getUser()->setFlash('notice', "A related model ($model) could not be saved. Try again", false);
					return;
				}
			}
		}

		// Unset axenity tests if values are empty
		if (isset($taintedValues['new_AxenityTests'])) {
			$validTests = array();
			foreach ( $taintedValues['new_AxenityTests'] as $test ) {
				if ( empty($test['date']['day']) || empty($test['date']['month']) || empty($test['date']['year']) ) {
					continue;
				}
				$validTests[] = $test;
			}

			$nValidTests = count($validTests);
			if ( $nValidTests == 0 ) {
				$taintedValues['new_AxenityTests'] = array();
			}
			else if ( $nValidTests > 0 && $nValidTests < count($taintedValues['new_AxenityTests']) ) {
				$taintedValues['new_AxenityTests'] = $validTests;
			}
		}

		// Unset pictures if values are empty
		if (!isset($taintedValues['new_Pictures'])) {
			$taintedValues['new_Pictures'] = array();
		}

		// Bind input fields with files uploaded
		$form->bind($taintedValues, $request->getFiles($form->getName()));

		// Count files uploaded in form
		$uploadedFiles = $request->getFiles();
		$nbValidFiles = 0;
		if (isset($uploadedFiles['strain']['new_Pictures'])) {
			foreach ( $uploadedFiles['strain']['new_Pictures'] as $file ) {
				if ( !empty($file['filename']['name']) ) {
					$nbValidFiles += 1;
				}
			}
		}
		$nbFiles = $form->getObject()->getNbPictures() + $nbValidFiles;

		// Validate form
		$message = null;
		if ($form->isValid() && $nbFiles <= sfConfig::get('app_max_strain_pictures')) {
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

	/**
	 * Create labels for Strain records
	 *
	 * @param sfWebRequest $request Request information
	 * @return void
	 */
	public function executeCreateLabel(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::GET));
		if ($request->isMethod(sfRequest::POST)) {
			$values = $request->getPostParameters();
			$this->labels = StrainTable::getInstance()->availableStrainsForLabelConfiguration($values);
			$this->copies = $values['copies'];

			$this->setLayout(false);
			$pdf = new WKPDF();
			$pdf->set_html($this->getPartial('create_pdf'));
			$pdf->set_orientation('Landscape');
			$pdf->render();
			$pdf->output(WKPDF::$PDF_DOWNLOAD, "strain_labels.pdf");
			throw new sfStopException();
		} else {
			$this->getUser()->setAttribute('strain_label_configuration', array());
			$this->form = new StrainLabelForm();
			$this->form->setWidgets(array(
				'supervisor_id' => new sfWidgetFormDoctrineChoice(array(
					'model' => 'Supervisor',
					'query' => StrainTable::getInstance()->availableSupervisorsQuery(),
					'add_empty' => true,
				)),
			));
		}
	}

	/**
	 * Returns the HTML form section of a label field
	 *
	 * @param sfWebRequest $request
	 * @return string HTML content
	 */
	public function executeGetLabelField(sfWebRequest $request) {
		if ($request->isXmlHttpRequest()) {
			$div = $request->getParameter('field');
			$value = $request->getParameter('value');
			$strains = array();

			if (empty($div) || empty($value)) {
				return sfView::NONE;
			}

			$labelConfiguration = $this->getUser()->getAttribute('strain_label_configuration');
			$form = new StrainLabelForm();
			switch ($div) {
			case 'transfer_intervals':
				$labelConfiguration['supervisor_id'] = $value;
				$field = 'transfer_interval';
				$form->setWidgets(array(
					'transfer_interval' => new sfWidgetFormChoice(array(
						'choices' => StrainTable::getInstance()->availableTransferIntervalChoices($labelConfiguration['supervisor_id']),
					))));
				break;
			case 'genus':
				$labelConfiguration['transfer_interval'] = $value;
				$field = 'genus_id';
				$form->setWidgets(array(
					'genus_id' => new sfWidgetFormDoctrineChoice(array(
						'model' => 'Genus',
						'query' => StrainTable::getInstance()->availableGenusQuery(
							$labelConfiguration['supervisor_id'], $labelConfiguration['transfer_interval']),
						'add_empty' => true,
					)),
				));
				break;
			case 'axenicity':
				$labelConfiguration['genus_id'] = $value;
				$field = 'is_axenic';
				$form->setWidgets(array('is_axenic' => new sfWidgetFormChoice(array('choices' => StrainLabelForm::$booleanChoices))));
				break;
			case 'container':
				$labelConfiguration['is_axenic'] = $value;
				$field = 'container_id';
				$form->setWidgets(array(
					'container_id' => new sfWidgetFormDoctrineChoice(array(
						'model' => 'Container',
						'query' => StrainTable::getInstance()->availableContainersQuery(
							$labelConfiguration['supervisor_id'], $labelConfiguration['transfer_interval'], $labelConfiguration['genus_id'], $labelConfiguration['is_axenic']),
						'add_empty' => true,
					)),
				));
				break;
			case 'culture_medium':
				$labelConfiguration['container_id'] = $value;
				$field = 'culture_medium_id';
				$form->setWidgets(array(
					'culture_medium_id' => new sfWidgetFormDoctrineChoice(array(
						'model' => 'CultureMedium',
						'query' => StrainTable::getInstance()->availableCultureMediaQuery(
							$labelConfiguration['supervisor_id'], $labelConfiguration['transfer_interval'], $labelConfiguration['genus_id'], $labelConfiguration['is_axenic'], $labelConfiguration['container_id']),
						'add_empty' => true,
					)),
				));
				break;
			case 'strain':
				$labelConfiguration['culture_medium_id'] = $value;
				$strains = StrainTable::getInstance()->availableStrainsForLabelConfiguration($labelConfiguration);
				break;
			}
			$this->getUser()->setAttribute('strain_label_configuration', $labelConfiguration);

			$this->setLayout(false);
			if ($div === 'strain') {
				return $this->renderPartial('labelStrains', array('strains' => $strains));
			} else {
				return $this->renderPartial('labelFieldForm', array('div' => $div, 'field' => $field, 'form' => $form));
			}
		}
		return sfView::NONE;
	}
}
