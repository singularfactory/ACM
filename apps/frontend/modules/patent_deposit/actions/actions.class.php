<?php

/**
 * patent_deposit actions.
 *
 * @package    bna_green_house
 * @subpackage patent_deposit
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class patent_depositActions extends MyActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->patent_deposits = Doctrine_Core::getTable('PatentDeposit')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->patent_deposit = Doctrine_Core::getTable('PatentDeposit')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->patent_deposit);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PatentDepositForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PatentDepositForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($patent_deposit = Doctrine_Core::getTable('PatentDeposit')->find(array($request->getParameter('id'))), sprintf('Object patent_deposit does not exist (%s).', $request->getParameter('id')));
    $this->form = new PatentDepositForm($patent_deposit);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($patent_deposit = Doctrine_Core::getTable('PatentDeposit')->find(array($request->getParameter('id'))), sprintf('Object patent_deposit does not exist (%s).', $request->getParameter('id')));
    $this->form = new PatentDepositForm($patent_deposit);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($patent_deposit = Doctrine_Core::getTable('PatentDeposit')->find(array($request->getParameter('id'))), sprintf('Object patent_deposit does not exist (%s).', $request->getParameter('id')));
    $patent_deposit->delete();

    $this->redirect('patent_deposit/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $patent_deposit = $form->save();

      $this->redirect('patent_deposit/edit?id='.$patent_deposit->getId());
    }
  }
}
