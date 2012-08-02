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
 * external_strain actions
 *
 * @package ACM.Frontend
 * @subpackage external_strain
 * @version 1.2
 */
class external_strainActions extends MyActions {
	/**
	 * Index action
	 */
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'ExternalStrain', array('init' => false, 'sort_column' => 'id'));
		$filters = $this->_processFilterConditions($request, 'external_strain');

		$query = null;
		// Deal with search criteria
		if (count($filters)) {
			if (!empty($filters['group_by'])) {
				$query = ExternalStrainTable::getInstance()->createQuery($this->mainAlias())->select("{$this->mainAlias()}.*");
				$this->groupBy = $filters['group_by'];

				if (in_array($this->groupBy, array('transfer_interval', 'is_epitype', 'is_axenic'))) {
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
				->leftJoin("{$this->mainAlias()}.Sample sa")
				->leftJoin("sa.Location loc")
				->leftJoin("{$this->mainAlias()}.TaxonomicClass tc")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species s")
				->where('1=1');

			foreach (array('taxonomic_class_id', 'genus_id', 'species_id', 'authority_id') as $filter) {
				if (!empty($filters[$filter])) {
					$query = $query->andWhere("{$this->mainAlias()}.$filter = ?", $filters[$filter]);

					$table = sprintf('%sTable', sfInflector::camelize(str_replace('_id', '', $filter)));
					$table = call_user_func(array($table, 'getInstance'));
					$this->filters[$filter] = $table->find($filters[$filter])->getName();
				}
			}

			foreach (array('maintenance_status_id', 'culture_medium_id') as $filter) {
				if (!empty($filters[$filter])) {
					$intermediateModel = '';
					switch ($filter) {
					case 'culture_medium_id':
						$intermediateModel = 'CultureMedia';
						break;
					case 'maintenance_status_id':
						$intermediateModel = 'MaintenanceStatus';
						break;
					}
					$query = $query->andWhere("{$this->mainAlias()}.ExternalStrain$intermediateModel.{$filter} = ?", $filters[$filter]);

					$table = sprintf('%sTable', sfInflector::camelize(str_replace('_id', '', $filter)));
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

			if (!empty($filters['transfer_interval'])) {
				$this->filters['Transfer interval'] = $filters['transfer_interval'];
				$query = $query->andWhere("{$this->mainAlias()}.transfer_interval = ?", $filters['transfer_interval']);
			}

			if (!empty($filters['id'])) {
				$this->filters['Code'] = $filters['id'];
				preg_match('/^[Bb]?[Ee]?[Aa]?\s*[Rr]?\s*[Cc]?\s*(\d{1,4})\s*[Bb]?.*$/', $filters['id'], $matches);
				$query = $query->andWhere("{$this->mainAlias()}.id = ?", $matches[1]);
			}
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Sample sa")
				->leftJoin("sa.Location loc")
				->leftJoin("{$this->mainAlias()}.TaxonomicClass c")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species s");
		}

		if (empty($filters['group_by'])) {
			$this->pager->setQuery($query);
			$this->pager->init();
			$this->results = $this->pager->getResults();
		} else {
			$this->results = $query->execute();
		}

		// Keep track of the last page used in list
		$this->getUser()->setAttribute('external_strain.index_page', $request->getParameter('page'));

		// Add a form to filter results
		$this->form = new ExternalStrainForm(array(), array('search' => true));
	}

	/**
	 * Shows a ExternalStrain record
	 */
	public function executeShow(sfWebRequest $request) {
		$this->externalStrain = ExternalStrainTable::getInstance()->find(array($request->getParameter('id')));
		$this->forward404Unless($this->externalStrain);
	}

	/**
	 * Shows form for creating a new ExternalStrain record
	 */
	public function executeNew(sfWebRequest $request) {
		if ( $lastStrain = $this->getUser()->getAttribute('external_strain.last_object_created') ) {
			$externalStrain = new ExternalStrain();
			$externalStrain->setKingdomId($lastStrain->getKingdomId());
			$externalStrain->setPhylumId($lastStrain->getPhylumd());
			$externalStrain->setFamilyId($lastStrain->getFamilyId());
			$externalStrain->setTaxonomicClassId($lastStrain->getTaxonomicClassId());
			$externalStrain->setTaxonomicOrderId($lastStrain->getTaxonomicOrderId());
			$externalStrain->setGenusId($lastStrain->getGenusId());
			$externalStrain->setSpeciesId($lastStrain->getSpeciesId());
			$externalStrain->setAuthorityId($lastStrain->getAuthorityId());
			$externalStrain->setIsolationDate($lastStrain->getIsolationDate());
			$externalStrain->setIdentifierId($lastStrain->getIdentifierId());
			$externalStrain->setSupervisorId($lastStrain->getSupervisorId());
			$externalStrain->setTransferInterval($lastStrain->getTransferInterval());
			$externalStrain->setObservation($lastStrain->getObservation());
			$externalStrain->setCitations($lastStrain->getCitations());
			$externalStrain->setRemarks($lastStrain->getRemarks());
			$externalStrain->setDepositorId($lastStrain->getDepositorId());

			$this->form = new ExternalStrainForm($externalStrain);
			$this->getUser()->setAttribute('external_strain.last_object_created', null);
		}
		else {
			$this->form = new ExternalStrainForm();
		}

		$this->hasIdentifiers = (IdentifierTable::getInstance()->count() > 0)?true:false;
		$this->hasSamples = (SampleTable::getInstance()->count() > 0)?true:false;
		$this->hasCultureMedia = (CultureMediumTable::getInstance()->count() > 0)?true:false;
	}

	/**
	 * Saves a new ExternalStrain record
	 */
	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new ExternalStrainForm();
		$this->hasIdentifiers = (IdentifierTable::getInstance()->count() > 0)?true:false;
		$this->hasSamples = (SampleTable::getInstance()->count() > 0)?true:false;
		$this->hasCultureMedia = (CultureMediumTable::getInstance()->count() > 0)?true:false;

		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	/**
	 * Shows form for editing a ExternalStrain record
	 */
	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($externalStrain = ExternalStrainTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object strain does not exist (%s).', $request->getParameter('id')));
		$this->form = new ExternalStrainForm($externalStrain);
	}

	/**
	 * Saves changes in a ExternalStrain record
	 */
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
					$message = 'Strain created successfully';
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
			$this->labels = ExternalStrainTable::getInstance()->availableExternalStrainsForLabelConfiguration($values);
			$this->copies = $values['copies'];
			$this->cultureMedium = CultureMediumTable::getInstance()->findOneById($values['culture_medium_id']);

			$this->setLayout(false);
			$pdf = new WKPDF();
			$pdf->set_html($this->getPartial('create_pdf'));
			$pdf->set_orientation('Landscape');
			$pdf->render();
			$pdf->output(WKPDF::$PDF_DOWNLOAD, "research_collection_labels.pdf");
			throw new sfStopException();
		} else {
			$this->getUser()->setAttribute('external_strain_label_configuration', array());
			$this->form = new ExternalStrainLabelForm();
			$this->form->setWidgets(array(
				'supervisor_id' => new sfWidgetFormDoctrineChoice(array(
					'model' => 'Supervisor',
					'query' => ExternalStrainTable::getInstance()->availableSupervisorsQuery(),
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
			$externalStrains = array();

			if (empty($div) || empty($value)) {
				return sfView::NONE;
			}

			$labelConfiguration = $this->getUser()->getAttribute('external_strain_label_configuration');
			$form = new ExternalStrainLabelForm();
			switch ($div) {
			case 'transfer_intervals':
				$labelConfiguration['supervisor_id'] = $value;
				$field = 'transfer_interval';
				$form->setWidgets(array(
					'transfer_interval' => new sfWidgetFormChoice(array(
						'choices' => ExternalStrainTable::getInstance()->availableTransferIntervalChoices($labelConfiguration['supervisor_id']),
					))));
				break;
			case 'genus':
				$labelConfiguration['transfer_interval'] = $value;
				$field = 'genus_id';
				$form->setWidgets(array(
					'genus_id' => new sfWidgetFormDoctrineChoice(array(
						'model' => 'Genus',
						'query' => ExternalStrainTable::getInstance()->availableGenusQuery(
							$labelConfiguration['supervisor_id'], $labelConfiguration['transfer_interval']),
						'add_empty' => true,
					)),
				));
				break;
			case 'axenicity':
				$labelConfiguration['genus_id'] = $value;
				$field = 'is_axenic';
				$form->setWidgets(array('is_axenic' => new sfWidgetFormChoice(array('choices' => ExternalStrainLabelForm::$booleanChoices))));
				break;
			case 'container':
				$labelConfiguration['is_axenic'] = $value;
				$field = 'container_id';
				$form->setWidgets(array(
					'container_id' => new sfWidgetFormDoctrineChoice(array(
						'model' => 'Container',
						'query' => ExternalStrainTable::getInstance()->availableContainersQuery(
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
						'query' => ExternalStrainTable::getInstance()->availableCultureMediaQuery(
							$labelConfiguration['supervisor_id'], $labelConfiguration['transfer_interval'], $labelConfiguration['genus_id'], $labelConfiguration['is_axenic'], $labelConfiguration['container_id']),
						'add_empty' => true,
					)),
				));
				break;
			case 'strain':
				$labelConfiguration['culture_medium_id'] = $value;
				$externalStrains = ExternalStrainTable::getInstance()->availableExternalStrainsForLabelConfiguration($labelConfiguration);
				break;
			}
			$this->getUser()->setAttribute('external_strain_label_configuration', $labelConfiguration);

			$this->setLayout(false);
			if ($div === 'strain') {
				return $this->renderPartial('labelExternalStrains', array('externalStrains' => $externalStrains));
			} else {
				return $this->renderPartial('labelFieldForm', array('div' => $div, 'field' => $field, 'form' => $form));
			}
		}
		return sfView::NONE;
	}
}
