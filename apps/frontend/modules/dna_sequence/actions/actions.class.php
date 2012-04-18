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
 * dna_sequence actions.
 *
 * @package ACM.Frontend
 * @subpackage dna_sequence
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dna_sequenceActions extends MyActions {

	public function executeShow(sfWebRequest $request) {
		$this->dnaSequence = Doctrine_Core::getTable('DnaSequence')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->dnaSequence);
	}

	public function executeNew(sfWebRequest $request) {
		$this->pcr = PcrTable::getInstance()->findOneById($request->getParameter('pcr'));

		if ( $lastDnaSequence = $this->getUser()->getAttribute('dna_sequence.last_object_created') ) {
			$dnaSequence = new DnaSequence();

			$dnaSequence->setGen($lastDnaSequence->getGen());
			$dnaSequence->setDate($lastDnaSequence->getDate());
			$dnaSequence->setWorked($lastDnaSequence->getWorked());

			$this->form = new DnaSequenceForm($pcr);
			$this->getUser()->setAttribute('dna_sequence.last_object_created', null);
		}
		else {
			$this->form = new DnaSequenceForm();
		}
		$this->form->setDefault('pcr_id', $this->pcr->getId());
	}

	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new DnaSequenceForm();
		$this->processForm($request, $this->form);

		$this->pcr = PcrTable::getInstance()->findOneById($request->getParameter('pcr'));

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($dna_sequence = Doctrine_Core::getTable('DnaSequence')->find(array($request->getParameter('id'))), sprintf('Object dna_sequence does not exist (%s).', $request->getParameter('id')));
		$this->form = new DnaSequenceForm($dna_sequence);
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($dna_sequence = Doctrine_Core::getTable('DnaSequence')->find(array($request->getParameter('id'))), sprintf('Object dna_sequence does not exist (%s).', $request->getParameter('id')));
		$this->form = new DnaSequenceForm($dna_sequence);

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
			$dnaSequence = null;
			try {
				$dnaSequence = $form->save();
				if ( $request->hasParameter('_save_and_add') ) {
					$message = 'DNA sequence registered successfully. Now you can add another one';
					$url = '@dna_sequence_new?pcr='.$dnaSequence->getPcrId();

					// Reuse last object values
					$this->getUser()->setAttribute('dna_sequence.last_object_created', $dnaSequence);
				}
				elseif ( !$isNew ) {
					$message = 'Changes saved';
					$url = '@pcr_show?id='.$dnaSequence->getPcrId();
				}
				else {
					$message = 'DNA sequence registered successfully';
					$url = '@pcr_show?id='.$dnaSequence->getPcrId();
				}
			}
			catch (Exception $e) {
				$message = $e->getMessage();
			}

			if ( $dnaSequence != null ) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $dnaSequence->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ( $url !== null ) {
					$this->redirect($url);
				}
			}
		}

		$this->getUser()->setFlash('notice', 'The information on this DNA sequence has some errors you need to fix', false);
	}

}
