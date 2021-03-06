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
 * Actions for maintenance_deposit module
 *
 * @package ACM.Frontend
 * @subpackage MaintenanceDeposit
 * @since 1.0
 * @version 1.2
 */
class maintenance_depositActions extends MyActions {
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'MaintenanceDeposit', array('init' => false, 'sort_column' => 'deposition_date'));
		$filters = $this->_processFilterConditions($request, 'maintenance_deposit');

		if (count($filters)) {
			if (!empty($filters['group_by'])) {
				$query = MaintenanceDepositTable::getInstance()->createQuery($this->mainAlias())->select("{$this->mainAlias()}.*");
				$this->groupBy = $filters['group_by'];

				if (in_array($this->groupBy, array('is_epitype', 'is_axenic'))) {
					$relatedAlias = $this->groupBy;
					$relatedForeignKey = $this->groupBy;
					$recursive = false;
				} else {
					$relatedAlias = sfInflector::camelize($this->groupBy);
					$relatedForeignKey = sfInflector::foreign_key($this->groupBy);
					$recursive = true;
				}

				$query = $query
					->addSelect("COUNT(DISTINCT {$this->mainAlias()}.id) as n_maintenance_deposits")
					->groupBy("{$this->mainAlias()}.$relatedForeignKey");

				if ($recursive) {
					$query = $query->innerJoin("{$this->mainAlias()}.$relatedAlias m");
					if ($this->groupBy == 'depositor') {
						$query = $query->addSelect('CONCAT(m.name, \' \', m.surname) as value');
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
				->leftJoin("{$this->mainAlias()}.TaxonomicClass t")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species s")
				->leftJoin("{$this->mainAlias()}.Depositor d")
				->where('1=1');

			foreach (array('taxonomic_class_id', 'genus_id', 'species_id', 'authority_id', 'depositor_id') as $filter) {
				if (!empty($filters[$filter])) {
					$query = $query->andWhere("{$this->mainAlias()}.$filter = ?", $filters[$filter]);

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

			if (!empty($filters['id'])) {
				$this->filters['Code'] = $filters['id'];
				preg_match('/^[Bb]?[Ee]?[Aa]?\s*[Mm]?\s*(\d{2})_(\d{2}).*$/', $filters['id'], $matches);
				if (array_key_exists(2, $matches)) {
					$query = $query->andWhere("{$this->mainAlias()}.deposition_date >= ?", sprintf('%s-01-01 00:00:00', $matches[2]));
					$query = $query->andWhere("{$this->mainAlias()}.deposition_date <= ?", sprintf('%s-12-31 00:00:00', $matches[2]));
				}
				if (array_key_exists(1, $matches)) {
					$query = $query->andWhere("{$this->mainAlias()}.yearly_count = ?", $matches[1]);
				}
			}
		} else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.TaxonomicClass t")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species s")
				->leftJoin("{$this->mainAlias()}.Depositor d");
		}

		if (empty($filters['group_by'])) {
			$this->pager->setQuery($query);
			$this->pager->init();
			$this->results = $this->pager->getResults();
		} else {
			$this->results = $query->execute();
		}

		// Keep track of the last page used in list
		$this->getUser()->setAttribute('maintenance_deposit.index_page', $request->getParameter('page'));

		// Add a form to filter results
		$this->form = new MaintenanceDepositForm(array(), array('search' => true));
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
		$taintedValues = $request->getParameter($form->getName());

		// Calculate value for yearly_count field
		if (isset($taintedValues['deposition_date'])) {
			$year = $taintedValues['deposition_date']['year'];
			$actualYear = date('Y', strtotime($form->getObject()->getDepositionDate()));
			if ($form->isNew() || ($year != $actualYear)) {
				$taintedValues['yearly_count'] = MaintenanceDepositTable::getInstance()->getNextYearlyCount($year);
			}
		}

		// Validate form
		$form->bind($taintedValues, $request->getFiles($form->getName()));
		if ($form->isValid()) {
			$flashMessage = null;
			$url = null;
			$isNew = $form->getObject()->isNew();

			$maintenanceDeposit = null;
			try {
				$maintenanceDeposit = $form->save();

				if ($request->hasParameter('_save_and_add')) {
					$message = 'Deposited created successfully. Now you can add another one';
					$url = '@maintenance_deposit_new';

					// Reuse last object values
					$this->getUser()->setAttribute('maintenance_deposit.last_object_created', $sample);
				} elseif (!$isNew) {
					$message = 'Changes saved';
					$url = '@maintenance_deposit_show?id='.$maintenanceDeposit->getId();
				} else {
					$message = 'Deposit created successfully';
					$url = '@maintenance_deposit_show?id='.$maintenanceDeposit->getId();
				}
			}
			catch (Exception $e) {
				$message = $e->getMessage();
			}

			if ($maintenanceDeposit != null) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $maintenanceDeposit->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ($url !== null) {
					$this->redirect($url);
				}
			}
		}

		$this->getUser()->setFlash('notice', 'The information on this deposit has some errors you need to fix', false);
	}

	/**
	 * Create labels for MaintenanceDeposit records
	 *
	 * @param sfWebRequest $request Request information
	 * @return void
	 */
	public function executeCreateLabel(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::GET));
		if ($request->isMethod(sfRequest::POST)) {
			$values = $request->getPostParameters();
			$this->labels = MaintenanceDepositTable::getInstance()->availableMaintenanceDepositsForLabelConfiguration($values);
			$this->copies = $values['copies'];
			$this->cultureMedium = CultureMediumTable::getInstance()->findOneById($values['culture_medium_id']);

			$this->setLayout(false);
			$pdf = new WKPDF();
			$pdf->set_html($this->getPartial('create_pdf'));
			$pdf->set_orientation('Landscape');
			$pdf->render();
			$pdf->output(WKPDF::$PDF_DOWNLOAD, "maintenance_deposit_labels.pdf");
			throw new sfStopException();
		} else {
			$this->getUser()->setAttribute('maintenance_deposit_label_configuration', array());
			$this->form = new MaintenanceDepositLabelForm();
			$this->form->setWidgets(array(
				'supervisor_id' => new sfWidgetFormDoctrineChoice(array(
					'model' => 'Supervisor',
					'query' => MaintenanceDepositTable::getInstance()->availableSupervisorsQuery(),
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
			$maintenanceDeposits = array();

			if (empty($div) || empty($value)) {
				return sfView::NONE;
			}

			$labelConfiguration = $this->getUser()->getAttribute('maintenance_deposit_label_configuration');
			$form = new MaintenanceDepositLabelForm();
			switch ($div) {
			case 'transfer_intervals':
				$labelConfiguration['supervisor_id'] = $value;
				$field = 'transfer_interval';
				$form->setWidgets(array(
					'transfer_interval' => new sfWidgetFormChoice(array(
						'choices' => MaintenanceDepositTable::getInstance()->availableTransferIntervalChoices($labelConfiguration['supervisor_id']),
					))));
				break;
			case 'genus':
				$labelConfiguration['transfer_interval'] = $value;
				$field = 'genus_id';
				$form->setWidgets(array(
					'genus_id' => new sfWidgetFormDoctrineChoice(array(
						'model' => 'Genus',
						'query' => MaintenanceDepositTable::getInstance()->availableGenusQuery(
							$labelConfiguration['supervisor_id'], $labelConfiguration['transfer_interval']),
						'add_empty' => true,
					)),
				));
				break;
			case 'axenicity':
				$labelConfiguration['genus_id'] = $value;
				$field = 'is_axenic';
				$form->setWidgets(array('is_axenic' => new sfWidgetFormChoice(array('choices' => MaintenanceDepositLabelForm::$booleanChoices))));
				break;
			case 'culture_medium':
				$labelConfiguration['is_axenic'] = $value;
				$field = 'culture_medium_id';
				$form->setWidgets(array(
					'culture_medium_id' => new sfWidgetFormDoctrineChoice(array(
						'model' => 'CultureMedium',
						'query' => MaintenanceDepositTable::getInstance()->availableCultureMediaQuery(
							$labelConfiguration['supervisor_id'], $labelConfiguration['transfer_interval'], $labelConfiguration['genus_id'], $labelConfiguration['is_axenic']),
						'add_empty' => true,
					)),
				));
				break;
			case 'strain':
				$labelConfiguration['culture_medium_id'] = $value;
				$maintenanceDeposits = MaintenanceDepositTable::getInstance()->availableMaintenanceDepositsForLabelConfiguration($labelConfiguration);
				break;
			}
			$this->getUser()->setAttribute('maintenance_deposit_label_configuration', $labelConfiguration);

			$this->setLayout(false);
			if ($div === 'strain') {
				return $this->renderPartial('labelMaintenanceDeposits', array('maintenanceDeposits' => $maintenanceDeposits));
			} else {
				return $this->renderPartial('labelFieldForm', array('div' => $div, 'field' => $field, 'form' => $form));
			}
		}
		return sfView::NONE;
	}
}
