<?php

/**
* project actions.
*
* @package    bna_green_house
* @subpackage project
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class projectActions extends MyActions {
	
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'Project', array('init' => false, 'sort_column' => 'id'));
		
		// Deal with search criteria
		if ( $text = $request->getParameter('criteria') ) {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Strain s")
				->leftJoin("s.TaxonomicClass tc")
				->leftJoin("s.Genus g")
				->leftJoin("s.Species sp")
				->leftJoin("{$this->mainAlias()}.Provider p")
				->where("{$this->mainAlias()}.id LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.amount LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.remarks LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.purpose LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.inoculation_date LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.delivery_date LIKE ?", "%$text%")
				->orWhere('tc.name LIKE ?', "%$text%")
				->orWhere('g.name LIKE ?', "%$text%")
				->orWhere('sp.name LIKE ?', "%$text%")
				->orWhere('s.id LIKE ?', "%$text%")
				->orWhere('p.first_name LIKE ?', "%$text%")
				->orWhere('p.last_name LIKE ?', "%$text%");
						
			// Keep track of search terms for pagination
			$this->getUser()->setAttribute('search.criteria', $text);
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Strain s")
				->leftJoin("{$this->mainAlias()}.Provider p")
				->leftJoin("s.TaxonomicClass tc")
				->leftJoin("s.Genus g")
				->leftJoin("s.Species sp");
			
			$this->getUser()->setAttribute('search.criteria', null);
		}
		$this->pager->setQuery($query);
		$this->pager->init();
		
		// Keep track of the last page used in list
		$this->getUser()->setAttribute('project.index_page', $request->getParameter('page'));
		
		// Add a form to filter results
		$this->form = new ProjectForm();
	}
	
	/**
	 * Find the strains that matches a search term when creating or editing a project
	 *
	 * @param sfWebRequest $request 
	 * @return JSON object with strain id and number
	 * @author Eliezer Talon
	 * @version 2011-10-13
	*/
	public function executeFindStrains(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$results = Doctrine_Core::getTable('Strain')->findByTerm($request->getParameter('term'));
			$strains = array();
			foreach ($results as $strain) {
				$strains[] = array(
					'id' => $strain->getId(),
					'label' => $strain->getCode(),	// This attribute must be named label due to the jQuery Autocomplete plugin
				);
			}
			$this->getResponse()->setContent(json_encode($strains));
		}
		return sfView::NONE;
	}
	
	public function executeShow(sfWebRequest $request) {
		$this->project = ProjectTable::getInstance()->find(array($request->getParameter('id')));
		$this->forward404Unless($this->project);
	}
	
	public function executeNew(sfWebRequest $request) {
		if ( $lastProject = $this->getUser()->getAttribute('project.last_object_created') ) {
			$project = new Project();
			
			$project->setStrainId($lastProject->getStrainId());
			
			$this->form = new ProjectForm($project);
			$this->getUser()->setAttribute('project.last_object_created', null);
		}
		else {
			$this->form = new ProjectForm();
		}
		
		$this->hasStrains = (StrainTable::getInstance()->count() > 0)?true:false;
	}
	
	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new ProjectForm();
		$this->hasStrains = (StrainTable::getInstance()->count() > 0)?true:false;
		
		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}
	
	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($project = ProjectTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object project does not exist (%s).', $request->getParameter('id')));
		$this->form = new ProjectForm($project);
	}
	
	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($project = ProjectTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object project does not exist (%s).', $request->getParameter('id')));
		$this->form = new ProjectForm($project);

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
			$project = null;
			try {
				$project = $form->save();
				
				if ( $request->hasParameter('_save_and_add') ) {
					$message = 'Project created successfully. Now you can add another one';
					$url = '@project_new';
					
					// Reuse last object values
					$this->getUser()->setAttribute('project.last_object_created', $project);
				}
				elseif ( !$isNew ) {
					$message = 'Changes saved';
					$url = '@project_show?id='.$project->getId();
				}
				else {
					$message = 'Project created successfully';
					$url = '@project_show?id='.$project->getId();
				}
			}
			catch (Exception $e) {
				$message = $e->getMessage();
			}
			
			if ( $project != null ) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $project->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ( $url !== null ) {
					$this->redirect($url);
				}
			}
		}
		
		$this->getUser()->setFlash('notice', 'The information on this project has some errors you need to fix', false);
	}
	
}
