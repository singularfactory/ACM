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
				->leftJoin("{$this->mainAlias()}.Strain st")
				->leftJoin("{$this->mainAlias()}.Sample sa")
				->leftJoin("st.TaxonomicClass tc")
				->leftJoin("st.Genus g")
				->leftJoin("st.Species sp")
				->leftJoin("{$this->mainAlias()}.Provider pr")
				->leftJoin("{$this->mainAlias()}.Petitioner pe")
				->leftJoin("{$this->mainAlias()}.ProjectName pn")
				->where("{$this->mainAlias()}.id LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.amount LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.remarks LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.purpose LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.inoculation_date LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.delivery_date LIKE ?", "%$text%")
				->orWhere('tc.name LIKE ?', "%$text%")
				->orWhere('g.name LIKE ?', "%$text%")
				->orWhere('sp.name LIKE ?', "%$text%")
				->orWhere('st.id LIKE ?', "%$text%")
				->orWhere('sa.id LIKE ?', "%$text%")
				->orWhere('pr.first_name LIKE ?', "%$text%")
				->orWhere('pr.last_name LIKE ?', "%$text%")
				->orWhere('pe.first_name LIKE ?', "%$text%")
				->orWhere('pe.last_name LIKE ?', "%$text%")
				->orWhere('pn.name LIKE ?', "%$text%");
						
			// Keep track of search terms for pagination
			$this->getUser()->setAttribute('search.criteria', $text);
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Strain s")
				->leftJoin("{$this->mainAlias()}.Provider pr")
				->leftJoin("{$this->mainAlias()}.Petitioner pe")
				->leftJoin("s.TaxonomicClass tc")
				->leftJoin("s.Genus g")
				->leftJoin("s.Species sp")
				->leftJoin("{$this->mainAlias()}.ProjectName pn");
			
			$this->getUser()->setAttribute('search.criteria', null);
		}
		$this->pager->setQuery($query);
		$this->pager->init();
		
		// Keep track of the last page used in list
		$this->getUser()->setAttribute('project.index_page', $request->getParameter('page'));
		
		// Add a form to filter results
		$this->form = new ProjectForm();
	}
		
	public function executeShow(sfWebRequest $request) {
		$this->project = ProjectTable::getInstance()->find(array($request->getParameter('id')));
		$this->forward404Unless($this->project);
	}
	
	protected function configureFormByProjectSubject(sfForm $form, $subject = 'sample') {
		$form->setDefault('subject', $subject);
		switch( $subject ) {
			case 'strain':
				unset($form['sample_id']);
				break;
				
			case 'sample':
			default:
				unset($form['strain_id']);
				break;
		}
	}
	
	public function executeNew(sfWebRequest $request) {
		if ( $lastProject = $this->getUser()->getAttribute('project.last_object_created') ) {
			$project = new Project();
			
			$project->setProjectNameId($lastProject->getProjectNameId());
			$project->setStrainId($lastProject->getStrainId());
			$project->setSampleId($lastProject->getSampleId());
			$project->setPetitionerId($lastProject->getPetitionerId());
			
			$this->form = new ProjectForm($project);
			$this->getUser()->setAttribute('project.last_object_created', null);
		}
		else {
			$this->form = new ProjectForm();
		}
		
		if ( $subject = $request->getParameter('subject') ) {
			$this->configureFormByProjectSubject($this->form, $subject);
		}
		else {
			$this->configureFormByProjectSubject($this->form);
		}
		
		$this->hasStrains = (StrainTable::getInstance()->count() > 0)?true:false;
		$this->hasSamples = (SampleTable::getInstance()->count() > 0)?true:false;
	}
	
	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new ProjectForm();
		$project = $request->getParameter('project');
		$this->configureFormByProjectSubject($this->form, $project['subject']);
		$this->hasStrains = (StrainTable::getInstance()->count() > 0)?true:false;
		$this->hasSamples = (SampleTable::getInstance()->count() > 0)?true:false;
		
		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}
	
	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($project = ProjectTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object project does not exist (%s).', $request->getParameter('id')));
		$this->form = new ProjectForm($project);
		
		if ( $subject = $request->getParameter('subject') ) {
			$this->configureFormByProjectSubject($this->form, $subject);
		}
		else {
			$this->configureFormByProjectSubject($this->form, $project->getSubject());
		}
	}
	
	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($project = ProjectTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object project does not exist (%s).', $request->getParameter('id')));
		
		$this->form = new ProjectForm($project);
		$project = $request->getParameter('project');
		$this->configureFormByProjectSubject($this->form, $project['subject']);
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
