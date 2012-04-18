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
 * pcr_reaction actions.
 *
 * @package ACM.Frontend
 * @subpackage pcr_reaction
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pcr_reactionActions extends MyActions {

	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($pcr_reaction = Doctrine_Core::getTable('PcrReaction')->find(array($request->getParameter('id'))), sprintf('Object pcr_reaction does not exist (%s).', $request->getParameter('id')));
		$this->form = new PcrReactionForm($pcr_reaction);
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($pcr_reaction = Doctrine_Core::getTable('PcrReaction')->find(array($request->getParameter('id'))), sprintf('Object pcr_reaction does not exist (%s).', $request->getParameter('id')));
		$this->form = new PcrReactionForm($pcr_reaction);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request) {
		$request->checkCSRFProtection();

		$id = $request->getParameter('id');
		$module = $this->request->getParameter('module');
		$moduleReadableName = sfInflector::humanize($module);
		$moduleReadableNameLowercase = str_replace('_', ' ', $module);

		$this->forward404Unless($model = Doctrine_Core::getTable(sfInflector::camelize($module))->find(array($id)), sprintf('Object does not exist (%s).', $id));
		$pcrId = $model->getPcrId();

		try {
			$model->delete();
			$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log'));
			$this->getUser()->setFlash('notice', "$moduleReadableName deleted successfully");
		}
		catch (Exception $e) {
			$this->getUser()->setFlash('notice', "This $moduleReadableNameLowercase cannot be deleted because it is being used in other records");
		}

		$this->redirect("@pcr_show?id=$pcrId");
	}

	protected function processForm(sfWebRequest $request, sfForm $form) {
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

		if ( $form->isValid() ) {
			$message = null;
			$url = null;
			$isNew = $form->getObject()->isNew();

			// Save object
			$reaction = null;
			try {
				$reaction = $form->save();
				$message = 'Changes saved';
				$url = '@pcr_show?id='.$reaction->getPcrId();
			}
			catch (Exception $e) {
				$message = $e->getMessage();
			}

			if ( $reaction != null ) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $reaction->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ( $url !== null ) {
					$this->redirect($url);
				}
			}
		}

		$this->getUser()->setFlash('notice', 'The information on this reaction has some errors you need to fix', false);

	}
}
