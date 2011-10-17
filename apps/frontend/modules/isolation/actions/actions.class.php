<?php

/**
 * isolation actions.
 *
 * @package    bna_green_house
 * @subpackage isolation
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class isolationActions extends MyActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->isolations = Doctrine_Core::getTable('Isolation')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->isolation = Doctrine_Core::getTable('Isolation')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->isolation);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new IsolationForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new IsolationForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($isolation = Doctrine_Core::getTable('Isolation')->find(array($request->getParameter('id'))), sprintf('Object isolation does not exist (%s).', $request->getParameter('id')));
    $this->form = new IsolationForm($isolation);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($isolation = Doctrine_Core::getTable('Isolation')->find(array($request->getParameter('id'))), sprintf('Object isolation does not exist (%s).', $request->getParameter('id')));
    $this->form = new IsolationForm($isolation);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($isolation = Doctrine_Core::getTable('Isolation')->find(array($request->getParameter('id'))), sprintf('Object isolation does not exist (%s).', $request->getParameter('id')));
    $isolation->delete();

    $this->redirect('isolation/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $isolation = $form->save();

      $this->redirect('isolation/edit?id='.$isolation->getId());
    }
  }
}
