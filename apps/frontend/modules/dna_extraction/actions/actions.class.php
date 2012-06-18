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
 * dna_extraction actions.
 *
 * @package ACM.Frontend
 * @subpackage dna_extraction
 */
class dna_extractionActions extends MyActions {
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'DnaExtraction', array('init' => false, 'sort_column' => 'Strain.code'));

		// Deal with search criteria
		if ( $text = $request->getParameter('criteria') ) {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Strain s")
				->leftJoin("{$this->mainAlias()}.ExtractionKit c")
				->leftJoin("{$this->mainAlias()}.Pcr p")
				->leftJoin("s.TaxonomicClass tc")
				->leftJoin("s.Genus g")
				->leftJoin("s.Species sp")
				->where("{$this->mainAlias()}.concentration = ?", $text)
				->orWhere("{$this->mainAlias()}.extraction_date LIKE ?", "%$text%")
				->orWhere('c.name LIKE ?', "%$text%")
				->orWhere('tc.name LIKE ?', "%$text%")
				->orWhere('g.name LIKE ?', "%$text%")
				->orWhere('sp.name LIKE ?', "%$text%");

			// Parse search term to catch extraction codes
			if ( preg_match('/([Bb][Ee][Aa])?(\d{1,4})[Bb]?/', $text, $matches) ) {
				$query = $query->orWhere("s.code = ?", (int)$matches[2]);
			}

			// Keep track of search terms for pagination
			$this->getUser()->setAttribute('search.criteria', $text);
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Strain s")
				->leftJoin("{$this->mainAlias()}.ExtractionKit k")
				->leftJoin("{$this->mainAlias()}.Pcr p")
				->leftJoin("s.TaxonomicClass tc")
				->leftJoin("s.Genus g")
				->leftJoin("s.Species sp");

			$this->getUser()->setAttribute('search.criteria', null);
		}

		// Simplify ORDER BY aliquots to yes/no values
		if ( $sort_column = $request->getParameter('sort_column') ) {
			if ( $sort_column === 'aliquots' ) {
				$query = $query->orderBy(sprintf('%s.aliquots>0 %s, s.code ASC', $this->mainAlias, $this->sortDirection));
			}
		}

		$this->pager->setQuery($query);
		$this->pager->init();

		// Keep track of the last page used in list
		$this->getUser()->setAttribute('dna_extraction.index_page', $request->getParameter('page'));

		// Add a form to filter results
		$this->form = new DnaExtractionForm();
	}

	public function executeShow(sfWebRequest $request) {
		$this->dnaExtraction = DnaExtractionTable::getInstance()->find(array($request->getParameter('id')));

		// Retrieve the PCR linked to this DNA extraction
		$this->pcrResults = $this->buildPagination($request, 'Pcr', array('init' => false, 'sort_column' => 'id'));
		$query = $this->pcrResults->getQuery()
			->leftJoin("{$this->mainAlias()}.DnaPolymerase")
			->leftJoin("{$this->mainAlias()}.ForwardPrimer")
			->leftJoin("{$this->mainAlias()}.ReversePrimer")
			->where("{$this->mainAlias()}.dna_extraction_id = ?", $this->dnaExtraction->getId());
		$this->pcrResults->setQuery($query);
		$this->pcrResults->init();

		$this->forward404Unless($this->dnaExtraction);
	}

	public function executeNew(sfWebRequest $request) {
		if ( $lastDnaExtraction = $this->getUser()->getAttribute('dna_extraction.last_object_created') ) {
			$dnaExtraction = new DnaExtraction();

			$dnaExtraction->setStrainId($lastDnaExtraction->getStrainId());
			$dnaExtraction->setExtractionKitId($lastDnaExtraction->getExtractionKitId());

			$this->form = new DnaExtractionForm($dnaExtraction);
			$this->getUser()->setAttribute('dna_extraction.last_object_created', null);
		}
		else {
			$this->form = new DnaExtractionForm();
		}

		$this->hasStrains = (Doctrine::getTable('Strain')->count() > 0)?true:false;
		$this->hasExtractionKits = (Doctrine::getTable('ExtractionKit')->count() > 0)?true:false;
		$this->aliquotsAreEditable = false;
	}

	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new DnaExtractionForm();
		$this->hasStrains = (Doctrine::getTable('Strain')->count() > 0)?true:false;
		$this->hasExtractionKits = (Doctrine::getTable('ExtractionKit')->count() > 0)?true:false;

		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($dna_extraction = DnaExtractionTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object dna extraction does not exist (%s).', $request->getParameter('id')));
		$this->form = new DnaExtractionForm($dna_extraction);

		$this->aliquotsAreEditable = $dna_extraction->aliquotsAreEditable();
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($dna_extraction = DnaExtractionTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object dna_extraction does not exist (%s).', $request->getParameter('id')));
		$this->form = new DnaExtractionForm($dna_extraction);

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
			$dnaExtraction = null;
			try {
				$dnaExtraction = $form->save();

				if ( $request->hasParameter('_save_and_add') ) {
					$message = 'DNA extraction created successfully. Now you can add another one';
					$url = '@dna_extraction_new';

					// Reuse last object values
					$this->getUser()->setAttribute('dna_extraction.last_object_created', $dnaExtraction);
				}
				elseif ( !$isNew ) {
					$message = 'Changes saved';
					$url = '@dna_extraction_show?id='.$dnaExtraction->getId();
				}
				else {
					$message = 'DNA extraction created successfully';
					$url = '@dna_extraction_show?id='.$dnaExtraction->getId();
				}
			}
			catch (Exception $e) {
				$message = $e->getMessage();
			}

			if ( $dnaExtraction != null ) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $dnaExtraction->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ( $url !== null ) {
					$this->redirect($url);
				}
			}
		}

		$this->getUser()->setFlash('notice', 'The information on this DNA extraction has some errors you need to fix', false);
	}

	/**
	 * Create labels for DnaExtraction records
	 *
	 * @param sfWebRequest $request Request information
	 * @return void
	 */
	public function executeCreateLabel(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::GET));
		$id = $request->getParameter('id');
		$this->forward404Unless($dnaExtraction = DnaExtractionTable::getInstance()->find(array($id)), sprintf('Object DNA extraction does not exist (%s).', $id));

		if ($request->isMethod(sfRequest::POST)) {
			$values = $request->getPostParameters();
			$this->label = $dnaExtraction;
			$this->copies = $values['copies'];

			$this->setLayout(false);
			$pdf = new WKPDF();
			$pdf->set_html($this->getPartial('create_pdf'));
			$pdf->set_orientation('Landscape');
			$pdf->render();
			$pdf->output(WKPDF::$PDF_DOWNLOAD, "dna_extraction_labels.pdf");
			throw new sfStopException();
		} else {
			$this->form = new DnaExtractionLabelForm($dnaExtraction);
			$this->dnaExtraction = $dnaExtraction;
		}
	}
}
