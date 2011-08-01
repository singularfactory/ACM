<?php

/**
* dna_extraction actions.
*
* @package    bna_green_house
* @subpackage dna_extraction
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class dna_extractionActions extends MyActions {
	
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'DnaExtraction', array('init' => false, 'sort_column' => 'id'));
		
		// Deal with search criteria
		if ( $text = $request->getParameter('criteria') ) {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Strain s")
				->leftJoin("s.TaxonomicClass tc")
				->leftJoin("s.Genus g")
				->leftJoin("s.Species sp")
				->leftJoin("{$this->mainAlias()}.ExtractionKit c")
				->where("{$this->mainAlias()}.id LIKE ?", "%$text%")
				->orWhere('tc.name LIKE ?', "%$text%")
				->orWhere('g.name LIKE ?', "%$text%")
				->orWhere('sp.name LIKE ?', "%$text%")
				->orWhere('s.id LIKE ?', "%$text%")
				->orWhere('k.name LIKE ?', "%$text%");
						
			// Parse search term to catch extraction codes
			if ( preg_match('/([Bb][Ee][Aa])?(\d{1,4})[Bb]?/', $text, $matches) ) {
				$query = $query->orWhere("{$this->mainAlias()}.id = ?", (int)$matches[2]);
			}
			
			// Keep track of search terms for pagination
			$this->getUser()->setAttribute('search.criteria', $text);
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Strain s")
				->leftJoin("{$this->mainAlias()}.ExtractionKit k")
				->leftJoin("s.TaxonomicClass tc")
				->leftJoin("s.Genus g")
				->leftJoin("s.Species sp");
			
			$this->getUser()->setAttribute('search.criteria', null);
		}
		$this->pager->setQuery($query);
		$this->pager->init();
		
		// Keep track of the last page used in list
		$this->getUser()->setAttribute('dna_extraction.index_page', $request->getParameter('page'));
		
		// Add a form to filter results
		$this->form = new DnaExtractionForm();
	}
	
	/**
	 * Find the strains that matches a search term when creating or editing a dna extraction
	 *
	 * @param sfWebRequest $request 
	 * @return JSON object with strain id and number
	 * @author Eliezer Talon
	 * @version 2011-07-07
	*/
	public function executeFindStrains(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$results = Doctrine_Core::getTable('Strain')->findByTerm($request->getParameter('term'));
			$strains = array();
			foreach ($results as $strain) {
				$strains[] = array(
					'id' => $strain->getId(),
					'label' => $strain->getNumber(),	// This attribute must be named label due to the jQuery Autocomplete plugin
				);
			}
			$this->getResponse()->setContent(json_encode($strains));
		}
		return sfView::NONE;
	}
	
	public function executeShow(sfWebRequest $request) {
		$this->dnaExtraction = Doctrine_Core::getTable('DnaExtraction')->find(array($request->getParameter('id')));
		
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
		$this->forward404Unless($dna_extraction = Doctrine_Core::getTable('DnaExtraction')->find(array($request->getParameter('id'))), sprintf('Object dna extraction does not exist (%s).', $request->getParameter('id')));
		$this->form = new DnaExtractionForm($dna_extraction);
		
		$this->aliquotsAreEditable = $dna_extraction->aliquotsAreEditable();
	}
	
	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($dna_extraction = Doctrine_Core::getTable('DnaExtraction')->find(array($request->getParameter('id'))), sprintf('Object dna_extraction does not exist (%s).', $request->getParameter('id')));
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
}
