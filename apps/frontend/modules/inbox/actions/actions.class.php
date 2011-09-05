<?php

/**
 * inbox actions.
 *
 * @package    bna_green_house
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
		$this->forward404Unless(is_array($ids), sprintf('Object notification does not exist.'));
		
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
