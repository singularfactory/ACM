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
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'Identification', array('init' => false, 'sort_column' => 'identification_date'));

		// Deal with search criteria
		if ( $text = $request->getParameter('criteria') ) {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Sample sa")
				->where("{$this->mainAlias()}.identification_date LIKE ?", "%$text%")
				->orWhere('sa.id LIKE ?', "%$text%");

			// Keep track of search terms for pagination
			$this->getUser()->setAttribute('search.criteria', $text);
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Sample sa");

			$this->getUser()->setAttribute('search.criteria', null);
		}
		$this->pager->setQuery($query);
		$this->pager->init();

		// Keep track of the last page used in list
		$this->getUser()->setAttribute('identification.index_page', $request->getParameter('page'));

		// Add a form to filter results
		$this->form = new IdentificationForm();
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
