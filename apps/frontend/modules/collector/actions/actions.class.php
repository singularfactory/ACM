<?php

/**
 * collector actions.
 *
 * @package    bna_green_house
 * @subpackage collector
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class collectorActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->collectors = Doctrine_Core::getTable('Collector')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new CollectorForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new CollectorForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($collector = Doctrine_Core::getTable('Collector')->find(array($request->getParameter('id'))), sprintf('Object collector does not exist (%s).', $request->getParameter('id')));
    $this->form = new CollectorForm($collector);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($collector = Doctrine_Core::getTable('Collector')->find(array($request->getParameter('id'))), sprintf('Object collector does not exist (%s).', $request->getParameter('id')));
    $this->form = new CollectorForm($collector);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($collector = Doctrine_Core::getTable('Collector')->find(array($request->getParameter('id'))), sprintf('Object collector does not exist (%s).', $request->getParameter('id')));
    $collector->delete();

    $this->redirect('collector/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $collector = $form->save();

      $this->redirect('collector/edit?id='.$collector->getId());
    }
  }
}
