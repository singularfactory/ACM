<?php

/**
* identification actions.
*
* @package    bna_green_house
* @subpackage identification
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class identificationActions extends MyActions {
	public function executeIndex(sfWebRequest $request) {
		$this->identifications = Doctrine_Core::getTable('Identification')
			->createQuery('a')
			->execute();
	}

	public function executeShow(sfWebRequest $request) {
		$this->identification = Doctrine_Core::getTable('Identification')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->identification);
	}

	public function executeNew(sfWebRequest $request) {
		if ( $lastIdentification = $this->getUser()->getAttribute('identification.last_object_created') ) {
			$identification = new Identification();
			$identification->setSampleId($lastIdentification->getSampleId());

			$this->form = new identificationForm($identification);
			$this->getUser()->setAttribute('identification.last_object_created', null);
		}
		else {
			$this->form = new IdentificationForm();
		}
		
		$this->hasSamples = (SampleTable::getInstance()->count() > 0)?true:false;
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new IdentificationForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($identification = IdentificationTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object identification does not exist (%s).', $request->getParameter('id')));
		$this->form = new IdentificationForm($identification);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($identification = Doctrine_Core::getTable('Identification')->find(array($request->getParameter('id'))), sprintf('Object identification does not exist (%s).', $request->getParameter('id')));
		$this->form = new IdentificationForm($identification);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$this->forward404Unless($identification = Doctrine_Core::getTable('Identification')->find(array($request->getParameter('id'))), sprintf('Object identification does not exist (%s).', $request->getParameter('id')));
		$identification->delete();

		$this->redirect('identification/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$identification = $form->save();

			$this->redirect('identification/edit?id='.$identification->getId());
		}
	}
}
