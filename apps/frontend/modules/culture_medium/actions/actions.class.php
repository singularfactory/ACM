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
 * culture_medium actions
 *
 * @package ACM.Frontend
 * @subpackage culture_medium
 * @version 1.2
 */
class culture_mediumActions extends MyActions {
	/**
	 * Index action
	 */
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'CultureMedium', array('init' => false, 'sort_column' => 'id'));
		$filters = $this->_processFilterConditions($request, 'culture_medium');

		$query = null;
		if (count($filters)) {
			if (!empty($filters['group_by'])) {
				$query = CultureMediumTable::getInstance()->createQuery($this->mainAlias())->select("{$this->mainAlias()}.*");
				$this->groupBy = $filters['group_by'];

				if (in_array($this->groupBy, array('is_public'))) {
					$relatedAlias = $this->groupBy;
					$relatedForeignKey = $this->groupBy;
					$query = $query
					->addSelect("COUNT(DISTINCT {$this->mainAlias()}.id) as n_culture_media")
					->groupBy("{$this->mainAlias()}.$relatedForeignKey")
					->addSelect("{$this->mainAlias()}.$relatedAlias as value");
				}
			} else {
				$query = $this->pager->getQuery();
			}

			$query = $query->leftJoin("{$this->mainAlias()}.Strains s")->where('1=1');
			if (!empty($filters['is_public']) && $filters['is_public'] > 0) {
				$this->filters['Public'] = ($filters['is_public'] == 1) ? 'no' : 'yes';
				$query = $query->andWhere("{$this->mainAlias()}.is_public = ?", ($filters['is_public'] == 1) ? 0 : 1);
			}

			if (!empty($filters['name'])) {
				$this->filters['Name'] = $filters['name'];
				$query = $query->andWhere("{$this->mainAlias()}.name LIKE ?", sprintf('%%%s%%', $filters['name']));
			}

			if (!empty($filters['id'])) {
				$this->filters['Code'] = $filters['id'];
				preg_match('/^[Bb]?[Ee]?[Aa]?\s*(\d{1,4})\s*\-?\s*[cC]?\s*[mM]?\s*$/', $filters['id'], $matches);
				$query = $query->andWhere("{$this->mainAlias()}.id = ?", $matches[1]);
			}
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Strains s");
		}

		if (empty($filters['group_by'])) {
			$this->pager->setQuery($query);
			$this->pager->init();
			$this->results = $this->pager->getResults();
		} else {
			$this->results = $query->execute();
		}

		// Keep track of the last page used in list
		$this->getUser()->setAttribute('culture_medium.index_page', $request->getParameter('page'));

		// Add a form to filter results
		$this->form = new CultureMediumForm(array(), array('search' => true));
	}

	public function executeShow(sfWebRequest $request) {
		$this->cultureMedium = Doctrine_Core::getTable('CultureMedium')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->cultureMedium);
	}

	public function executeNew(sfWebRequest $request) {
		$this->form = new CultureMediumForm();
	}

	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new CultureMediumForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($culture_medium = Doctrine_Core::getTable('CultureMedium')->find(array($request->getParameter('id'))), sprintf('Object culture_medium does not exist (%s).', $request->getParameter('id')));
		$this->form = new CultureMediumForm($culture_medium);
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($culture_medium = Doctrine_Core::getTable('CultureMedium')->find(array($request->getParameter('id'))), sprintf('Object culture_medium does not exist (%s).', $request->getParameter('id')));
		$this->form = new CultureMediumForm($culture_medium);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	protected function processForm(sfWebRequest $request, sfForm $form) {
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

		if ($form->isValid()) {
			$flashMessage = null;
			$url = null;
			$isNew = $form->getObject()->isNew();

			$cultureMedium = null;
			try {
				$cultureMedium = $form->save();

				if ( $request->hasParameter('_save_and_add') ) {
					$message = 'Culture medium created successfully. Now you can add another one';
					$url = '@culture_medium_new';

					// Reuse last object values
					$this->getUser()->setAttribute('culture_medium.last_object_created', $cultureMedium);
				}
				elseif ( !$isNew ) {
					$message = 'Changes saved';
					$url = '@culture_medium_show?id='.$cultureMedium->getId();
				}
				else {
					$message = 'Culture medium created successfully';
					$url = '@culture_medium_show?id='.$cultureMedium->getId();
				}
			}
			catch (Exception $e) {
				$message = $e->getMessage();
			}

			if ( $cultureMedium != null ) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $cultureMedium->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ( $url !== null ) {
					$this->redirect($url);
				}
			}
		}

		$this->getUser()->setFlash('notice', 'The information on this culture medium has some errors you need to fix', false);
	}

}
