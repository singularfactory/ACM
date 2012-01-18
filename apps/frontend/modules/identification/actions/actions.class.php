<?php

/**
* identification actions.
*
* @package    bna_green_house
* @subpackage identification
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class identificationActions extends MyActions {

	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'Identification', array('init' => false, 'sort_column' => 'id'));
		
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

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$identification = $form->save();

			$this->redirect('identification/edit?id='.$identification->getId());
		}
	}
}
