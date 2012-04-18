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
 * inbox actions.
 *
 * @package ACM.Frontend
 * @subpackage inbox
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class inboxActions extends MyActions {

  public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'Notification', array('init' => false, 'sort_column' => 'created_at', 'sort_direction' => 'desc'));

		$userId = $this->getUser()->getGuardUser()->getId();

		// Deal with search criteria
		if ( $text = $request->getParameter('criteria') ) {
			$query = $this->pager->getQuery()
				->where("{$this->mainAlias()}.user_id = ?", $userId)
				->andWhere("{$this->mainAlias()}.status != ?", sfConfig::get('app_inbox_notification_deleted'))
				->andWhere("{$this->mainAlias()}.message LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.created_at LIKE ?", "%$text%");

			// Keep track of search terms for pagination
			$this->getUser()->setAttribute('search.criteria', $text);
		}
		else {
			$query = $this->pager->getQuery()
				->where("{$this->mainAlias()}.user_id = ?", $userId)
				->andWhere("{$this->mainAlias()}.status != ?", sfConfig::get('app_inbox_notification_deleted'));

			$this->getUser()->setAttribute('search.criteria', null);
		}

		$this->pager->setQuery($query);
		$this->pager->init();

		// Keep track of the last page used in list
		$this->getUser()->setAttribute('inbox.index_page', $request->getParameter('page'));

		// Add a form to filter results
		$this->form = new NotificationForm();
  }

  public function executeShow(sfWebRequest $request) {
		$this->notification = Doctrine_Core::getTable('Notification')->find(array($request->getParameter('id')));

		if ( $this->notification->getStatus() == sfConfig::get('app_inbox_notification_deleted') ) {
			$this->getUser()->setFlash('notice', "This notification does not exist");
			$this->redirect("@inbox?page=".$this->getUser()->getAttribute("inbox.index_page"));
		}

		if ($this->notification->getStatus() == sfConfig::get('app_inbox_notification_new') ) {
			$this->notification->setStatus(sfConfig::get('app_inbox_notification_read'));
			$this->notification->trySave();
		}

		$this->forward404Unless($this->notification);
  }

  public function executeDelete(sfWebRequest $request) {
		$ids = $request->getParameter('notification');
		if ( !is_array($ids) || empty($ids) ) {
			$ids[] = $request->getParameter('id');
		}

		$notifications = NotificationTable::getInstance()->createQuery('n')->whereIn('n.id', $ids)->execute();
		$hasErrors = false;
		foreach ( $notifications as $notification ) {
			try {
				$notification->setStatus(sfConfig::get('app_inbox_notification_deleted'));
				$notification->save();
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log'));
			}
			catch (Exception $e) {
				$hasErrors = true;
			}
		}

		if ( $hasErrors ) {
			$this->getUser()->setFlash('notice', 'One or more messages could not be deleted');
		}
		else {
			$this->getUser()->setFlash('notice', 'Messages deleted successfully');
		}

		$this->redirect("@inbox?page=".$this->getUser()->getAttribute("inbox.index_page"));
	}

}
