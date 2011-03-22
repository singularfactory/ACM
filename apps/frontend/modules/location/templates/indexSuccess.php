<?php slot('main_header') ?>
<span>All locations</span>
<div id="index_new_action">
	<?php echo link_to('Add a new location', 'location/new') ?>
</div>
<?php end_slot() ?>

<table id="location_list">
	<tbody>
		<tr>
			<?php if ( $sortType === 'asc' ) $sortType = 'desc'; else $sortType = 'asc' ?>
			<th><?php echo link_to('Name', 'location/index?sort=name&sort_type='.$sortType) ?></th>
			<th><?php echo link_to('Country', 'location/index?sort=Country.name&sort_type='.$sortType) ?></th>
			<th><?php echo link_to('Region', 'location/index?sort=Region.name&sort_type='.$sortType) ?></th>
			<th><?php echo link_to('Island', 'location/index?sort=Island.name&sort_type='.$sortType) ?></th>
			<th>Samples</th>
			<th class="actions"></th>
		</tr>

		<?php foreach ($pager->getResults() as $location): ?>
		<tr>
			<td class="location_name"><?php echo $location->getName() ?></td>
			<td class="country_name"><?php echo $location->getCountry()->getName() ?></td>
			<td class="region_name"><?php echo $location->getRegion()->getName() ?></td>
			<td class="island_name"><?php echo ($location->getIslandId())?$location->getIsland()->getName():'-'; ?></td>
			<td class="object_count"><?php echo $location->getNbSamples() ?></td>
		
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