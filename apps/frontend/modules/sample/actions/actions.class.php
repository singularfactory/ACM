<?php

/**
* sample actions.
*
* @package    bna_green_house
* @subpackage sample
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class sampleActions extends sfActions
{

	public function executeIndex(sfWebRequest $request)
	{
		$this->pager = new sfDoctrinePager('Sample', sfConfig::get('app_max_list_items'));
		$this->pager->setQuery(Doctrine::getTable('Sample')->createQuery('a'));
		$this->pager->setPage($request->getParameter('page', 1));
		$this->pager->init();
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->sample = Doctrine_Core::getTable('Sample')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->sample);
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->form = new SampleForm();
		$this->hasLocations = (Doctrine::getTable('Location')->count() > 0)?true:false;
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new SampleForm();
		$this->hasLocations = (Doctrine::getTable('Location')->count() > 0)?true:false;

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($sample = Doctrine_Core::getTable('Sample')->find(array($request->getParameter('id'))), sprintf('Object sample does not exist (%s).', $request->getParameter('id')));
		$this->form = new SampleForm($sample);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($sample = Doctrine_Core::getTable('Sample')->find(array($request->getParameter('id'))), sprintf('Object sample does not exist (%s).', $request->getParameter('id')));
		$this->form = new SampleForm($sample);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();

		$this->forward404Unless($sample = Doctrine_Core::getTable('Sample')->find(array($request->getParameter('id'))), sprintf('Object sample does not exist (%s).', $request->getParameter('id')));
		$sample->delete();

		$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log'));
		$this->redirect('sample/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$sample = $form->save();

			$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $sample->getId())));
			$this->redirect('sample/edit?id='.$sample->getId());
		}
	}
}
