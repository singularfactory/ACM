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
 * @since         1.2
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */

/**
 * potential_usage actions
 *
 * @package    ACM
 * @subpackage potential_usage
 * @version    1.2
 */
class potential_usageActions extends MyActions {
	/**
	 * Index action
	 */
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'StrainTaxonomy', array('init' => false, 'sort_column' => 'TaxonomicClass.name'));
		$filters = $this->_processFilterConditions($request, 'strain_taxonomy');

		$query = null;
		if (count($filters)) {
			if (!empty($filters['group_by'])) {
				$query = StrainTaxonomyTable::getInstance()->createQuery($this->mainAlias())->select("{$this->mainAlias()}.*");
				$this->groupBy = $filters['group_by'];

				$relatedAlias = sfInflector::camelize($this->groupBy);
				$relatedForeignKey = sfInflector::foreign_key($this->groupBy);
				$recursive = true;

				$query = $query
					->addSelect("COUNT(DISTINCT {$this->mainAlias()}.id) as n_potential_applications")
					->addSelect('m.name as value')
					->groupBy("{$this->mainAlias()}.$relatedForeignKey")
					->innerJoin("{$this->mainAlias()}.$relatedAlias m");
			} else {
				$query = $this->pager->getQuery();
			}

			$query = $query
				->leftJoin("{$this->mainAlias()}.TaxonomicClass c")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species sp")
				->where('1=1');

			foreach (array('taxonomic_class_id', 'genus_id', 'species_id') as $filter) {
				if (!empty($filters[$filter])) {
					$query = $query->andWhere("{$this->mainAlias()}.$filter = ?", $filters[$filter]);

					$table = sprintf('%sTable', sfInflector::camelize(str_replace('_id', '', $filter)));
					$table = call_user_func(array($table, 'getInstance'));
					$this->filters[$filter] = $table->find($filters[$filter])->getName();
				}
			}
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.TaxonomicClass c")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species sp");
		}

		if (empty($filters['group_by'])) {
			$this->pager->setQuery($query);
			$this->pager->init();
			$this->results = $this->pager->getResults();
		} else {
			$this->results = $query->execute();
		}


		// Keep track of the last page used in list
		$this->getUser()->setAttribute('potential_usage.index_page', $request->getParameter('page'));

		// Add a form to filter results
		$this->form = new StrainTaxonomyForm(array(), array('search' => true));
	}

	/**
	 * Show action
	 */
	public function executeShow(sfWebRequest $request) {
		$this->strainTaxonomy = StrainTaxonomyTable::getInstance()->find(array($request->getParameter('id')));
		$this->forward404Unless($this->strainTaxonomy);
	}

	/**
	 * New action
	 */
	public function executeNew(sfWebRequest $request) {
		$this->form = new StrainTaxonomyForm();
		$this->hasTaxonomicClasses = (TaxonomicClassTable::getInstance()->count() > 0) ? true : false;
		$this->hasGenus = (GenusTable::getInstance()->count() > 0) ? true : false;
		$this->hasSpecies = (SpeciesTable::getInstance()->count() > 0) ? true : false;
		$this->usageAreas = UsageAreaTable::getInstance()->createQuery('a')->execute();
	}

	/**
	 * Create action
	 */
	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		$this->form = new StrainTaxonomyForm();
		$this->processForm($request, $this->form);
		$this->hasTaxonomicClasses = (TaxonomicClassTable::getInstance()->count() > 0) ? true : false;
		$this->hasGenus = (GenusTable::getInstance()->count() > 0) ? true : false;
		$this->hasSpecies = (SpeciesTable::getInstance()->count() > 0) ? true : false;
		$this->usageAreas = UsageAreaTable::getInstance()->createQuery('a')->execute();
		$this->setTemplate('new');
	}

	/**
	 * Edit action
	 */
	public function executeEdit(sfWebRequest $request) {
		$id = $request->getParameter('id');
		$this->forward404Unless($strainTaxonomy = StrainTaxonomyTable::getInstance()->find(array($id)), sprintf('Object strain taxonomy does not exist (%s).', $id));
		$this->form = new StrainTaxonomyForm($strainTaxonomy);
		$this->hasTaxonomicClasses = (TaxonomicClassTable::getInstance()->count() > 0) ? true : false;
		$this->hasGenus = (GenusTable::getInstance()->count() > 0) ? true : false;
		$this->hasSpecies = (SpeciesTable::getInstance()->count() > 0) ? true : false;
		$this->usageAreas = UsageAreaTable::getInstance()->createQuery('a')->execute();
	}

	/**
	 * Update action
	 */
	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$id = $request->getParameter('id');
		$this->forward404Unless($strainTaxonomy = StrainTaxonomyTable::getInstance()->find(array($id)), sprintf('Object strain taxonomy does not exist (%s).', $id));
		$this->form = new StrainTaxonomyForm($strainTaxonomy);

		$this->processForm($request, $this->form);
		$this->setTemplate('edit');
	}

	/**
	 * Delete action
	 */
	public function executeDelete(sfWebRequest $request) {
		$request->checkCSRFProtection();

		$id = $request->getParameter('id');
		$this->forward404Unless($model = StrainTaxonomyTable::getInstance()->find(array($id)), sprintf('Object does not exist (%s)', $id));

		try {
			$model->delete();
			$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log'));
			$this->getUser()->setFlash('notice', "Potential applications deleted successfully");
		}
		catch (Exception $e) {
			$this->getUser()->setFlash('notice', "These potential applications cannot be deleted because they are being used in other records");
		}

		$this->redirect("@potential_usage");
	}

	/**
	 * Processes form
	 */
	protected function processForm(sfWebRequest $request, sfForm $form) {
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid()) {
			$message = null;
			$url = null;
			$strainTaxonomy = null;
			try {
				$strainTaxonomy = $form->save();
				if (!$form->getObject()->isNew()) {
					$message = 'Changes saved';
					$url = '@potential_usage_show?id='.$strainTaxonomy->getId();
				}
				else {
					$message = 'Potential usage added successfully';
					$url = '@potential_usage_show?id='.$strainTaxonomy->getId();
				}
			} catch (Exception $e) {
				$message = $e->getMessage();
			}

			if ($strainTaxonomy != null) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $strainTaxonomy->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ( $url !== null ) {
					$this->redirect($url);
				}
			}
		} else {
			$this->getUser()->setFlash('notice', "The information on this potential usage has some errors you need to fix", false);
		}
	}
}
