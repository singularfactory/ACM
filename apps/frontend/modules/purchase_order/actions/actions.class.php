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
 * purchase_order actions.
 *
 * @package ACM.Frontend
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
			}
			catch (Exception $e) {
				if ( $purchaseOrder != null ) {
					$message = 'Changes were saved but either the status of items could not be updated or the public web was not notified';
				}
				$message = sprintf('%s. %s', $message, $e->getMessage());
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

}
