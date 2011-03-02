<?php

/**
 * radiation actions.
 *
 * @package    bna_green_house
 * @subpackage radiation
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class radiationActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->radiations = Doctrine_Core::getTable('Radiation')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new RadiationForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new RadiationForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($radiation = Doctrine_Core::getTable('Radiation')->find(array($request->getParameter('id'))), sprintf('Object radiation does not exist (%s).', $request->getParameter('id')));
    $this->form = new RadiationForm($radiation);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($radiation = Doctrine_Core::getTable('Radiation')->find(array($request->getParameter('id'))), sprintf('Object radiation does not exist (%s).', $request->getParameter('id')));
    $this->form = new RadiationForm($radiation);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($radiation = Doctrine_Core::getTable('Radiation')->find(array($request->getParameter('id'))), sprintf('Object radiation does not exist (%s).', $request->getParameter('id')));
    $radiation->delete();

    $this->redirect('radiation/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $radiation = $form->save();

      $this->redirect('radiation/edit?id='.$radiation->getId());
    }
  }
}
