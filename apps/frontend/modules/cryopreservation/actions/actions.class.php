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
 * cryopreservation actions.
 *
 * @package ACM.Frontend
 * @subpackage cryopreservation
 */
class cryopreservationActions extends MyActions {
	/**
	 * Index action
	 */
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'Cryopreservation', array('init' => false, 'sort_column' => 'id'));
		$filters = $this->_processFilterConditions($request, 'cryopreservation');

		$query = null;
		if (count($filters)) {
			if (!empty($filters['group_by'])) {
				$query = CryopreservationTable::getInstance()->createQuery($this->mainAlias())->select("{$this->mainAlias()}.*");
				$this->groupBy = $filters['group_by'];

				if (in_array($this->groupBy, array('subject'))) {
					$relatedAlias = $this->groupBy;
					$relatedForeignKey = $this->groupBy;
					$recursive = false;
				} else {
					$relatedAlias = sfInflector::camelize($this->groupBy);
					$relatedForeignKey = sfInflector::foreign_key($this->groupBy);
					$recursive = true;
				}

				$query = $query
					->addSelect("COUNT(DISTINCT {$this->mainAlias()}.id) as n_cryopreservations")
					->groupBy("{$this->mainAlias()}.$relatedForeignKey");

				if ($recursive) {
					$query = $query->innerJoin("{$this->mainAlias()}.$relatedAlias m");
					$query = $query->addSelect('m.name as value');
				} else {
					$query = $query->addSelect("{$this->mainAlias()}.$relatedAlias as value");
				}
			} else {
				$query = $this->pager->getQuery();
			}

			$query = $query
				->leftJoin("{$this->mainAlias()}.Strain st")
				->leftJoin("{$this->mainAlias()}.ExternalStrain est")
				->leftJoin("{$this->mainAlias()}.Sample sa")
				->leftJoin("{$this->mainAlias()}.PatentDeposit pd")
				->leftJoin("{$this->mainAlias()}.MaintenanceDeposit md")
				->leftJoin("{$this->mainAlias()}.CryopreservationMethod cm")
				->leftJoin("st.TaxonomicClass tc")
				->leftJoin("st.Genus g")
				->leftJoin("st.Species sp")
				->leftJoin("est.TaxonomicClass etc")
				->leftJoin("est.Genus eg")
				->leftJoin("est.Species esp")
				->leftJoin("pd.TaxonomicClass ptc")
				->leftJoin("pd.Genus pg")
				->leftJoin("pd.Species psp")
				->leftJoin("md.TaxonomicClass mtc")
				->leftJoin("md.Genus mg")
				->leftJoin("md.Species msp")
				->where('1=1');

			foreach (array('taxonomic_class_id', 'genus_id', 'species_id') as $filter) {
				if (!empty($filters[$filter])) {
					$query = $query->andWhere("st.$filter = ? OR est.$filter = ? OR pd.$filter = ? OR md.$filter = ?", array_fill(0, 4, $filters[$filter]));

					$table = sprintf('%sTable', sfInflector::camelize(str_replace('_id', '', $filter)));
					$table = call_user_func(array($table, 'getInstance'));
					$this->filters[$filter] = $table->find($filters[$filter])->getName();
				}
			}

			foreach (array('cryopreservation_method_id') as $filter) {
				if (!empty($filters[$filter])) {
					$query = $query->andWhere("{$this->mainAlias()}.$filter = ?", $filters[$filter]);

					$table = sprintf('%sTable', sfInflector::camelize(str_replace('_id', '', $filter)));
					$table = call_user_func(array($table, 'getInstance'));
					$this->filters[$filter] = $table->find($filters[$filter])->getName();
				}
			}

			if (!empty($filters['subject'])) {
				$this->filters['Subject'] = $filters['subject'];
				$query = $query->andWhere("{$this->mainAlias()}.subject LIKE ?", sprintf('%%%s%%', $filters['subject']));
			}

			if (!empty($filters['id'])) {
				$this->filters['Code'] = $filters['id'];
				preg_match('/^[Bb]?[Ee]?[Aa]?\s*(\d{1,4})\s*[bB]?.*$/', $filters['id'], $matches);
				$query = $query->andWhere("(st.code = ? OR est.id = ? OR pd.id = ? OR md.id = ?)", array($filters[$filter], $filters[$filter], $filters[$filter], $filters[$filter]));
			}
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Strain st")
				->leftJoin("{$this->mainAlias()}.ExternalStrain est")
				->leftJoin("{$this->mainAlias()}.PatentDeposit pd")
				->leftJoin("{$this->mainAlias()}.MaintenanceDeposit md")
				->leftJoin("{$this->mainAlias()}.CryopreservationMethod cm")
				->leftJoin("st.TaxonomicClass tc")
				->leftJoin("st.Genus g")
				->leftJoin("st.Species sp")
				->leftJoin("est.TaxonomicClass etc")
				->leftJoin("est.Genus eg")
				->leftJoin("est.Species esp")
				->leftJoin("pd.TaxonomicClass ptc")
				->leftJoin("pd.Genus pg")
				->leftJoin("pd.Species psp")
				->leftJoin("md.TaxonomicClass mtc")
				->leftJoin("md.Genus mg")
				->leftJoin("md.Species msp");
		}

		if (empty($filters['group_by'])) {
			$this->pager->setQuery($query);
			$this->pager->init();
			$this->results = $this->pager->getResults();
		} else {
			$this->results = $query->execute();
		}

		// Keep track of the last page used in list
		$this->getUser()->setAttribute('cryopreservation.index_page', $request->getParameter('page'));

		// Add a form to filter results
		$this->form = new CryopreservationForm(array(), array('search' => true));
	}

	public function executeShow(sfWebRequest $request) {
		$this->cryopreservation = CryopreservationTable::getInstance()->find(array($request->getParameter('id')));
		$this->forward404Unless($this->cryopreservation);
	}

	protected function configureFormByCryopreservationSubject(sfForm $form, $subject = 'sample') {
		$form->setDefault('subject', $subject);
		switch( $subject ) {
		case 'strain':
			unset($form['sample_id']);
			unset($form['external_strain_id']);
			unset($form['patent_deposit_id']);
			unset($form['maintenance_deposit_id']);
			break;
		case 'external_strain':
			unset($form['sample_id']);
			unset($form['strain_id']);
			unset($form['patent_deposit_id']);
			unset($form['maintenance_deposit_id']);
			break;
		case 'sample':
		default:
			unset($form['strain_id']);
			unset($form['external_strain_id']);
			unset($form['patent_deposit_id']);
			unset($form['maintenance_deposit_id']);
			break;
		case 'patent_deposit':
			unset($form['sample_id']);
			unset($form['strain_id']);
			unset($form['external_strain_id']);
			unset($form['maintenance_deposit_id']);
			break;
		case 'maintenance_deposit':
			unset($form['sample_id']);
			unset($form['strain_id']);
			unset($form['external_strain_id']);
			unset($form['patent_deposit_id']);
			break;
		}
	}

	public function executeNew(sfWebRequest $request) {
		if ( $lastCryopreservation = $this->getUser()->getAttribute('cryopreservation.last_object_created') ) {
			$cryopreservation = new Cryopreservation();

			$cryopreservation->setStrainId($lastCryopreservation->getStrainId());
			$cryopreservation->setSampleId($lastCryopreservation->getSampleId());
			$cryopreservation->setExternalStrainId($lastCryopreservation->getExternalStrainId());
			$cryopreservation->setPatentDepositId($lastCryopreservation->getPatentDepositId());
			$cryopreservation->setMaintenanceDepositId($lastCryopreservation->getMaintenanceDepositId());
			$cryopreservation->setCryopreservationMethodId($lastCryopreservation->getCryopreservationMethodId());

			$this->form = new CryopreservationForm($cryopreservation);
			$this->getUser()->setAttribute('cryopreservation.last_object_created', null);
		}
		else {
			$this->form = new CryopreservationForm();
		}

		if ( $subject = $request->getParameter('subject') ) {
			$this->configureFormByCryopreservationSubject($this->form, $subject);
		}
		else {
			$this->configureFormByCryopreservationSubject($this->form);
		}

		$this->hasStrains = (StrainTable::getInstance()->count() > 0)?true:false;
		$this->hasSamples = (SampleTable::getInstance()->count() > 0)?true:false;
		$this->hasExternalStrains = (ExternalStrainTable::getInstance()->count() > 0)?true:false;
		$this->hasPatentDeposits = (PatentDepositTable::getInstance()->count() > 0)?true:false;
		$this->hasMaintenanceDeposits = (MaintenanceDepositTable::getInstance()->count() > 0)?true:false;
	}

	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new CryopreservationForm();
		$cryopreservation = $request->getParameter('cryopreservation');
		$this->configureFormByCryopreservationSubject($this->form, $cryopreservation['subject']);
		$this->hasStrains = (StrainTable::getInstance()->count() > 0)?true:false;
		$this->hasSamples = (SampleTable::getInstance()->count() > 0)?true:false;
		$this->hasExternalStrains = (ExternalStrainTable::getInstance()->count() > 0)?true:false;
		$this->hasPatentDeposits = (PatentDepositTable::getInstance()->count() > 0)?true:false;
		$this->hasMaintenanceDeposits = (MaintenanceDepositTable::getInstance()->count() > 0)?true:false;

		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($cryopreservation = CryopreservationTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object cryopreservation does not exist (%s).', $request->getParameter('id')));
		$this->form = new CryopreservationForm($cryopreservation);

		if ( $subject = $request->getParameter('subject') ) {
			$this->configureFormByCryopreservationSubject($this->form, $subject);
		}
		else {
			$this->configureFormByCryopreservationSubject($this->form, $cryopreservation->getSubject());
		}
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($cryopreservation = CryopreservationTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object cryopreservation does not exist (%s).', $request->getParameter('id')));

		$this->form = new CryopreservationForm($cryopreservation);
		$cryopreservation = $request->getParameter('cryopreservation');
		$this->configureFormByCryopreservationSubject($this->form, $cryopreservation['subject']);
		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	protected function processForm(sfWebRequest $request, sfForm $form) {
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

		// Validate form
		if ( $form->isValid() ) {
			$message = null;
			$url = null;
			$isNew = $form->getObject()->isNew();

			// Save object
			$cryopreservation = null;
			try {
				$cryopreservation = $form->save();

				if ( $request->hasParameter('_save_and_add') ) {
					$message = 'Cryopreservation created successfully. Now you can add another one';
					$url = '@cryopreservation_new';

					// Reuse last object values
					$this->getUser()->setAttribute('cryopreservation.last_object_created', $cryopreservation);
				}
				elseif ( !$isNew ) {
					$message = 'Changes saved';
					$url = '@cryopreservation_show?id='.$cryopreservation->getId();
				}
				else {
					$message = 'Cryopreservation created successfully';
					$url = '@cryopreservation_show?id='.$cryopreservation->getId();
				}
			}
			catch (Exception $e) {
				$message = $e->getMessage();
			}

			if ( $cryopreservation != null ) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $cryopreservation->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ( $url !== null ) {
					$this->redirect($url);
				}
			}
		}

		$this->getUser()->setFlash('notice', 'The information on this cryopreservation has some errors you need to fix', false);
	}

	/**
	 * Create labels for Cryopreservation records
	 *
	 * @param sfWebRequest $request Request information
	 * @return void
	 */
	public function executeCreateLabel(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::GET));
		$id = $request->getParameter('id');
		$this->forward404Unless($cryopreservation = CryopreservationTable::getInstance()->find(array($id)), sprintf('Object cryopreservation does not exist (%s).', $id));

		if ($request->isMethod(sfRequest::POST)) {
			$values = $request->getPostParameters();
			$this->label = $cryopreservation;
			$this->copies = $values['copies'];
			$this->replicate = $values['replicate'];

			$this->setLayout(false);
			$pdf = new WKPDF();
			$pdf->set_html($this->getPartial('create_pdf'));
			$pdf->set_orientation('Landscape');
			$pdf->render();
			$pdf->output(WKPDF::$PDF_DOWNLOAD, "cryopreservation_labels.pdf");
			throw new sfStopException();
		} else {
			$this->form = new CryopreservationLabelForm($cryopreservation);
			$firstReplicate = $cryopreservation->getFirstReplicate();
			$secondReplicate = $cryopreservation->getSecondReplicate();
			$thirdReplicate = $cryopreservation->getThirdReplicate();
			$this->form->setWidget('replicate', new sfWidgetFormChoice(array(
				'choices'  => array($firstReplicate => $firstReplicate, $secondReplicate => $secondReplicate, $thirdReplicate => $thirdReplicate),
				'expanded' => true,
				'default' => $firstReplicate,
			)));
			$this->cryopreservation = $cryopreservation;
		}
	}
}
