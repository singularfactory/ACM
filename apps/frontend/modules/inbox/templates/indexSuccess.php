<?php use_helper('Text') ?>

<?php slot('main_header') ?>
<span>All notifications</span>
<?php include_partial('global/search_box_header_action', array('route' => '@inbox_search?criteria=')) ?>
<?php include_partial('global/delete_selected_header_action', array('module' => 'inbox')) ?>
<?php end_slot() ?>

<?php if ( $pager->count() ): ?>
<table id="inbox_list">
	<tbody>
		<tr>
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th class="table_row_selector"><input type="checkbox" id="table_row_selector_header"></th>
			<th><?php echo link_to('Message', '@inbox?sort_column=message&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Received', '@inbox?sort_column=created_at&sort_direction='.$sortDirection) ?></th>
			<th></th>
		</tr>
		
		<?php foreach ($pager->getResults() as $notification): ?>
		<tr>
			<?php $url = url_for('@inbox_show?id='.$notification->getId()) ?>
			<?php $newNotificationClass = ($notification->getStatus() == sfConfig::get('app_inbox_notification_new'))?'notification_new':'' ?>
			<td class="table_row_selector"><input type="checkbox" name="notification[]" value="<?php echo $notification->getId() ?>"></td>
			<?php $message = preg_replace('/<\w[^>]+>([^<]*)<\/\w+>/', '$1', $notification->getMessage(ESC_RAW)) ?>
			<td class="notification_message <?php echo $newNotificationClass ?>"><?php echo link_to(truncate_text($message, 150), $url) ?></td>
			<td class="notification_date <?php echo $newNotificationClass ?>"><?php echo link_to($notification->getDate(), $url) ?></td>
		
			<td class="actions">
				<?php echo link_to('Delete', '@inbox_delete?id='.$notification->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'notification', 'sort_direction' => $sortDirection, 'sort_column' => $sortColumn)) ?>
<?php endif ?>

<?php else: ?>
	<p>There are no notifications to show.</p>
<?php endif; ?>
