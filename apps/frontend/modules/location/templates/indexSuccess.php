<?php slot('main_header') ?>
<span>All locations</span>
<div id="main_header_action_new" class="main_header_action">
	<?php echo link_to('Add a new location', 'location/new') ?>
</div>
<?php end_slot() ?>

<?php if ( $pager->count() ): ?>
<table id="location_list">
	<tbody>
		<tr>
			<?php if ( $sortType === 'asc' ) $sortType = 'desc'; else $sortType = 'asc' ?>
			<th><?php echo link_to('Name', 'location/index?sort=name&sort_type='.$sortType) ?></th>
			<th><?php echo link_to('Country', 'location/index?sort=Country.name&sort_type='.$sortType) ?></th>
			<th><?php echo link_to('Region', 'location/index?sort=Region.name&sort_type='.$sortType) ?></th>
			<th><?php echo link_to('Island', 'location/index?sort=Island.name&sort_type='.$sortType) ?></th>
			<th>Samples</th>
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
				<a href="<?php echo $url ?>">
					<?php echo link_to('Edit', 'location/edit?id='.$location->getId()) ?>
					<?php echo link_to('Delete', 'location/delete?id='.$location->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
				</a>
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