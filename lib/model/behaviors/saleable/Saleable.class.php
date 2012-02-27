<?php

class SaleableListener extends Doctrine_Record_Listener {

	public function postSave(Doctrine_Event $event) {
		$class = get_class($event->getInvoker());
		
		if ( $class == 'PurchaseOrder' ) {
			$this->notifyPurchaseOrderReady($event->getInvoker());
		}
		
		if ( $class == 'PurchaseItem' ) {
			$this->notifyPurchaseOrderReady($event->getInvoker()->getPurchaseOrder());
		}
	}
	
	protected function notifyPurchaseOrderReady(PurchaseOrder $purchaseOrder) {
		if ( !$purchaseOrder ) {
			return;
		}

		if ( $purchaseOrder->getDeliveryDate() ) {
			return;
		}

		if ( ($status = $purchaseOrder->getStatus()) == sfConfig::get('app_purchase_order_ready') ) {
			$status = 'B';
		}
		else {
			return;
		}

		// Notify the public web
		try {
			require_once sfConfig::get('sf_lib_dir').'/vendor/procrypt/procrypt.php';
			$encrypter = new proCrypt();

			$remoteUrl = sprintf('%s/index.php?option=com_api&task=changestate&order=%s&status=%s',
				rtrim(sfConfig::get('app_notify_sent_public_web_url'), '/'),
				urlencode($encrypter->encrypt($purchaseOrder->getCode())),
				$status);

			$requestHandler = curl_init($remoteUrl);
			curl_setopt($requestHandler, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($requestHandler, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($requestHandler, CURLOPT_HEADER, false);
			if ( !curl_exec($requestHandler) ) {
				throw new Exception(curl_error($requestHandler));
			}
			curl_close($requestHandler);
		}
		catch (Exception $e) {
			throw new Exception("The public web could not be notified about the status of the purchase order ({$e->getMessage()})");
		}

		// Update delivery date
		try {
			$purchaseOrder->setDeliveryDate(date('Y-m-d H:i:s'));
			$purchaseOrder->save();
		}
		catch (Exception $e) {
			throw new Exception('The delivery date of purchase order could not be updated');
		}

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


class Saleable extends Doctrine_Template {

	public function setTableDefinition() {
		$this->addListener(new SaleableListener($this->_options));
	}

}
