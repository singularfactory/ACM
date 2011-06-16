<?php

/**
 * strain actions.
 *
 * @package    bna_green_house
 * @subpackage strain
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class strainActions extends MyActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->strains = Doctrine_Core::getTable('Strain')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->strain = Doctrine_Core::getTable('Strain')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->strain);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new StrainForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new StrainForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($strain = Doctrine_Core::getTable('Strain')->find(array($request->getParameter('id'))), sprintf('Object strain does not exist (%s).', $request->getParameter('id')));
    $this->form = new StrainForm($strain);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($strain = Doctrine_Core::getTable('Strain')->find(array($request->getParameter('id'))), sprintf('Object strain does not exist (%s).', $request->getParameter('id')));
    $this->form = new StrainForm($strain);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($strain = Doctrine_Core::getTable('Strain')->find(array($request->getParameter('id'))), sprintf('Object strain does not exist (%s).', $request->getParameter('id')));
    $strain->delete();

    $this->redirect('strain/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $strain = $form->save();

      $this->redirect('strain/edit?id='.$strain->getId());
    }
  }
}
