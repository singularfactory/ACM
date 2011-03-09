<?php

/**
* province actions.
*
* @package    bna_green_house
* @subpackage province
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class provinceActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->provinces = Doctrine_Core::getTable('Province')
			->createQuery('a')
			->execute();
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new ProvinceForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new ProvinceForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($province = Doctrine_Core::getTable('Province')->find(array($request->getParameter('id'))), sprintf('Object province does not exist (%s).', $request->getParameter('id')));
		$this->form = new ProvinceForm($province);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($province = Doctrine_Core::getTable('Province')->find(array($request->getParameter('id'))), sprintf('Object province does not exist (%s).', $request->getParameter('id')));
		$this->form = new ProvinceForm($province);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$this->forward404Unless($province = Doctrine_Core::getTable('Province')->find(array($request->getParameter('id'))), sprintf('Object province does not exist (%s).', $request->getParameter('id')));
		$province->delete();

		$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log'));
		$this->redirect('/settings/province/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$province = $form->save();

			$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $province->getId())));
			$this->redirect('/settings/province/edit?id='.$province->getId());
		}
	}
}
