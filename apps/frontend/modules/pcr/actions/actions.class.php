<?php

/**
* pcr actions.
*
* @package    bna_green_house
* @subpackage pcr
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class pcrActions extends MyActions {

	public function executeShow(sfWebRequest $request) {
		$this->pcr = Doctrine_Core::getTable('Pcr')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->pcr);
	}

	public function executeNew(sfWebRequest $request) {
		$this->dnaExtraction = DnaExtractionTable::getInstance()->findOneById($request->getParameter('dna_extraction'));
		
		if ( $lastPcr = $this->getUser()->getAttribute('pcr.last_object_created') ) {
			$pcr = new Pcr();
			
			$pcr->setDnaExtractionId($lastPcr->getDnaExtractionId());
			$pcr->setDnaPolymeraseId($lastPcr->getDnaPolymeraseId());
			$pcr->setForwardDnaPrimerId($lastPcr->getForwardDnaPrimerId());
			$pcr->setReverseDnaPrimerId($lastPcr->getReverseDnaPrimerId());
			
			$this->form = new PcrForm($pcr);
			$this->getUser()->setAttribute('pcr.last_object_created', null);
		}
		else {
			$this->form = new PcrForm();
		}
		$this->form->setDefault('dna_extraction_id', $this->dnaExtraction->getId());
		
		$this->hasDnaPrimers = (Doctrine::getTable('DnaPrimer')->count() > 0)?true:false;
		$this->hasDnaPolymeraseKits = (Doctrine::getTable('DnaPolymerase')->count() > 0)?true:false;
	}

	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		
		$this->form = new PcrForm();
		$this->processForm($request, $this->form);
		
		$this->dnaExtraction = DnaExtractionTable::getInstance()->findOneById($request->getParameter('dna_extraction'));
		$this->hasDnaPrimers = (Doctrine::getTable('DnaPrimer')->count() > 0)?true:false;
		$this->hasDnaPolymeraseKits = (Doctrine::getTable('DnaPolymerase')->count() > 0)?true:false;

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($pcr = Doctrine_Core::getTable('Pcr')->find(array($request->getParameter('id'))), sprintf('Object PCR does not exist (%s).', $request->getParameter('id')));
		$this->form = new PcrForm($pcr);
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($pcr = Doctrine_Core::getTable('Pcr')->find(array($request->getParameter('id'))), sprintf('Object pcr does not exist (%s).', $request->getParameter('id')));
		$this->form = new PcrForm($pcr);

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
		$dnaExtractionId = $model->getDnaExtractionId();
		
		try {
			$model->delete();
			$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log'));
			$this->getUser()->setFlash('notice', "$moduleReadableName deleted successfully");
		}
		catch (Exception $e) {
			$this->getUser()->setFlash('notice', "This $moduleReadableNameLowercase cannot be deleted because it is being used in other records");
		}
		
		$this->redirect("@dna_extraction_show?id=$dnaExtractionId");
	}

	protected function processForm(sfWebRequest $request, sfForm $form) {
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		
		if ( $form->isValid() ) {
			$message = null;
			$url = null;
			$isNew = $form->getObject()->isNew();
						
			// Save object
			$pcr = null;
			try {
				$pcr = $form->save();
				if ( $request->hasParameter('_save_and_add') ) {
					$message = 'PCR test created successfully. Now you can add another one';
					$url = '@pcr_new?dna_extraction='.$pcr->getDnaExtractionId();
					
					// Reuse last object values
					$this->getUser()->setAttribute('pcr.last_object_created', $pcr);
				}
				elseif ( !$isNew ) {
					$message = 'Changes saved';
					$url = '@pcr_show?id='.$pcr->getId();
				}
				else {
					$message = 'PCR test created successfully';
					$url = '@pcr_show?id='.$pcr->getId();
				}
			}
			catch (Exception $e) {
				$message = $e->getMessage();
			}
			
			if ( $pcr != null ) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $pcr->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ( $url !== null ) {
					$this->redirect($url);
				}
			}
		}
		
		$this->getUser()->setFlash('notice', 'The information on this PCR test has some errors you need to fix', false);
	}
	
}
