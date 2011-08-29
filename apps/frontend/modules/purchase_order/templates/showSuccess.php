<?php slot('main_header') ?>
<span>Order #<?php echo $purchaseOrder->getCode() ?></span>
<?php include_partial('global/back_header_action', array('module' => 'purchase_order')) ?>
<?php include_partial('global/edit_header_action', array('module' => 'purchase_order', 'id' => $purchaseOrder->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'purchase_order', 'id' => $purchaseOrder->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_data_list">
		<dl>
			<dt>Code:</dt>
			<dd><?php echo $purchaseOrder->getCode() ?></dd>
			<dt>Received:</dt>
			<dd><?php echo $purchaseOrder->getDate() ?></dd>
			<dt>Status:</dt>
			<dd><?php echo $purchaseOrder->getFormattedStatus() ?></dd>
			<dt>Items:</dt>
			<dd>
				<?php echo $nbPurchaseItems = $purchaseOrder->getNbItems() ?>
				<?php if ( $nbPurchaseItems > 0 ): ?>
					<a href="#purchase_order_purchase_items_list" title="List of purchase items in this order" class="page_jump">see below</a>
				<?php endif; ?>
			</dd>
			<dt>Remarks:</dt>
			<dd><?php echo $purchaseOrder->getRemarks() ?></dd>
		</dl>
	</div>
	
	<?php if ( $nbPurchaseItems > 0): ?>
	<div id="purchase_order_purchase_items_list" class="object_related_model_long_list">
		<h2>Purchase items</h2>
		<table>
			<tr>
				<th class="product_item_description">Product</th>
				<th class="product_item_amount">Amount</th>
				<th class="product_item_status">Status</th>
				<th class="product_item_remarks">Remarks</th>
			</tr>
			<?php foreach ($purchaseOrder->getItems() as $item ): ?>
				<?php $url = '@purchase_item_edit?id='.$item->getId() ?>
				<tr>
					<td><?php echo link_to($item->getProduct(), $url) ?></td>
					<td><?php echo link_to($item->getAmount(), $url) ?></td>
					<td><?php echo link_to($item->getFormattedStatus(), $url) ?></td>
					<td><?php echo link_to($item->getRemarks(), $url) ?></td>
				</tr>
			<?php endforeach ?>
		</table>
	</div>
	<?php endif ?>
	
	<div class="clear"></div>
</div>
