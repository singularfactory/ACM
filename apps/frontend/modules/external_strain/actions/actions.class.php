<?php

/**
* external_strain actions.
*
* @package    bna_green_house
* @subpackage external_strain
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class external_strainActions extends MyActions {
	public function executeIndex(sfWebRequest $request) {
		$this->external_strains = Doctrine_Core::getTable('ExternalStrain')
			->createQuery('a')
			->execute();
	}

	public function executeShow(sfWebRequest $request) {
		$this->external_strain = Doctrine_Core::getTable('ExternalStrain')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->external_strain);
	}

	public function executeNew(sfWebRequest $request) {
		$this->form = new ExternalStrainForm();
	}

	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new ExternalStrainForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($external_strain = Doctrine_Core::getTable('ExternalStrain')->find(array($request->getParameter('id'))), sprintf('Object external_strain does not exist (%s).', $request->getParameter('id')));
		$this->form = new ExternalStrainForm($external_strain);
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($external_strain = Doctrine_Core::getTable('ExternalStrain')->find(array($request->getParameter('id'))), sprintf('Object external_strain does not exist (%s).', $request->getParameter('id')));
		$this->form = new ExternalStrainForm($external_strain);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request) {
		$request->checkCSRFProtection();

		$this->forward404Unless($external_strain = Doctrine_Core::getTable('ExternalStrain')->find(array($request->getParameter('id'))), sprintf('Object external_strain does not exist (%s).', $request->getParameter('id')));
		$external_strain->delete();

		$this->redirect('external_strain/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form) {
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$external_strain = $form->save();

			$this->redirect('external_strain/edit?id='.$external_strain->getId());
		}
	}
}
