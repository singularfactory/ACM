<?php

/**
 * profile actions.
 *
 * @package    bna_green_house
 * @subpackage profile
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class profileActions extends sfActions {
  public function executeEdit(sfWebRequest $request) {
    $this->form = new sfGuardUserForm($this->getRoute()->getObject());
  }

  public function executeUpdate(sfWebRequest $request) {
    $this->form = new sfGuardUserForm($this->getRoute()->getObject());
    $this->processForm($request, $this->form);
    $this->setTemplate('edit');
  }

  protected function processForm(sfWebRequest $request, sfForm $form) {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

    if ( $form->isValid() ) {
      $sf_guard_user = $form->save();

      $this->redirect('profile/edit?id='.$sf_guard_user->getId());
    }
  }
}
