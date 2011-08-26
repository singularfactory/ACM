<?php use_helper('Text') ?>

<?php slot('main_header') ?>
<span>All notifications</span>
<?php include_partial('global/search_box_header_action', array('route' => '@inbox_search?criteria=')) ?>
<?php end_slot() ?>

<?php if ( $pager->count() ): ?>
<table id="inbox_list">
	<tbody>
		<tr>
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th><?php echo link_to('Message', 'inbox/index?sort_column=message&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Received', 'inbox/index?sort_column=created_at&sort_direction='.$sortDirection) ?></th>
			<th></th>
		</tr>

		<?php foreach ($pager->getResults() as $notification): ?>
		<tr>
			<?php $url = url_for('@inbox_show?id='.$notification->getId()) ?>
			<?php $newNotificationClass = ($notification->getStatus() == sfConfig::get('app_inbox_notification_new'))?'notification_new':'' ?>
			
			<td class="notification_message <?php echo $newNotificationClass ?>"><?php echo link_to(truncate_text($notification->getMessage(), 150), $url) ?></td>
			<td class="notification_date <?php echo $newNotificationClass ?>"><?php echo link_to($notification->getDate(), $url) ?></td>
		
			<td class="actions">
				<?php echo link_to('Delete', 'inbox/delete?id='.$notification->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'notification')) ?>
<?php endif ?>

<?php else: ?>
	<p>There are no notifications to show.</p>
<?php endif; ?>
