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
<span>All culture media</span>
<?php include_partial('global/search_box_header_action') ?>
<?php include_partial('global/new_header_action', array('message' => 'Add a new culture medium', 'route' => '@culture_medium_new')) ?>
<?php end_slot() ?>

<?php include_partial('global/filter_options', array('module' => 'culture_medium', 'form' => $form)) ?>
<?php include_partial('global/filter_conditions', array('groupBy' => $groupBy, 'filters' => $filters, 'module' => 'culture_medium')) ?>

<?php if (!empty($groupBy)): ?>
<?php include_partial('group_by_index', array('results' => $results, 'groupBy' => $groupBy)) ?>
<?php elseif (count($results)): ?>
<table id="culture_medium_list">
	<tbody>
		<tr>
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th class="culture_medium_code"><?php echo link_to('Code', '@culture_medium?sort_column=id&sort_direction='.$sortDirection) ?></th>
			<th class="culture_medium_name"><?php echo link_to('Name', '@culture_medium?sort_column=name&sort_direction='.$sortDirection) ?></th>
			<th class="link"><?php echo link_to('Link', '@culture_medium?sort_column=link&sort_direction='.$sortDirection) ?></th>
			<th class="is_public"><?php echo link_to('Is public', '@culture_medium?sort_column=is_public&sort_direction='.$sortDirection) ?></th>
			<!-- <th class="amount"><?php //echo link_to('Amount', '@culture_medium?sort_column=amount&sort_direction='.$sortDirection) ?></th> -->
			<th class="object_count">Strains</th>
			<th></th>
		</tr>

		<?php foreach ($results as $cultureMedium): ?>
		<tr>
			<?php $url = url_for('@culture_medium_show?id='.$cultureMedium->getId()) ?>
			<td class="culture_medium_code"><?php echo link_to($cultureMedium->getCode(), $url) ?></td>
			<td class="culture_medium_name"><?php echo link_to($cultureMedium->getName(), $url) ?></td>
			<td class="link"><?php echo link_to(truncate_text($cultureMedium->getLink(), 60), $url) ?></td>
			<td class="is_public"><?php echo link_to($cultureMedium->getFormattedIsPublic(), $url) ?></td>
			<!-- <td class="amount"><?php //echo link_to($cultureMedium->getAmount(), $url) ?></td> -->
			<td class="object_count"><?php echo link_to($cultureMedium->getNbStrains(), $url) ?></td>

			<td class="actions">
				<?php echo link_to('Edit', '@culture_medium_edit?id='.$cultureMedium->getId()) ?>
				<?php echo link_to('Delete', '@culture_medium_delete?id='.$cultureMedium->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'culture_medium', 'sort_direction' => $sortDirection, 'sort_column' => $sortColumn)) ?>
<?php endif ?>

<?php else: ?>
	<p>There are no culture media to show.</p>
<?php endif; ?>
