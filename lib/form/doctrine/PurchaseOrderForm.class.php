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
 * PurchaseOrder form.
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
class PurchaseOrderForm extends BasePurchaseOrderForm {

	public function configure() {
		$this->setWidget('customer', new sfWidgetFormInputText());

		$this->setWidget('status', new sfWidgetFormChoice(array(
			'choices' => array(
				sfConfig::get('app_purchase_order_pending') => 'pending',
				sfConfig::get('app_purchase_order_processing') => 'processing',
				sfConfig::get('app_purchase_order_ready') => 'ready',
		))));

		$this->setValidator('status', new sfValidatorChoice(array(
			'choices' => array(
				sfConfig::get('app_purchase_order_pending'),
				sfConfig::get('app_purchase_order_processing'),
				sfConfig::get('app_purchase_order_ready'),),
			'required' => false)
		));

		$this->widgetSchema->setHelp('code', 'Purchase code assigned after payment');
		$this->widgetSchema->setHelp('status', 'Status of this purchase order');
	}

}
