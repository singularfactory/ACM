<?php

/**
 * maintenance_deposit actions.
 *
 * @package    bna_green_house
 * @subpackage maintenance_deposit
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class maintenance_depositActions extends MyActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->maintenance_deposits = Doctrine_Core::getTable('MaintenanceDeposit')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->maintenance_deposit = Doctrine_Core::getTable('MaintenanceDeposit')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->maintenance_deposit);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new MaintenanceDepositForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new MaintenanceDepositForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($maintenance_deposit = Doctrine_Core::getTable('MaintenanceDeposit')->find(array($request->getParameter('id'))), sprintf('Object maintenance_deposit does not exist (%s).', $request->getParameter('id')));
    $this->form = new MaintenanceDepositForm($maintenance_deposit);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($maintenance_deposit = Doctrine_Core::getTable('MaintenanceDeposit')->find(array($request->getParameter('id'))), sprintf('Object maintenance_deposit does not exist (%s).', $request->getParameter('id')));
    $this->form = new MaintenanceDepositForm($maintenance_deposit);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($maintenance_deposit = Doctrine_Core::getTable('MaintenanceDeposit')->find(array($request->getParameter('id'))), sprintf('Object maintenance_deposit does not exist (%s).', $request->getParameter('id')));
    $maintenance_deposit->delete();

    $this->redirect('maintenance_deposit/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $maintenance_deposit = $form->save();

      $this->redirect('maintenance_deposit/edit?id='.$maintenance_deposit->getId());
    }
  }
}
