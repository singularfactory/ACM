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
 * external_strain actions.
 *
 * @package ACM.Frontend
 * @subpackage external_strain
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class external_strainActions extends MyActions {
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'ExternalStrain', array('init' => false, 'sort_column' => 'id'));

		// Deal with search criteria
		if ( $text = $request->getParameter('criteria') ) {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.TaxonomicClass tc")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species s")
				->where("{$this->mainAlias()}.id LIKE ?", "%$text%")
				->orWhere('tc.name LIKE ?', "%$text%")
				->orWhere('g.name LIKE ?', "%$text%")
				->orWhere('s.name LIKE ?', "%$text%");

			// Keep track of search terms for pagination
			$this->getUser()->setAttribute('search.criteria', $text);
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.TaxonomicClass tc")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species s");

			$this->getUser()->setAttribute('search.criteria', null);
		}
		$this->pager->setQuery($query);
		$this->pager->init();

		// Keep track of the last page used in list
		$this->getUser()->setAttribute('external_strain.index_page', $request->getParameter('page'));

		// Add a form to filter results
		$this->form = new ExternalStrainForm();
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
					$message = 'Deposit created successfully';
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
