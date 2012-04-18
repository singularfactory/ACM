<?php
/**
 * Saleable behavior
 *
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
 * @package       ACM.Lib.Behavior
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */

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
