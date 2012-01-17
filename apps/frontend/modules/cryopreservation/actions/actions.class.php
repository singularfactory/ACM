<?php

/**
 * cryopreservation actions.
 *
 * @package    bna_green_house
 * @subpackage cryopreservation
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cryopreservationActions extends MyActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->cryopreservations = Doctrine_Core::getTable('Cryopreservation')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->cryopreservation = Doctrine_Core::getTable('Cryopreservation')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->cryopreservation);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new CryopreservationForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new CryopreservationForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($cryopreservation = Doctrine_Core::getTable('Cryopreservation')->find(array($request->getParameter('id'))), sprintf('Object cryopreservation does not exist (%s).', $request->getParameter('id')));
    $this->form = new CryopreservationForm($cryopreservation);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($cryopreservation = Doctrine_Core::getTable('Cryopreservation')->find(array($request->getParameter('id'))), sprintf('Object cryopreservation does not exist (%s).', $request->getParameter('id')));
    $this->form = new CryopreservationForm($cryopreservation);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($cryopreservation = Doctrine_Core::getTable('Cryopreservation')->find(array($request->getParameter('id'))), sprintf('Object cryopreservation does not exist (%s).', $request->getParameter('id')));
    $cryopreservation->delete();

    $this->redirect('cryopreservation/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $cryopreservation = $form->save();

      $this->redirect('cryopreservation/edit?id='.$cryopreservation->getId());
    }
  }
}
