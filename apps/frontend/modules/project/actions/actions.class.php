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
?>
<?php

/**
 * project actions
 *
 * @package ACM.Frontend
 * @subpackage project
 */
class projectActions extends MyActions {
	/**
	 * Index action
	 */
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'Project', array('init' => false, 'sort_column' => 'id'));
		$filters = $this->_processFilterConditions($request, 'project');

		$query = null;
		// Deal with search criteria
		if ( count($filters) ) {
			if (!empty($filters['group_by'])) {
				$query = ProjectTable::getInstance()->createQuery($this->mainAlias())->select("{$this->mainAlias()}.*");
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
					->addSelect("COUNT(DISTINCT {$this->mainAlias()}.id) as n_projects")
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
				->leftJoin("{$this->mainAlias()}.Sample sa")
				->leftJoin("{$this->mainAlias()}.ExternalStrain est")
				->leftJoin("st.TaxonomicClass tc")
				->leftJoin("st.Genus g")
				->leftJoin("st.Species sp")
				->leftJoin("est.TaxonomicClass etc")
				->leftJoin("est.Genus eg")
				->leftJoin("est.Species esp")
				->leftJoin("{$this->mainAlias()}.Provider pr")
				->leftJoin("{$this->mainAlias()}.Petitioner pe")
				->leftJoin("{$this->mainAlias()}.ProjectName pn")
				->where('1=1');

			if (!empty($filters['subject'])) {
				$this->filters['Subject'] = $filters['subject'];
				$query = $query->andWhere("{$this->mainAlias()}.subject LIKE ?", sprintf('%%%s%%', $filters['subject']));
			}

			foreach (array('project_name_id', 'petitioner_id') as $filter) {
				if (!empty($filters[$filter])) {
					$query = $query->andWhere("{$this->mainAlias()}.$filter = ?", $filters[$filter]);

					$table = sprintf('%sTable', sfInflector::camelize(str_replace('_id', '', $filter)));
					if ($filter === 'petitioner_id') {
						$table = 'PetitionersTable';
					}
					$table = call_user_func(array($table, 'getInstance'));
					$this->filters[$filter] = $table->find($filters[$filter])->getName();
				}
			}

			if (!empty($filters['id'])) {
				$this->filters['Code'] = $filters['id'];
				preg_match('/^[Bb]?[Ee]?[Aa]?\s*(\d{1,4})(\w+_\d{1,5}|\s*[bB])?.*$/', $filters['id'], $matches);
				$query = $query->andWhere("(st.code = ? OR est.id = ? OR sa.id = ?)", array($matches[1], $matches[1], $matches[1]));
			}
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Strain s")
				->leftJoin("{$this->mainAlias()}.ExternalStrain est")
				->leftJoin("{$this->mainAlias()}.Provider pr")
				->leftJoin("{$this->mainAlias()}.Petitioner pe")
				->leftJoin("{$this->mainAlias()}.ProjectName pn")
				->leftJoin("s.TaxonomicClass tc")
				->leftJoin("s.Genus g")
				->leftJoin("s.Species sp")
				->leftJoin("est.TaxonomicClass etc")
				->leftJoin("est.Genus eg")
				->leftJoin("est.Species esp");
		}

		if (empty($filters['group_by'])) {
			$this->pager->setQuery($query);
			$this->pager->init();
			$this->results = $this->pager->getResults();
		} else {
			$this->results = $query->execute();
		}

		// Keep track of the last page used in list
		$this->getUser()->setAttribute('project.index_page', $request->getParameter('page'));

		// Add a form to filter results
		$this->form = new ProjectForm(array(), array('search' => true));
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
			unset($form['external_strain_id']);
			break;

		case 'external_strain':
			unset($form['sample_id']);
			unset($form['strain_id']);
			break;

		case 'sample':
		default:
			unset($form['strain_id']);
			unset($form['external_strain_id']);
			break;
		}
	}

	public function executeNew(sfWebRequest $request) {
		if ( $lastProject = $this->getUser()->getAttribute('project.last_object_created') ) {
			$project = new Project();

			$project->setProjectNameId($lastProject->getProjectNameId());
			$project->setStrainId($lastProject->getStrainId());
			$project->setExternalStrainId($lastProject->getExternalStrainId());
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

		$this->hasExternalStrains = (ExternalStrainTable::getInstance()->count() > 0)?true:false;
		$this->hasStrains = (StrainTable::getInstance()->count() > 0)?true:false;
		$this->hasSamples = (SampleTable::getInstance()->count() > 0)?true:false;
		$this->hasProjectNames = (ProjectNameTable::getInstance()->count() > 0)?true:false;
	}

	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new ProjectForm();
		$project = $request->getParameter('project');
		$this->configureFormByProjectSubject($this->form, $project['subject']);
		$this->hasExternalStrains = (ExternalStrainTable::getInstance()->count() > 0)?true:false;
		$this->hasStrains = (StrainTable::getInstance()->count() > 0)?true:false;
		$this->hasSamples = (SampleTable::getInstance()->count() > 0)?true:false;
		$this->hasProjectNames = (ProjectNameTable::getInstance()->count() > 0)?true:false;

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
