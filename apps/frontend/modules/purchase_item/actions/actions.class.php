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
 * purchase_item actions.
 *
 * @package ACM.Frontend
 * @subpackage purchase_item
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class purchase_itemActions extends MyActions {

	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($purchase_item = Doctrine_Core::getTable('PurchaseItem')->find(array($request->getParameter('id'))), sprintf('Object purchase_item does not exist (%s).', $request->getParameter('id')));
		$this->form = new PurchaseItemForm($purchase_item);
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($purchase_item = Doctrine_Core::getTable('PurchaseItem')->find(array($request->getParameter('id'))), sprintf('Object purchase_item does not exist (%s).', $request->getParameter('id')));
		$this->form = new PurchaseItemForm($purchase_item);

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
			$purchaseItem = null;
			try {
				$purchaseItem = $form->save();
				$message = 'Changes saved';
				$url = '@purchase_order_show?id='.$purchaseItem->getPurchaseOrderId();

				$purchaseItem->getPurchaseOrder()->updateStatusWithItemStatus($purchaseItem->getStatus());
			}
			catch (Exception $e) {
				$message = $e->getMessage();
				if ( $purchaseItem != null ) {
					$this->getUser()->setFlash('notice', 'Changes were saved but purchase order status could not be updated');
				}
			}

			if ( $purchaseItem != null ) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $purchaseItem->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ( $url !== null ) {
					$this->redirect($url);
				}
			}
		}

		$this->getUser()->setFlash('notice', 'The information on this purchase item has some errors you need to fix', false);
	}

}
