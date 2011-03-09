<?php

/**
* island actions.
*
* @package    bna_green_house
* @subpackage island
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class islandActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->islands = Doctrine_Core::getTable('Island')
			->createQuery('a')
			->execute();
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new IslandForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new IslandForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($island = Doctrine_Core::getTable('Island')->find(array($request->getParameter('id'))), sprintf('Object island does not exist (%s).', $request->getParameter('id')));
		$this->form = new IslandForm($island);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($island = Doctrine_Core::getTable('Island')->find(array($request->getParameter('id'))), sprintf('Object island does not exist (%s).', $request->getParameter('id')));
		$this->form = new IslandForm($island);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$this->forward404Unless($island = Doctrine_Core::getTable('Island')->find(array($request->getParameter('id'))), sprintf('Object island does not exist (%s).', $request->getParameter('id')));
		$island->delete();

		$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log'));
		$this->redirect('island/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$island = $form->save();

			$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $island->getId())));
			$this->redirect('island/edit?id='.$island->getId());
		}
	}
}
