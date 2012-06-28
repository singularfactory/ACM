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

<?php use_helper('Date') ?>

<?php slot('main_header') ?>
<span>All samples</span>
<?php include_partial('global/search_box_header_action') ?>
<?php include_partial('global/new_header_action', array('message' => 'Add a new sample', 'route' => '@sample_new')) ?>
<?php end_slot() ?>

<?php include_partial('global/filter_options', array('module' => 'sample', 'form' => $form)) ?>
<?php include_partial('global/filter_conditions', array('groupBy' => $groupBy, 'filters' => $filters, 'module' => 'sample')) ?>

<?php if (!empty($groupBy)): ?>
<?php include_partial('group_by_index', array('results' => $results, 'groupBy' => $groupBy)) ?>
<?php elseif (count($results)): ?>
<table id="sample_list">
	<tbody>
		<tr>
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th><?php echo link_to('Code', '@sample?sort_column=id&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Location', '@sample?sort_column=Location.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Collector', '@sample?sort_column=Collectors.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Date', '@sample?sort_column=collection_date&sort_direction='.$sortDirection) ?></th>
			<th class="object_count">Strains</th>
			<th></th>
		</tr>

		<?php foreach ($results as $sample): ?>
		<tr>
			<?php $url = url_for('@sample_show?id='.$sample->getId()) ?>
			<td class="sample_code"><?php echo link_to($sample->getCode(), $url) ?></td>
			<td class="location_name"><?php echo link_to($sample->getLocationNameAndDetails(), $url) ?></td>
			<td class="collectors_name"><?php echo link_to($sample->getFormattedCollectors(), $url) ?></td>
			<td class="date"><?php echo link_to($sample->getFormattedCollectionDate(), $url) ?></td>
			<td class="object_count"><?php echo link_to($sample->getNbStrains(), $url) ?></td>

			<td class="actions">
				<a href="<?php echo $url ?>">
					<?php echo link_to('Edit', '@sample_edit?id='.$sample->getId()) ?>
					<?php echo link_to('Delete', '@sample_delete?id='.$sample->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
				</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'sample', 'sort_direction' => $sortDirection, 'sort_column' => $sortColumn)) ?>
<?php endif ?>

<?php else: ?>
	<p>There are no samples to show.</p>
<?php endif; ?>
