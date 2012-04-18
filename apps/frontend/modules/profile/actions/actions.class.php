<?php
/**
 * acm : Algae Culture Management (https://github.com/singularfactory/ACM)
 * Copyright 2012, Singular Factory <info@singularfactory.com>
 *
 * This file is part of ACM
 *
 * ACM is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ACM is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ACM.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright     Copyright 2012, Singular Factory <info@singularfactory.com>
 * @package       ACM.Frontend
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */
?>
<?php

/**
 * profile actions.
 *
 * @package ACM.Frontend
 * @subpackage profile
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class profileActions extends myActions {
	public function executeEdit(sfWebRequest $request) {
		// Avoid hacking on other people profile
		$userId = $this->getUser()->getGuardUser()->getId();
		if ( $userId !== $request->getParameter('id') ) {
			$this->redirect('@profile_shortcut?id='.$userId);
		}

		$this->form = new sfGuardUserForm($this->getRoute()->getObject());
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->form = new sfGuardUserForm($this->getRoute()->getObject());
		$this->processForm($request, $this->form);
		$this->setTemplate('edit');
	}

	public function executeNewToken(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$user = $this->getUser()->getGuardUser();
			$previousToken = $user->getToken();
			$newToken = sha1($user->getEmailAddress().rand(11111, 99999));

			$user->setToken($newToken);
			if ( $user->trySave() ) {
				$this->getResponse()->setContent($newToken);
			}
			else {
				$this->getResponse()->setContent($previousToken);
			}
		}
		return sfView::NONE;
	}

	protected function processForm(sfWebRequest $request, sfForm $form) {
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

		// Validate and save form
		if ( $form->isValid() ) {
			$message = null;
			$url = null;

			// Retain the actual avatar to delete after form save if necessary
			$oldAvatar = $form->getObject()->getAvatar();

			$user = null;
			try {
				$user = $form->save();
				$message = 'Profile updated successfully';
				$url = '@profile_shortcut?id='.$user->getId();

				// Delete previous avatar
				$newAvatar = $user->getAvatar();
				if ( $oldAvatar !== $newAvatar ) {
					$path = sfConfig::get('sf_web_dir').sfConfig::get('app_pictures_dir').sfConfig::get('app_avatar_dir');
					$filename = $path.'/'.$oldAvatar;
					unlink($filename);
				}
			}
			catch (Exception $e) {
				$message = $e->getMessage();
			}

			if ( $user != null ) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $user->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ( $url !== null ) {
					$this->redirect($url);
				}
			}
			$this->redirect('@profile_shortcut?id='.$user->getId());
		}

		$this->getUser()->setFlash('notice', 'The information on your profile has some errors you need to fix', false);
	}
}
