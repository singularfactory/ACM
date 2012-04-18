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
<?php slot('main_header') ?>
<span>Order #<?php echo $purchaseOrder->getCode() ?></span>
<?php include_partial('global/back_header_action', array('module' => 'purchase_order')) ?>
<?php include_partial('global/edit_header_action', array('module' => 'purchase_order', 'id' => $purchaseOrder->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'purchase_order', 'id' => $purchaseOrder->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_related_models">
		<?php $nbPurchaseItems = $purchaseOrder->getNbItems() ?>
		<?php if ( $nbPurchaseItems > 0): ?>
		<div class="object_related_model_list">
			<h2>Purchase items</h2>
			<table>
				<tr>
					<th class="purchase_item_product">Product</th>
					<th class="purchase_item_amount">Amount</th>
					<th class="purchase_item_status">Status</th>
					<th class="purchase_item_supervisor">Prepared by</th>
					<th class="purchase_item_remarks">Remarks</th>
				</tr>
				<?php foreach ($purchaseOrder->getItems() as $item ): ?>
					<?php $url = '@purchase_item_edit?id='.$item->getId() ?>
					<tr>
						<td class="purchase_item_product"><?php echo link_to($item->getDescription(), $url) ?></td>
						<td class="purchase_item_amount"><?php echo link_to($item->getAmount(), $url) ?></td>
						<td class="purchase_item_status"><?php echo link_to($item->getFormattedStatus(), $url) ?></td>
						<td class="purchase_item_supervisor"><?php echo link_to($item->getFormattedSupervisor(), $url) ?></td>
						<td class="purchase_item_remarks"><?php echo link_to($item->getFormattedRemarks(ESC_RAW), $url) ?></td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
		<?php endif ?>

	</div>

	<div id="object_data_list">
		<dl>
			<dt>Code:</dt>
			<dd><?php echo $purchaseOrder->getCode() ?></dd>
			<dt>Customer:</dt>
			<dd><?php echo $purchaseOrder->getFormattedCustomer() ?></dd>
			<dt>Received:</dt>
			<dd><?php echo $purchaseOrder->getDate() ?></dd>
			<dt>Activated:</dt>
			<dd><?php echo $purchaseOrder->getFormattedActivationDate() ?></dd>
			<dt>Delivered:</dt>
			<dd><?php echo $purchaseOrder->getFormattedDeliveryDate() ?></dd>
			<dt>Status:</dt>
			<dd><?php echo $purchaseOrder->getFormattedStatus() ?></dd>
			<dt>Delivery code:</dt>
			<dd><?php echo $purchaseOrder->getDeliveryCode() ?></dd>
			<dt>Items:</dt>
			<dd><?php echo $nbPurchaseItems ?></dd>
			<dt>Remarks:</dt>
			<dd><?php echo $purchaseOrder->getRemarks(ESC_RAW) ?></dd>
		</dl>
	</div>

	<div class="clear"></div>
</div>
