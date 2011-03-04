<?php

/**
* environment actions.
*
* @package    bna_green_house
* @subpackage environment
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class environmentActions extends sfActions
{
	public function executeIndex(sfWebRequest $request)
	{
		$this->environments = Doctrine_Core::getTable('Environment')
			->createQuery('a')
			->execute();
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new EnvironmentForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new EnvironmentForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($environment = Doctrine_Core::getTable('Environment')->find(array($request->getParameter('id'))), sprintf('Object environment does not exist (%s).', $request->getParameter('id')));
		$this->form = new EnvironmentForm($environment);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($environment = Doctrine_Core::getTable('Environment')->find(array($request->getParameter('id'))), sprintf('Object environment does not exist (%s).', $request->getParameter('id')));
		$this->form = new EnvironmentForm($environment);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$this->forward404Unless($environment = Doctrine_Core::getTable('Environment')->find(array($request->getParameter('id'))), sprintf('Object environment does not exist (%s).', $request->getParameter('id')));
		$environment->delete();

		$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log'));
		$this->redirect('/settings/environment/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$environment = $form->save();

			$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log'));
			$this->redirect('/settings/environment/edit?id='.$environment->getId());
		}
	}
}
