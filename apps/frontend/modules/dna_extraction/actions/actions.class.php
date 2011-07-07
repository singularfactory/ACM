<?php

/**
 * dna_extraction actions.
 *
 * @package    bna_green_house
 * @subpackage dna_extraction
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dna_extractionActions extends MyActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->dna_extractions = Doctrine_Core::getTable('DnaExtraction')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->dna_extraction = Doctrine_Core::getTable('DnaExtraction')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->dna_extraction);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new DnaExtractionForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new DnaExtractionForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($dna_extraction = Doctrine_Core::getTable('DnaExtraction')->find(array($request->getParameter('id'))), sprintf('Object dna_extraction does not exist (%s).', $request->getParameter('id')));
    $this->form = new DnaExtractionForm($dna_extraction);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($dna_extraction = Doctrine_Core::getTable('DnaExtraction')->find(array($request->getParameter('id'))), sprintf('Object dna_extraction does not exist (%s).', $request->getParameter('id')));
    $this->form = new DnaExtractionForm($dna_extraction);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($dna_extraction = Doctrine_Core::getTable('DnaExtraction')->find(array($request->getParameter('id'))), sprintf('Object dna_extraction does not exist (%s).', $request->getParameter('id')));
    $dna_extraction->delete();

    $this->redirect('dna_extraction/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $dna_extraction = $form->save();

      $this->redirect('dna_extraction/edit?id='.$dna_extraction->getId());
    }
  }
}
