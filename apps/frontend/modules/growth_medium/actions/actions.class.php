<?php

/**
* growth_medium actions.
*
* @package    bna_green_house
* @subpackage growth_medium
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class growth_mediumActions extends MyActions {

	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'GrowthMedium', array('init' => false));
		
		// Deal with search criteria
		if ( $text = $request->getParameter('criteria') ) {
			$query = $this->pager->getQuery()
				->where("{$this->mainAlias()}.name LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.description LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.link LIKE ?", "%$text%");
		}
		else {
			$query = $this->pager->getQuery();
		}
		
		$this->pager->setQuery($query);
		$this->pager->init();
		
		// Keep track of the last page used in list
		$this->getUser()->setAttribute('growth_medium.index_page', $request->getParameter('page'));
		
		// Add a form to filter results
		$this->form = new GrowthMediumForm();
	}

	public function executeShow(sfWebRequest $request) {
		$this->growth_medium = Doctrine_Core::getTable('GrowthMedium')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->growth_medium);
	}

	public function executeNew(sfWebRequest $request) {
		$this->form = new GrowthMediumForm();
	}

	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new GrowthMediumForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($growth_medium = Doctrine_Core::getTable('GrowthMedium')->find(array($request->getParameter('id'))), sprintf('Object growth_medium does not exist (%s).', $request->getParameter('id')));
		$this->form = new GrowthMediumForm($growth_medium);
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($growth_medium = Doctrine_Core::getTable('GrowthMedium')->find(array($request->getParameter('id'))), sprintf('Object growth_medium does not exist (%s).', $request->getParameter('id')));
		$this->form = new GrowthMediumForm($growth_medium);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request) {
		$request->checkCSRFProtection();

		$this->forward404Unless($growth_medium = Doctrine_Core::getTable('GrowthMedium')->find(array($request->getParameter('id'))), sprintf('Object growth_medium does not exist (%s).', $request->getParameter('id')));
		$growth_medium->delete();
		
		$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log'));
		$this->getUser()->setFlash('notice', 'Gorwth medium deleted successfully');
		$this->redirect('@growth_medium?page='.$this->getUser()->getAttribute('growth_medium.index_page'));
	}

	protected function processForm(sfWebRequest $request, sfForm $form) {
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid()) {
			$growth_medium = $form->save();

			$this->redirect('growth_medium/edit?id='.$growth_medium->getId());
		}
	}
}
