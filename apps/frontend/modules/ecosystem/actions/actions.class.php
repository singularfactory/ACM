<?php

/**
 * ecosystem actions.
 *
 * @package    bna_green_house
 * @subpackage ecosystem
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ecosystemActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->ecosystems = Doctrine_Core::getTable('Ecosystem')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new EcosystemForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new EcosystemForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($ecosystem = Doctrine_Core::getTable('Ecosystem')->find(array($request->getParameter('id'))), sprintf('Object ecosystem does not exist (%s).', $request->getParameter('id')));
    $this->form = new EcosystemForm($ecosystem);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($ecosystem = Doctrine_Core::getTable('Ecosystem')->find(array($request->getParameter('id'))), sprintf('Object ecosystem does not exist (%s).', $request->getParameter('id')));
    $this->form = new EcosystemForm($ecosystem);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($ecosystem = Doctrine_Core::getTable('Ecosystem')->find(array($request->getParameter('id'))), sprintf('Object ecosystem does not exist (%s).', $request->getParameter('id')));
    $ecosystem->delete();

    $this->redirect('ecosystem/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $ecosystem = $form->save();

      $this->redirect('ecosystem/edit?id='.$ecosystem->getId());
    }
  }
}
