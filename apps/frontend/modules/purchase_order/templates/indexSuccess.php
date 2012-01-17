<?php slot('main_header') ?>
<span>All purchase orders</span>
<?php include_partial('global/search_box_header_action', array('route' => '@purchase_order_search?criteria=')) ?>
<?php end_slot() ?>

<?php if ( $pager->count() ): ?>
<table id="purchase_order_list">
	<tbody>
		<tr>
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th><?php echo link_to('Code', '@purchase_order?sort_column=code&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Customer', '@purchase_order?sort_column=customer&sort_direction='.$sortDirection) ?></th>
			<th class="purchase_order_date"><?php echo link_to('Received', '@purchase_order?sort_column=created_at&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Status', '@purchase_order?sort_column=status&sort_direction='.$sortDirection) ?></th>
			<th class="purchase_order_items">Items</th>
			<th><?php echo link_to('Remarks', '@purchase_order?sort_column=remarks&sort_direction='.$sortDirection) ?></th>
			<th></th>
		</tr>

		<?php foreach ($pager->getResults() as $purchaseOrder): ?>
		<tr>
			<?php $url = url_for('@purchase_order_show?id='.$purchaseOrder->getId()) ?>
			<?php $pendingPurchaseOrderClass = ($purchaseOrder->getStatus() == sfConfig::get('app_purchase_order_pending'))?'purchase_order_pending':'' ?>
			<td class="purchase_order_code <?php echo $pendingPurchaseOrderClass ?>"><?php echo link_to($purchaseOrder->getCode(), $url) ?></td>
			<td class="purchase_order_customer <?php echo $pendingPurchaseOrderClass ?>"><?php echo link_to($purchaseOrder->getCustomer(), $url) ?></td>
			<td class="purchase_order_date <?php echo $pendingPurchaseOrderClass ?>"><?php echo link_to($purchaseOrder->getDate(), $url) ?></td>
			<td class="purchase_order_status <?php echo $pendingPurchaseOrderClass ?>"><?php echo link_to($purchaseOrder->getFormattedStatus(), $url) ?></td>
			<td class="purchase_order_items <?php echo $pendingPurchaseOrderClass ?>"><?php echo link_to($purchaseOrder->getNbItems(), $url) ?></td>
			<td class="purchase_order_remarks <?php echo $pendingPurchaseOrderClass ?>"><?php echo link_to($purchaseOrder->getFormattedRemarks(), $url) ?></td>
		
			<td class="actions">
				<?php echo link_to('Edit', '@purchase_order_edit?id='.$purchaseOrder->getId()) ?>
				<?php echo link_to('Delete', '@purchase_order_delete?id='.$purchaseOrder->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'purchase_order', 'sort_direction' => $sortDirection, 'sort_column' => $sortColumn)) ?>
<?php endif ?>

<?php else: ?>
	<p>There are no purchase orders to show.</p>
<?php endif; ?>
