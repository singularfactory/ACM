<?php

/**
 * habitat actions.
 *
 * @package    bna_green_house
 * @subpackage habitat
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class habitatActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->habitats = Doctrine_Core::getTable('Habitat')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new HabitatForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new HabitatForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($habitat = Doctrine_Core::getTable('Habitat')->find(array($request->getParameter('id'))), sprintf('Object habitat does not exist (%s).', $request->getParameter('id')));
    $this->form = new HabitatForm($habitat);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($habitat = Doctrine_Core::getTable('Habitat')->find(array($request->getParameter('id'))), sprintf('Object habitat does not exist (%s).', $request->getParameter('id')));
    $this->form = new HabitatForm($habitat);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($habitat = Doctrine_Core::getTable('Habitat')->find(array($request->getParameter('id'))), sprintf('Object habitat does not exist (%s).', $request->getParameter('id')));
    $habitat->delete();

    $this->redirect('/settings/habitat/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $habitat = $form->save();

      $this->redirect('/settings/habitat/edit?id='.$habitat->getId());
    }
  }
}
