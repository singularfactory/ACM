<?php

/**
 * country actions.
 *
 * @package    bna_green_house
 * @subpackage country
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class countryActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->countrys = Doctrine_Core::getTable('Country')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new CountryForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new CountryForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($country = Doctrine_Core::getTable('Country')->find(array($request->getParameter('id'))), sprintf('Object country does not exist (%s).', $request->getParameter('id')));
    $this->form = new CountryForm($country);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($country = Doctrine_Core::getTable('Country')->find(array($request->getParameter('id'))), sprintf('Object country does not exist (%s).', $request->getParameter('id')));
    $this->form = new CountryForm($country);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($country = Doctrine_Core::getTable('Country')->find(array($request->getParameter('id'))), sprintf('Object country does not exist (%s).', $request->getParameter('id')));
    $country->delete();

    $this->redirect('(/settings/country/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $country = $form->save();

      $this->redirect('/settings/country/edit?id='.$country->getId());
    }
  }
}
