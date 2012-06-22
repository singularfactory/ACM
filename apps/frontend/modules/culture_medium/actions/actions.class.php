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
 * culture_medium actions.
 *
 * @package ACM.Frontend
 * @subpackage culture_medium
 */
class culture_mediumActions extends MyActions {

	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'CultureMedium', array('init' => false, 'sort_column' => 'id'));

		// Deal with search criteria
		if ( $text = $request->getParameter('criteria') ) {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Strains s")
				->where("{$this->mainAlias()}.name LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.description LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.link LIKE ?", "%$text%");

			// Keep track of search terms for pagination
			$this->getUser()->setAttribute('search.criteria', $text);
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Strains s");

			$this->getUser()->setAttribute('search.criteria', null);
		}

		$this->pager->setQuery($query);
		$this->pager->init();

		// Keep track of the last page used in list
		$this->getUser()->setAttribute('culture_medium.index_page', $request->getParameter('page'));

		// Add a form to filter results
		$this->form = new CultureMediumForm();
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
