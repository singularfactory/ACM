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
<span>All locations</span>
<?php include_partial('global/search_box_header_action') ?>
<?php include_partial('global/new_header_action', array('message' => 'Add a new location', 'route' => '@location_new')) ?>
<?php end_slot() ?>

<?php include_partial('global/filter_options', array('module' => 'location', 'form' => $form)) ?>
<?php include_partial('global/filter_conditions', array('groupBy' => $groupBy, 'filters' => $filters, 'route' => '@location')) ?>

<?php if (!empty($groupBy)): ?>
<?php include_partial('group_by_index', array('results' => $results, 'groupBy' => $groupBy)) ?>
<?php elseif (count($results)): ?>
<table id="location_list">
	<tbody>
		<tr>
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th><?php echo link_to('Name', '@location?sort_column=name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Country', '@location?sort_column=Country.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Region', '@location?sort_column=Region.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Island', '@location?sort_column=Island.name&sort_direction='.$sortDirection) ?></th>
			<th class="object_count">Samples</th>
			<th class="object_count">Strains</th>
			<th></th>
		</tr>

		<?php foreach ($results as $location): ?>
		<?php $locationId = $location->getId() ?>
		<tr>
			<?php $url = url_for('@location_show?id='.$locationId) ?>
			<td class="location_name"><?php echo link_to($location->getName(), $url) ?></td>
			<td class="country_name"><?php echo link_to($location->getCountry(), $url) ?></td>
			<td class="region_name"><?php echo link_to($location->getRegion(), $url) ?></td>
			<td class="island_name"><?php echo link_to(($location->getIslandId())?$location->getIsland():'-', $url) ?></td>
			<td class="object_count"><?php echo link_to($location->getNbSamples(), $url) ?></td>
			<td class="object_count"><?php echo link_to($location->getNbStrains(), $url) ?></td>

			<td class="actions">
				<?php echo link_to('Edit', '@location_edit?id='.$locationId) ?>
				<?php echo link_to('Delete', '@location_delete?id='.$locationId, array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'location', 'sort_direction' => $sortDirection, 'sort_column' => $sortColumn)) ?>
<?php endif ?>

<?php else: ?>
	<p>There are no locations to show.</p>
<?php endif; ?>
