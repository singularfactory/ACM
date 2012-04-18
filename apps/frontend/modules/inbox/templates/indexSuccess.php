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
