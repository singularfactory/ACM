<?php

/**
 * strain actions.
 *
 * @package    bna_green_house
 * @subpackage strain
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class strainActions extends MyActions {
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'Strain', array('init' => false, 'sort_column' => 'id'));
		
		// Deal with search criteria
		if ( $text = $request->getParameter('criteria') ) {	
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Sample s")
				->leftJoin("{$this->mainAlias()}.TaxonomicClass c")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species sp")
				->leftJoin("{$this->mainAlias()}.Authority a")
				->leftJoin("{$this->mainAlias()}.Isolator is")
				->leftJoin("{$this->mainAlias()}.Depositor d")
				->leftJoin("{$this->mainAlias()}.Identifier id")
				->leftJoin("{$this->mainAlias()}.MaintenanceStatus ms")
				->leftJoin("{$this->mainAlias()}.CryopreservationMethod cm")
				->where("{$this->mainAlias()}.id LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.remarks LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.citations LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.observation LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.transfer_interval LIKE ?", "%$text%")
				->orWhere('s.id LIKE ?', "%$text%")
				->orWhere('c.name LIKE ?', "%$text%")
				->orWhere('g.name LIKE ?', "%$text%")
				->orWhere('sp.name LIKE ?', "%$text%")
				->orWhere('a.name LIKE ?', "%$text%")
				->orWhere('is.name LIKE ?', "%$text%")
				->orWhere('is.surname LIKE ?', "%$text%")
				->orWhere('d.name LIKE ?', "%$text%")
				->orWhere('d.surname LIKE ?', "%$text%")
				->orWhere('id.name LIKE ?', "%$text%")
				->orWhere('id.surname LIKE ?', "%$text%")
				->orWhere('ms.name LIKE ?', "%$text%")
				->orWhere('cm.name LIKE ?', "%$text%");
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Sample s");
		}
		$this->pager->setQuery($query);
		$this->pager->init();
		
		// Keep track of the last page used in list
		$this->getUser()->setAttribute('strain.index_page', $request->getParameter('page'));
		
		// Add a form to filter results
		$this->form = new StrainForm();
  }

  public function executeShow(sfWebRequest $request) {
    $this->strain = Doctrine_Core::getTable('Strain')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->strain);
  }

  public function executeNew(sfWebRequest $request) {
    $this->form = new StrainForm();
  }

  public function executeCreate(sfWebRequest $request) {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new StrainForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request) {
    $this->forward404Unless($strain = Doctrine_Core::getTable('Strain')->find(array($request->getParameter('id'))), sprintf('Object strain does not exist (%s).', $request->getParameter('id')));
    $this->form = new StrainForm($strain);
  }

  public function executeUpdate(sfWebRequest $request) {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($strain = Doctrine_Core::getTable('Strain')->find(array($request->getParameter('id'))), sprintf('Object strain does not exist (%s).', $request->getParameter('id')));
    $this->form = new StrainForm($strain);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request) {
    $request->checkCSRFProtection();

    $this->forward404Unless($strain = Doctrine_Core::getTable('Strain')->find(array($request->getParameter('id'))), sprintf('Object strain does not exist (%s).', $request->getParameter('id')));
    $strain->delete();

    $this->redirect('strain/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form) {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $strain = $form->save();

      $this->redirect('strain/edit?id='.$strain->getId());
    }
  }
}
