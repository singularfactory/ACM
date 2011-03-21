<?php slot('main_header') ?>
<span>All locations</span>
<div id="index_new_action">
	<?php echo link_to('Add a new location', 'location/new') ?>
</div>
<?php end_slot() ?>

<table id="location_list">
	<tbody>
		<tr>
			<th>Name</th>
			<th>Country</th>
			<th>Region</th>
			<th>Island</th>
			<th>Samples</th>
			<th class="actions"></th>
		</tr>

		<?php foreach ($pager->getResults() as $location): ?>
		<tr>
			<td class="location_name"><?php echo $location->getName() ?></td>
			<td class="country_name"><?php echo $location->getCountry()->getName() ?></td>
			<td class="region_name"><?php echo $location->getRegion()->getName() ?></td>
			<td class="island_name"><?php echo ($location->getIslandId())?$location->getIsland()->getName():'-'; ?></td>
			<td class="object_count"><?php echo count($location->getSamples()) ?></td>
		
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