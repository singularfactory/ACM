<?php

/**
* purchase_order actions.
*
* @package    bna_green_house
* @subpackage purchase_order
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class purchase_orderActions extends MyActions {
	
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'PurchaseOrder', array('init' => false, 'sort_column' => 'created_at', 'sort_direction' => 'desc'));		
		
		// Deal with search criteria
		if ( $text = $request->getParameter('criteria') ) {
			$query = $this->pager->getQuery()
				->where("{$this->mainAlias()}.code LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.status LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.created_at LIKE ?", "%$text%");
				
			// Keep track of search terms for pagination
			$this->getUser()->setAttribute('search.criteria', $text);
		}
		else {
			$query = $this->pager->getQuery();
			$this->getUser()->setAttribute('search.criteria', null);
		}
		
		$this->pager->setQuery($query);
		$this->pager->init();
		
		// Keep track of the last page used in list
		$this->getUser()->setAttribute('purchase_order.index_page', $request->getParameter('page'));
		
		// Add a form to filter results
		$this->form = new PurchaseOrderForm();
	}
	
	public function executeShow(sfWebRequest $request) {
		$this->purchaseOrder = Doctrine_Core::getTable('PurchaseOrder')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->purchaseOrder);
	}
	
	public function executeEdit(sfWebRequest $request) {
    $this->forward404Unless($purchaseOrder = Doctrine_Core::getTable('PurchaseOrder')->find(array($request->getParameter('id'))), sprintf('Object purchase_order does not exist (%s).', $request->getParameter('id')));
    $this->form = new PurchaseOrderForm($purchaseOrder);
  }

  public function executeUpdate(sfWebRequest $request) {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($purchaseOrder = Doctrine_Core::getTable('PurchaseOrder')->find(array($request->getParameter('id'))), sprintf('Object purchase_order does not exist (%s).', $request->getParameter('id')));
    $this->form = new PurchaseOrderForm($purchaseOrder);

    $this->processForm($request, $this->form);
    $this->setTemplate('edit');
  }
	
  protected function processForm(sfWebRequest $request, sfForm $form) {
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
				
		// Validate form
		if ( $form->isValid() ) {
			$message = null;
			$url = null;
			$isNew = $form->getObject()->isNew();
			
			// Save object
			$purchaseOrder = null;
			try {
				$purchaseOrder = $form->save();
				$message = 'Changes saved';
				$url = '@purchase_order_show?id='.$purchaseOrder->getId();
				
				$purchaseOrder->updateItemsStatus();
				if ( $purchaseOrder->getStatus() == sfConfig::get('app_purchase_order_sent') ) {
					$this->notifyPurchaseOrderSent($purchaseOrder);
				}
			}
			catch (Exception $e) {
				$message = $e->getMessage();
				if ( $purchaseOrder != null ) {
					$message = 'Changes were saved but either status of items could not be updated or notifications could not be sent';
				}
			}
			
			if ( $purchaseOrder != null ) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $purchaseOrder->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ( $url !== null ) {
					$this->redirect($url);
				}
			}
		}
		
		$this->getUser()->setFlash('notice', 'The information on this purchase order has some errors you need to fix', false);
  }
	
	protected function notifyPurchaseOrderSent(PurchaseOrder $purchaseOrder) {
		if ( !$purchaseOrder ) {
			return;
		}
		
		// Notify the public web
		$remoteUrl = sfConfig::get('app_notify_sent_public_web_url');
		$purchaseOrder->setDeliveryDate(date('Y-m-d- H:i:s'));
		$purchaseOrder->trySave();
		
		// Notify via application's inbox
		$message = "The purchase order #{$purchaseOrder->getCode()} has been sent to the customer";
		$status = sfConfig::get('app_inbox_notification_new');
		foreach ( sfGuardUserTable::getInstance()->findByNotifyNewOrder(true) as $user ) {
			$notification = new Notification();
			$notification->setMessage($message);
			$notification->setStatus($status);
			$notification->setUserId($user->getId());
			$notification->trySave();
		}
	}
	
}
