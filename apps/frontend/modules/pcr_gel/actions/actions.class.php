<?php

/**
* pcr_gel actions.
*
* @package    bna_green_house
* @subpackage pcr_gel
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class pcr_gelActions extends MyActions {

	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($pcr_gel = Doctrine_Core::getTable('PcrGel')->find(array($request->getParameter('id'))), sprintf('Object pcr_gel does not exist (%s).', $request->getParameter('id')));
		$this->form = new PcrGelForm($pcr_gel);
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($pcr_gel = Doctrine_Core::getTable('PcrGel')->find(array($request->getParameter('id'))), sprintf('Object pcr_gel does not exist (%s).', $request->getParameter('id')));
		$this->form = new PcrGelForm($pcr_gel);

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
			$gel = null;
			try {
				$gel = $form->save();
				$message = 'Changes saved';
				$url = '@pcr_show?id='.$gel->getPcrId();
			}
			catch (Exception $e) {
				$message = $e->getMessage();
			}
			
			if ( $gel != null ) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $gel->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ( $url !== null ) {
					$this->redirect($url);
				}
			}
		}
		
		$this->getUser()->setFlash('notice', 'The information on this gel has some errors you need to fix', false);
	}

}
