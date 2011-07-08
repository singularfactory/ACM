<?php slot('main_header') ?>
<span>All locations</span>
<?php include_partial('global/search_box_header_action', array('route' => '@location_search?criteria=')) ?>
<?php include_partial('global/new_header_action', array('message' => 'Add a new location', 'route' => '@location_new')) ?>
<?php end_slot() ?>

<?php if ( $pager->count() ): ?>
<table id="location_list">
	<tbody>
		<tr>
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th><?php echo link_to('Name', 'location/index?sort_column=name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Country', 'location/index?sort_column=Country.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Region', 'location/index?sort_column=Region.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Island', 'location/index?sort_column=Island.name&sort_direction='.$sortDirection) ?></th>
			<th class="object_count">Samples</th>
			<th></th>
		</tr>

		<?php foreach ($pager->getResults() as $location): ?>
		<tr>
			<?php $url = url_for('@location_show?id='.$location->getId()) ?>
			<td class="location_name"><?php echo link_to($location->getName(), $url) ?></td>
			<td class="country_name"><?php echo link_to($location->getCountry()->getName(), $url) ?></td>
			<td class="region_name"><?php echo link_to($location->getRegion()->getName(), $url) ?></td>
			<td class="island_name"><?php echo link_to(($location->getIslandId())?$location->getIsland()->getName():'-', $url) ?></td>
			<td class="object_count"><?php echo link_to($location->getNbSamples(), $url) ?></td>
		
			<td class="actions">
				<?php echo link_to('Edit', 'location/edit?id='.$location->getId()) ?>
				<?php echo link_to('Delete', 'location/delete?id='.$location->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'location')) ?>
<?php endif ?>

<?php else: ?>
	<p>There are no locations to show.</p>
<?php endif; ?>