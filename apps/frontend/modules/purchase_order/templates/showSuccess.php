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
					<th class="purchase_item_remarks">Remarks</th>
				</tr>
				<?php foreach ($purchaseOrder->getItems() as $item ): ?>
					<?php $url = '@purchase_item_edit?id='.$item->getId() ?>
					<tr>
						<td class="purchase_item_product"><?php echo link_to($item->getDescription(), $url) ?></td>
						<td class="purchase_item_amount"><?php echo link_to($item->getAmount(), $url) ?></td>
						<td class="purchase_item_status"><?php echo link_to($item->getFormattedStatus(), $url) ?></td>
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
			<dt>Received:</dt>
			<dd><?php echo $purchaseOrder->getDate() ?></dd>
			<dt>Activated:</dt>
			<dd><?php echo $purchaseOrder->getActivationDate() ?></dd>
			<dt>Delivered:</dt>
			<dd><?php echo $purchaseOrder->getDeliveryDate() ?></dd>
			<dt>Status:</dt>
			<dd><?php echo $purchaseOrder->getFormattedStatus() ?></dd>
			<dt>Items:</dt>
			<dd><?php echo $nbPurchaseItems ?></dd>
			<dt>Remarks:</dt>
			<dd><?php echo $purchaseOrder->getRemarks(ESC_RAW) ?></dd>
		</dl>
	</div>
	
	<div class="clear"></div>
</div>
