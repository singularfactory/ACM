<?php

/**
 * PurchaseOrder
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class PurchaseOrder extends BasePurchaseOrder {
	
	public function getNbPendingPurchaseOrders() {
		return PurchaseOrderTable::getInstance()->createQuery('po')
			->where('po.status < ?', sfConfig::get('app_purchase_order_sent'))
			->count();
	}
	
	public function getFormattedCustomer() {
		if ( $customer = $this->_get('customer') ) {
			return $customer;
		}
		
		return sfConfig::get('app_no_data_message');
	}
	
	public function getDate() {
		return $this->formatFriendlyDate($this->getCreatedAt());
	}
	
	public function getFormattedActivationDate() {
		if ( $activationDate = $this->_get('activation_date') ) {
			return $this->formatFriendlyDate($activationDate);
		}
		
		return sfConfig::get('app_no_data_message');
	}
	
	public function getFormattedDeliveryDate() {
		if ( $deliveryDate = $this->_get('delivery_date') ) {
			return $this->formatFriendlyDate($deliveryDate);
		}
		
		return sfConfig::get('app_no_data_message');
	}
	
	public function setActivationDate($activationDate) {
		if ( !$this->_get('activation_date') ) {
			return $this->_set('activation_date', $activationDate);
		}
	}
	
	public function setStatus($status) {
		if ( $this->getStatus() == sfConfig::get('app_purchase_order_pending') && $status > $this->getStatus() == sfConfig::get('app_purchase_order_pending') ) {
			$this->setActivationDate(date('Y-m-d H:i:s'));
		}
		
		if ( $this->getStatus() != sfConfig::get('app_purchase_order_sent') && $status >= sfConfig::get('app_purchase_order_sent') ) {
			$this->setDeliveryDate(date('Y-m-d H:i:s'));
		}
		
		$this->_set('status', $status);
	}
	
	public function getFormattedStatus() {
		switch( $this->_get('status') ) {
			case sfConfig::get('app_purchase_order_pending'):
				return 'pending';
				break;
			case sfConfig::get('app_purchase_order_processing'):
				return 'processing';
				break;
			case sfConfig::get('app_purchase_order_ready');
				return 'ready';
				break;
			case sfConfig::get('app_purchase_order_sent');
				return 'sent';
				break;
			case sfConfig::get('app_purchase_order_canceled');
				return 'canceled';
				break;
			case sfConfig::get('app_purchase_order_refund');
				return 'refund';
				break;		
		}
		
		return 'processing';
	}
	
	public function getDeliveryCode() {
		if ( $code = $this->_get('delivery_code') ) {
			return $code;
		}
		return sfConfig::get('app_no_data_message');
	}
	
	public function getNbItems() {
		return PurchaseItemTable::getInstance()->createQuery('pi')
			->where('pi.purchase_order_id = ?', $this->getId())
			->count();
	}
	
	public function getNbReadyItems() {
		return PurchaseItemTable::getInstance()->createQuery('pi')
			->where('pi.purchase_order_id = ?', $this->getId())
			->andWhere('pi.status = ?', sfConfig::get('app_purchase_item_ready'))
			->count();
	}
	
	public function updateStatusWithItemStatus($itemStatus) {
		if ( $itemStatus == sfConfig::get('app_purchase_item_pending') ) {
			return;
		}
		
		if ( $itemStatus == sfConfig::get('app_purchase_item_processing') ) {
			$this->setStatus(sfConfig::get('app_purchase_order_processing'));
			$this->setActivationDate(date('Y-m-d H:i:s'));
			$this->trySave();
		}
		
		if ( $this->getStatus() != sfConfig::get('app_purchase_order_sent') && $itemStatus == sfConfig::get('app_purchase_item_ready') ) {
			if ( $this->getNbReadyItems() == $this->getNbItems() ) {
				$this->setStatus(sfConfig::get('app_purchase_order_ready'));
				$this->trySave();
			}
			else {
				$this->setStatus(sfConfig::get('app_purchase_order_processing'));
				$this->setActivationDate(date('Y-m-d H:i:s'));
				$this->trySave();
			}
		}
	}
	
	public function updateItemsStatus() {
		if ( $this->getStatus() >= sfConfig::get('app_purchase_order_ready') ) {
			$items = array();
			foreach ( $this->getItems() as $item ) {
				$items[] = $item->getId();
			}

			PurchaseItemTable::getInstance()
				->createQuery('pi')
				->update()
				->set('pi.status', sfConfig::get('app_purchase_item_ready'))
				->whereIn('pi.purchase_order_id', $items)
				->execute();
		}
	}
	
	public function getFormattedRemarks() {
		$remarks = $this->getRemarks();
		if ( empty($remarks) ) {
			return sfConfig::get('app_no_data_message');
		}
		else {
			return $remarks;
		}
	}
	
}
