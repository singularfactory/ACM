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
 * identification actions.
 *
 * @package ACM.Frontend
 * @subpackage identification
 */
class identificationActions extends MyActions {
	/**
	 * Index action
	 */
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'Identification', array('init' => false, 'sort_column' => 'identification_date'));
		$filters = $this->_processFilterConditions($request, 'identification');

		// Deal with search criteria
		$query = null;
		if (count($filters)) {
			if (!empty($filters['group_by'])) {
				$query = IdentificationTable::getInstance()->createQuery($this->mainAlias())->select("{$this->mainAlias()}.*");
				$this->groupBy = $filters['group_by'];

				$relatedAlias = sfInflector::camelize($this->groupBy);
				$relatedForeignKey = sfInflector::foreign_key($this->groupBy);

				$query = $query
					->addSelect("COUNT(DISTINCT {$this->mainAlias()}.id) as n_identifications")
					->groupBy("{$this->mainAlias()}.$relatedForeignKey");

				$query = $query->innerJoin("{$this->mainAlias()}.$relatedAlias m");
				if ($this->groupBy == 'petitioner') {
					$query = $query->addSelect('CONCAT(m.name, \' \', m.surname) as value');
				} else {
					$query = $query->addSelect('m.id as value');
				}
			} else {
				$query = $this->pager->getQuery();
			}

			$query = $query
				->leftJoin("{$this->mainAlias()}.Sample sa")
				->leftJoin("{$this->mainAlias()}.Petitioner pe")
				->where('1=1');

			if (!empty($filters['id'])) {
				$this->filters['Code'] = $filters['id'];
				preg_match('/^[Bb]?[Ee]?[Aa]?\s*[iI]?[dD]?(\d{1,4})_?(\d{1,2})?.*$/', $filters['id'], $matches);
				if (isset($matches[2])) {
					$query = $query->andWhere("({$this->mainAlias()}.yearly_count = ? AND {$this->mainAlias()}.identification_date BETWEEN ? AND ?)", array($matches[1], "{$matches[2]}-01-01", "{$matches[2]}-12-31"));
				} else {
					$query = $query->andWhere("{$this->mainAlias()}.yearly_count = ?", $matches[1]);
				}
			}

			if (!empty($filters['sample_id'])) {
				$this->filters['Sample'] = $filters['sample_id'];
				preg_match('/^(\d{1,4}).*$/', $filters['sample_id'], $matches);
				$query = $query->andWhere("{$this->mainAlias()}.sample_id = ?", $matches[1]);
			}

			foreach (array('petitioner_id') as $filter) {
				if (!empty($filters[$filter])) {
					$query = $query->andWhere("{$this->mainAlias()}.$filter = ?", $filters[$filter]);
					$table = sprintf('%sTable', sfInflector::camelize(str_replace('_id', '', $filter)));
					if ($filter === 'petitioner_id') {
						$table = 'PetitionersTable';
					}
					$table = call_user_func(array($table, 'getInstance'));
					$this->filters[$filter] = $table->find($filters[$filter])->getName();
				}
			}

			foreach (array('microscopy_identification', 'molecular_identification') as $filter) {
				if (!empty($filters[$filter])) {
					$this->filters[$filter] = $filters[$filter];
					$query = $query->andWhere("{$this->mainAlias()}.$filter LIKE ?", "%{$filters[$filter]}%");
				}
			}
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Petitioner pe")
				->leftJoin("{$this->mainAlias()}.Sample sa");
		}

		if (empty($filters['group_by'])) {
			$this->pager->setQuery($query);
			$this->pager->init();
			$this->results = $this->pager->getResults();
		} else {
			$this->results = $query->execute();
		}

		// Keep track of the last page used in list
		$this->getUser()->setAttribute('identification.index_page', $request->getParameter('page'));

		// Add a form to filter results
		$this->form = new IdentificationForm(array(), array('search' => true));
	}

	public function executeShow(sfWebRequest $request) {
		$this->identification = IdentificationTable::getInstance()->find(array($request->getParameter('id')));
		$this->forward404Unless($this->identification);
	}

	public function executeNew(sfWebRequest $request) {
		if ( $lastIdentification = $this->getUser()->getAttribute('identification.last_object_created') ) {
			$identification = new Identification();
			$identification->setSampleId($lastIdentification->getSampleId());

			$this->form = new identificationForm($identification);
			$this->getUser()->setAttribute('identification.last_object_created', null);
		}
		else {
			$this->form = new IdentificationForm();
		}

		$this->hasSamples = (SampleTable::getInstance()->count() > 0)?true:false;
	}

	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new IdentificationForm();
		$this->hasSamples = (SampleTable::getInstance()->count() > 0)?true:false;

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($identification = IdentificationTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object identification does not exist (%s).', $request->getParameter('id')));
		$this->form = new IdentificationForm($identification);
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($identification = IdentificationTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object identification does not exist (%s).', $request->getParameter('id')));
		$this->form = new IdentificationForm($identification);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	protected function processForm(sfWebRequest $request, sfForm $form) {
		$taintedValues = $request->getParameter($form->getName());

		// Calculate value for yearly_count field
		if (isset($taintedValues['identification_date'])) {
			$year = $taintedValues['identification_date']['year'];
			$actualYear = date('Y', strtotime($form->getObject()->getIdentificationDate()));
			if ($form->isNew() || ($year != $actualYear)) {
				$taintedValues['yearly_count'] = IdentificationTable::getInstance()->getNextYearlyCount($year);
			}
		}

		// Validate form
		$form->bind($taintedValues, $request->getFiles($form->getName()));
		if ($form->isValid()) {
			$message = null;
			$url = null;
			$isNew = $form->getObject()->isNew();

			// Retain the actual sample picture to delete after form save if necessary
			$oldSamplePicture = $form->getObject()->getSamplePicture();

			// Save object
			$identification = null;
			try {
				$identification = $form->save();

				if ($request->hasParameter('_save_and_add')) {
					$message = 'Identification request created successfully. Now you can add another one';
					$url = '@identification_new';

					// Reuse last object values
					$this->getUser()->setAttribute('identification.last_object_created', $identification);
				} elseif (!$isNew) {
					$message = 'Changes saved';
					$url = '@identification_show?id='.$identification->getId();
				} else {
					$message = 'Identification request created successfully';
					$url = '@identification_show?id='.$identification->getId();
				}

				// Delete previous picture
				$newSamplePicture = $identification->getSamplePicture();
				if ($oldSamplePicture !== $newSamplePicture) {
					$path = sfConfig::get('sf_upload_dir').sfConfig::get('app_identification_pictures_dir');
					$filename = $path.'/'.$oldSamplePicture;
					unlink($filename);
				}
			}
			catch (Exception $e) {
				$message = $e->getMessage();
			}

			if ($identification != null) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $identification->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ($url !== null) {
					$this->redirect($url);
				}
			}
		}

		$this->getUser()->setFlash('notice', 'The information on this identification request has some errors you need to fix', false);
	}

	/**
	 * Create labels for Identification records
	 *
	 * @param sfWebRequest $request Request information
	 * @return void
	 */
	public function executeCreateLabel(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::GET));
		$id = $request->getParameter('id');
		$this->forward404Unless($identification = IdentificationTable::getInstance()->find(array($id)), sprintf('Object identification does not exist (%s).', $id));

		if ($request->isMethod(sfRequest::POST)) {
			$values = $request->getPostParameters();
			$this->label = IdentificationTable::getInstance()->findOneById($id);
			$this->copies = $values['copies'];

			$this->setLayout(false);
			$pdf = new WKPDF();
			$pdf->set_html($this->getPartial('create_pdf'));
			$pdf->set_orientation('Landscape');
			$pdf->render();
			$pdf->output(WKPDF::$PDF_DOWNLOAD, "identification_labels.pdf");
			throw new sfStopException();
		} else {
			$this->form = new IdentificationLabelForm($identification);
			$this->identification = $identification;
		}
	}
}
