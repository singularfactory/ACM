<?php
/**
 * Form class
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
 * @package       ACM.Lib.Form
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */


/**
 * PurchaseItem form.
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
class PurchaseItemForm extends BasePurchaseItemForm {

	public function configure() {
		unset($this['product'], $this['amount'], $this['code']);

		$this->setWidget('status', new sfWidgetFormChoice(array(
			'choices' => array(
				sfConfig::get('app_purchase_item_pending') => 'pending',
				sfConfig::get('app_purchase_item_processing') => 'processing',
				sfConfig::get('app_purchase_item_ready') => 'ready',
		))));

		$this->setValidator('status', new sfValidatorChoice(array(
			'choices' => array(
				sfConfig::get('app_purchase_item_pending'),
				sfConfig::get('app_purchase_item_processing'),
				sfConfig::get('app_purchase_item_ready'),
			'required' => false)
		)));

		$this->setWidget('purchase_order_id', new sfWidgetFormInputHidden());
		$this->setWidget('product_id', new sfWidgetFormInputHidden());

		$this->widgetSchema->setHelp('status', 'Status of this item');
		$this->widgetSchema->setLabel('supervisor_id', 'Prepared by');
		$this->widgetSchema->setHelp('supervisor_id', 'Biologist responsible for this product');
	}
}
