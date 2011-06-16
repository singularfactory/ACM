<?php

/**
 * growth_medium actions.
 *
 * @package    bna_green_house
 * @subpackage growth_medium
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class growth_mediumActions extends MyActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->growth_mediums = Doctrine_Core::getTable('GrowthMedium')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->growth_medium = Doctrine_Core::getTable('GrowthMedium')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->growth_medium);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new GrowthMediumForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new GrowthMediumForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($growth_medium = Doctrine_Core::getTable('GrowthMedium')->find(array($request->getParameter('id'))), sprintf('Object growth_medium does not exist (%s).', $request->getParameter('id')));
    $this->form = new GrowthMediumForm($growth_medium);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($growth_medium = Doctrine_Core::getTable('GrowthMedium')->find(array($request->getParameter('id'))), sprintf('Object growth_medium does not exist (%s).', $request->getParameter('id')));
    $this->form = new GrowthMediumForm($growth_medium);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($growth_medium = Doctrine_Core::getTable('GrowthMedium')->find(array($request->getParameter('id'))), sprintf('Object growth_medium does not exist (%s).', $request->getParameter('id')));
    $growth_medium->delete();

    $this->redirect('growth_medium/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $growth_medium = $form->save();

      $this->redirect('growth_medium/edit?id='.$growth_medium->getId());
    }
  }
}
