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
 * patent_deposit actions.
 *
 * @package ACM.Frontend
 * @subpackage patent_deposit
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class patent_depositActions extends MyActions {
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'PatentDeposit', array('init' => false, 'sort_column' => 'depositor_code'));

		// Deal with search criteria
		if ( $text = $request->getParameter('criteria') ) {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.TaxonomicClass tc")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species s")
				->leftJoin("{$this->mainAlias()}.Depositor d")
				->where("{$this->mainAlias()}.id LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.depositor_code LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.deposition_date LIKE ?", "%$text%")
				->orWhere('tc.name LIKE ?', "%$text%")
				->orWhere('g.name LIKE ?', "%$text%")
				->orWhere('s.name LIKE ?', "%$text%")
				->orWhere('d.name LIKE ?', "%$text%")
				->orWhere('d.surname LIKE ?', "%$text%");

			// Keep track of search terms for pagination
			$this->getUser()->setAttribute('search.criteria', $text);
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.TaxonomicClass tc")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species s")
				->leftJoin("{$this->mainAlias()}.Depositor d");

			$this->getUser()->setAttribute('search.criteria', null);
		}
		$this->pager->setQuery($query);
		$this->pager->init();

		// Keep track of the last page used in list
		$this->getUser()->setAttribute('patent_deposit.index_page', $request->getParameter('page'));

		// Add a form to filter results
		$this->form = new PatentDepositForm();
	}

	public function executeShow(sfWebRequest $request) {
		$this->patentDeposit = PatentDepositTable::getInstance()->find(array($request->getParameter('id')));
		$this->forward404Unless($this->patentDeposit);
	}

	public function executeNew(sfWebRequest $request) {
		if ( $lastDeposit = $this->getUser()->getAttribute('patent_deposit.last_object_created') ) {
			$patentDeposit = new PatentDeposit();
			$patentDeposit->setTaxonomicClassId($lastDeposit->getTaxonomicClassId());
			$patentDeposit->setGenusId($lastDeposit->getGenusId());
			$patentDeposit->setSpeciesId($lastDeposit->getSpeciesId());
			$patentDeposit->setAuthorityId($lastDeposit->getAuthorityId());
			$patentDeposit->setMaintenanceStatusId($lastDeposit->getMaintenanceStatusId());
			$patentDeposit->setCryopreservationMethodId($lastDeposit->getCryopreservationMethodId());
			$patentDeposit->setEnvironmentId($lastDeposit->getEnvironmentId());
			$patentDeposit->setHabitatId($lastDeposit->getHabitatId());
			$patentDeposit->setDepositorId($lastDeposit->getDepositorId());
			$patentDeposit->setIdentifierId($lastDeposit->getIdentifierId());
			$patentDeposit->setDepositionDate($lastDeposit->getDepositionDate());
			$patentDeposit->setCollectionDate($lastDeposit->getCollectionDate());
			$patentDeposit->setIsolationDate($lastDeposit->getIsolationDate());
			$patentDeposit->setTransferInterval($lastDeposit->getTransferInterval());
			$patentDeposit->setObservation($lastDeposit->getObservation());
			$patentDeposit->setCitations($lastDeposit->getCitations());
			$patentDeposit->setRemarks($lastDeposit->getRemarks());

			$this->form = new PatentDepositForm($patentDeposit);
			$this->getUser()->setAttribute('patent_deposit.last_object_created', null);
		}
		else {
			$this->form = new PatentDepositForm();
		}

		$this->hasIdentifiers = (IdentifierTable::getInstance()->count() > 0)?true:false;
		$this->hasDepositors = (DepositorTable::getInstance()->count() > 0)?true:false;
		$this->hasLocations = (LocationTable::getInstance()->count() > 0)?true:false;
		$this->hasCultureMedia = (CultureMediumTable::getInstance()->count() > 0)?true:false;
	}

	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new PatentDepositForm();
		$this->hasIdentifiers = (IdentifierTable::getInstance()->count() > 0)?true:false;
		$this->hasDepositors = (DepositorTable::getInstance()->count() > 0)?true:false;
		$this->hasLocations = (LocationTable::getInstance()->count() > 0)?true:false;
		$this->hasCultureMedia = (CultureMediumTable::getInstance()->count() > 0)?true:false;

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($patentDeposit = PatentDepositTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object patent deposit does not exist (%s).', $request->getParameter('id')));
		$this->form = new PatentDepositForm($patentDeposit);
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($patentDeposit = PatentDepositTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object patent deposit does not exist (%s).', $request->getParameter('id')));
		$this->form = new PatentDepositForm($patentDeposit);

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

			$patentDeposit = null;
			try {
				$patentDeposit = $form->save();

				if ( $request->hasParameter('_save_and_add') ) {
					$message = 'Deposited created successfully. Now you can add another one';
					$url = '@patent_deposit_new';

					// Reuse last object values
					$this->getUser()->setAttribute('patent_deposit.last_object_created', $sample);
				}
				elseif ( !$isNew ) {
					$message = 'Changes saved';
					$url = '@patent_deposit_show?id='.$patentDeposit->getId();
				}
				else {
					$message = 'Deposit created successfully';
					$url = '@patent_deposit_show?id='.$patentDeposit->getId();
				}
			}
			catch (Exception $e) {
				$message = $e->getMessage();
			}

			if ( $patentDeposit != null ) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $patentDeposit->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ( $url !== null ) {
					$this->redirect($url);
				}
			}
		}

		$this->getUser()->setFlash('notice', 'The information on this deposit has some errors you need to fix', false);
	}

	/**
	 * Create labels for PatentDeposit records
	 *
	 * @param sfWebRequest $request Request information
	 * @return void
	 */
	public function executeCreateLabel(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::GET));
		if ($request->isMethod(sfRequest::POST)) {
			$values = $request->getPostParameters();
			$this->labels = PatentDepositTable::getInstance()->availablePatentDepositsForLabelConfiguration($values);
			$this->copies = $values['copies'];
			$this->cultureMedium = CultureMediumTable::getInstance()->findOneById($values['culture_medium_id']);

			$this->setLayout(false);
			$pdf = new WKPDF();
			$pdf->set_html($this->getPartial('create_pdf'));
			$pdf->set_orientation('Landscape');
			$pdf->render();
			$pdf->output(WKPDF::$PDF_DOWNLOAD, "patent_deposit_labels.pdf");
			throw new sfStopException();
		} else {
			$this->getUser()->setAttribute('patent_deposit_label_configuration', array());
			$this->form = new PatentDepositLabelForm();
			$this->form->setWidgets(array(
				'supervisor_id' => new sfWidgetFormDoctrineChoice(array(
					'model' => 'Supervisor',
					'query' => PatentDepositTable::getInstance()->availableSupervisorsQuery(),
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
			$patentDeposits = array();

			if (empty($div) || empty($value)) {
				return sfView::NONE;
			}

			$labelConfiguration = $this->getUser()->getAttribute('patent_deposit_label_configuration');
			$form = new PatentDepositLabelForm();
			switch ($div) {
			case 'transfer_intervals':
				$labelConfiguration['supervisor_id'] = $value;
				$field = 'transfer_interval';
				$form->setWidgets(array(
					'transfer_interval' => new sfWidgetFormChoice(array(
						'choices' => PatentDepositTable::getInstance()->availableTransferIntervalChoices($labelConfiguration['supervisor_id']),
					))));
				break;
			case 'genus':
				$labelConfiguration['transfer_interval'] = $value;
				$field = 'genus_id';
				$form->setWidgets(array(
					'genus_id' => new sfWidgetFormDoctrineChoice(array(
						'model' => 'Genus',
						'query' => PatentDepositTable::getInstance()->availableGenusQuery(
							$labelConfiguration['supervisor_id'], $labelConfiguration['transfer_interval']),
						'add_empty' => true,
					)),
				));
				break;
			case 'axenicity':
				$labelConfiguration['genus_id'] = $value;
				$field = 'is_axenic';
				$form->setWidgets(array('is_axenic' => new sfWidgetFormChoice(array('choices' => PatentDepositLabelForm::$booleanChoices))));
				break;
			case 'culture_medium':
				$labelConfiguration['is_axenic'] = $value;
				$field = 'culture_medium_id';
				$form->setWidgets(array(
					'culture_medium_id' => new sfWidgetFormDoctrineChoice(array(
						'model' => 'CultureMedium',
						'query' => PatentDepositTable::getInstance()->availableCultureMediaQuery(
							$labelConfiguration['supervisor_id'], $labelConfiguration['transfer_interval'], $labelConfiguration['genus_id'], $labelConfiguration['is_axenic']),
						'add_empty' => true,
					)),
				));
				break;
			case 'strain':
				$labelConfiguration['culture_medium_id'] = $value;
				$patentDeposits = PatentDepositTable::getInstance()->availablePatentDepositsForLabelConfiguration($labelConfiguration);
				break;
			}
			$this->getUser()->setAttribute('patent_deposit_label_configuration', $labelConfiguration);

			$this->setLayout(false);
			if ($div === 'strain') {
				return $this->renderPartial('labelPatentDeposits', array('patentDeposits' => $patentDeposits));
			} else {
				return $this->renderPartial('labelFieldForm', array('div' => $div, 'field' => $field, 'form' => $form));
			}
		}
		return sfView::NONE;
	}
}
