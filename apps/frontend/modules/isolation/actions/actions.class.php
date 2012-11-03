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
 * isolation actions.
 *
 * @package ACM.Frontend
 * @subpackage isolation
 */
class isolationActions extends MyActions {
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'Isolation', array('init' => false, 'sort_column' => 'reception_date'));
		$filters = $this->_processFilterConditions($request, 'isolation');

		// Deal with search criteria
		$query = null;
		if (count($filters)) {
			if (!empty($filters['group_by'])) {
				$query = IsolationTable::getInstance()->createQuery($this->mainAlias())->select("{$this->mainAlias()}.*");
				$this->groupBy = $filters['group_by'];

				$query = $query
					->addSelect("COUNT(DISTINCT {$this->mainAlias()}.id) as n_isolations")
					->addSelect("{$this->mainAlias()}.isolation_subject as value")
					->groupBy("{$this->mainAlias()}.isolation_subject");
			} else {
				$query = $this->pager->getQuery();
			}

			$query = $query
				->leftJoin("{$this->mainAlias()}.Strain st")
				->leftJoin("{$this->mainAlias()}.ExternalStrain est")
				->leftJoin("{$this->mainAlias()}.Sample sa")
				->leftJoin("st.TaxonomicClass tc")
				->leftJoin("st.Genus g")
				->leftJoin("st.Species sp")
				->leftJoin("est.TaxonomicClass etc")
				->leftJoin("est.Genus eg")
				->leftJoin("est.Species esp")
				->where('1=1');

			if (!empty($filters['id'])) {
				$this->filters['Code'] = $filters['id'];
				if (preg_match('/^[Bb]?[Ee]?[Aa]?\s*[Ii]?[Ss]?(\d{1,2})_?(\d{1,2})\s*$/', $filters['id'], $matches)) {
					$query = $query->andWhere("({$this->mainAlias()}.yearly_count = ? AND YEAR({$this->mainAlias()}.reception_date) = ?)", $matches[1], $matches[2]);
				}
			}

			if (!empty($filters['related_code'])) {
				$this->filters['Related code'] = $filters['related_code'];
				// Sample
				if (preg_match('/^(\d{1,4}).*$/', $filters['related_code'], $matches)) {
					$query = $query->orWhere("sa.id = ?", $matches[1]);
				}

				// Strain
				if (preg_match('/^[Bb]?[Ee]?[Aa]?\s*[Ii]?[Ss]?(\d{1,2})_?(\d{1,2})\s*$/', $filters['related_code'], $matches)) {
					$query = $query->orWhere("st.code = ?", $matches[1]);
				}

				// Research collection
				if (preg_match('/^[Bb]?[Ee]?[Aa]?\s*[Rr]?\s*[Cc]?\s*(\d{1,4})\s*[Bb]?.*$/', $filters['related_code'], $matches)) {
					$query = $query->orWhere("est.id = ?", $matches[1]);
				}

				// External code
				$query = $query->orWhere("{$this->mainAlias()}.external_code = ?", $filters['related_code']);
			}

			if (!empty($filters['isolation_subject'])) {
				$this->filters['Material'] = $filters['isolation_subject'];
				$query = $query->andWhere("{$this->mainAlias()}.isolation_subject = ?", $filters['isolation_subject']);
			}

			foreach (array('taxonomic_class_id', 'genus_id', 'species_id') as $filter) {
				if (!empty($filters[$filter])) {
					$query = $query->andWhere("(st.$filter = ? OR est.$filter = ?)", array_fill(0, 2, $filters[$filter]));
					$table = sprintf('%sTable', sfInflector::camelize(str_replace('_id', '', $filter)));
					$table = call_user_func(array($table, 'getInstance'));
					$this->filters[$filter] = $table->find($filters[$filter])->getName();
				}
			}
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.ExternalStrain est")
				->leftJoin("{$this->mainAlias()}.Strain st")
				->leftJoin("{$this->mainAlias()}.Sample sa")
				->leftJoin("{$this->mainAlias()}.TaxonomicClass tc")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species sp")
				->leftJoin("st.TaxonomicClass sttc")
				->leftJoin("st.Genus stg")
				->leftJoin("st.Species stsp")
				->leftJoin("est.TaxonomicClass esttc")
				->leftJoin("est.Genus estg")
				->leftJoin("est.Species estsp");
		}

		if (empty($filters['group_by'])) {
			$this->pager->setQuery($query);
			$this->pager->init();
			$this->results = $this->pager->getResults();
		} else {
			$this->results = $query->execute();
		}

		// Keep track of the last page used in list
		$this->getUser()->setAttribute('isolation.index_page', $request->getParameter('page'));

		// Add a form to filter results
		$this->form = new IsolationForm(array(), array('search' => true));
	}

	public function executeShow(sfWebRequest $request) {
		$this->isolation = Doctrine_Core::getTable('Isolation')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->isolation);
	}

	protected function configureFormByIsolationSubject(sfForm $form, $subject = 'sample') {
		$form->setDefault('isolation_subject', $subject);
		switch( $subject ) {
		case 'external':
			unset($form['sample_id']);
			unset($form['strain_id']);
			unset($form['external_strain_id']);
			break;

		case 'strain':
			unset($form['external_code']);
			unset($form['location_id']);
			unset($form['sample_id']);
			unset($form['environment_id']);
			unset($form['habitat_id']);
			unset($form['taxonomic_class_id']);
			unset($form['genus_id']);
			unset($form['species_id']);
			unset($form['authority_id']);
			unset($form['external_strain_id']);
			break;

		case 'external_strain':
			unset($form['external_code']);
			unset($form['location_id']);
			unset($form['sample_id']);
			unset($form['environment_id']);
			unset($form['habitat_id']);
			unset($form['taxonomic_class_id']);
			unset($form['genus_id']);
			unset($form['species_id']);
			unset($form['authority_id']);
			unset($form['strain_id']);
			break;

		case 'sample':
		default:
			unset($form['external_code']);
			unset($form['location_id']);
			unset($form['strain_id']);
			unset($form['environment_id']);
			unset($form['habitat_id']);
			unset($form['taxonomic_class_id']);
			unset($form['genus_id']);
			unset($form['species_id']);
			unset($form['authority_id']);
			unset($form['external_strain_id']);
			break;
		}
	}

	public function executeNew(sfWebRequest $request) {
		if ( $lastIsolation = $this->getUser()->getAttribute('isolation.last_object_created') ) {
			$isolation = new Isolation();

			$isolation->setExternalStrainId($lastIsolation->getExternalStrainId());
			$isolation->setStrainId($lastIsolation->getStrainId());
			$isolation->setSampleId($lastIsolation->getSampleId());
			$isolation->setReceptionDate($lastIsolation->getReceptionDate());
			$isolation->setTaxonomicClassId($lastIsolation->getTaxonomicClassId());
			$isolation->setGenusId($lastIsolation->getGenusId());
			$isolation->setSpeciesId($lastIsolation->getSpeciesId());
			$isolation->setAuthorityId($lastIsolation->getAuthorityId());
			$isolation->setLocationId($lastIsolation->getLocationId());
			$isolation->setEnvironmentId($lastIsolation->getEnvironmentId());
			$isolation->setHabitatId($lastIsolation->getHabitatId());
			$isolation->setPurificationMethodId($lastIsolation->getPurificationMethodId());

			$this->form = new IsolationForm($isolation);
			$this->getUser()->setAttribute('isolation.last_object_created', null);
		}
		else {
			$this->form = new IsolationForm();
		}

		if ( $subject = $request->getParameter('subject') ) {
			$this->configureFormByIsolationSubject($this->form, $subject);
		}
		else {
			$this->configureFormByIsolationSubject($this->form);
		}

		$this->hasPurificationMethods = (PurificationMethodTable::getInstance()->count() > 0)?true:false;
	}

	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new IsolationForm();
		$isolation = $request->getParameter('isolation');
		$this->configureFormByIsolationSubject($this->form, $isolation['isolation_subject']);
		$this->hasPurificationMethods = (PurificationMethodTable::getInstance()->count() > 0)?true:false;

		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($isolation = IsolationTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object isolation does not exist (%s).', $request->getParameter('id')));
		$this->form = new IsolationForm($isolation);

		if ( $subject = $request->getParameter('subject') ) {
			$this->configureFormByIsolationSubject($this->form, $subject);
		}
		else {
			$this->configureFormByIsolationSubject($this->form, $isolation->getIsolationSubject());
		}
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($isolation = IsolationTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object isolation does not exist (%s).', $request->getParameter('id')));

		$this->form = new IsolationForm($isolation);
		$isolation = $request->getParameter('isolation');
		$this->configureFormByIsolationSubject($this->form, $isolation['isolation_subject']);
		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	protected function processForm(sfWebRequest $request, sfForm $form) {
		$taintedValues = $request->getParameter($form->getName());

		// Calculate value for yearly_count field
		if (isset($taintedValues['reception_date'])) {
			$year = $taintedValues['reception_date']['year'];
			$actualYear = date('Y', strtotime($form->getObject()->getReceptionDate()));
			if ($form->isNew() || ($year != $actualYear)) {
				$taintedValues['yearly_count'] = IsolationTable::getInstance()->getNextYearlyCount($year);
			}
		}

		// Validate form
		$form->bind($taintedValues, $request->getFiles($form->getName()));
		if ($form->isValid()) {
			$message = null;
			$url = null;
			$isNew = $form->getObject()->isNew();

			// Save object
			$isolation = null;
			try {
				$isolation = $form->save();

				if ($request->hasParameter('_save_and_add')) {
					$message = 'Isolation created successfully. Now you can add another one';
					$url = '@isolation_new';

					// Reuse last object values
					$this->getUser()->setAttribute('isolation.last_object_created', $isolation);
				} elseif (!$isNew) {
					$message = 'Changes saved';
					$url = '@isolation_show?id='.$isolation->getId();
				} else {
					$message = 'Isolation created successfully';
					$url = '@isolation_show?id='.$isolation->getId();
				}
			}
			catch (Exception $e) {
				$message = $e->getMessage();
			}

			if ($isolation != null) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $isolation->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ($url !== null) {
					$this->redirect($url);
				}
			}
		}

		$this->getUser()->setFlash('notice', 'The information on this isolation has some errors you need to fix', false);
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
		$this->forward404Unless($isolation = IsolationTable::getInstance()->find(array($id)), sprintf('Object isolation does not exist (%s).', $id));

		if ($request->isMethod(sfRequest::POST)) {
			$values = $request->getPostParameters();
			$this->label = IsolationTable::getInstance()->findOneById($id);
			$this->copies = $values['copies'];

			$this->setLayout(false);
			$pdf = new WKPDF();
			$pdf->set_html($this->getPartial('create_pdf'));
			$pdf->set_orientation('Landscape');
			$pdf->render();
			$pdf->output(WKPDF::$PDF_DOWNLOAD, "isolation_labels.pdf");
			throw new sfStopException();
		} else {
			$this->form = new IsolationLabelForm($isolation);
			$this->isolation = $isolation;
		}
	}
}
