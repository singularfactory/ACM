<?php slot('content_title', 'All locations') ?>

<table id="location_list">
	<thead>
		<tr>
			<th>Name</th>
			<th>Country</th>
			<th>Region</th>
			<th>Island</th>
			<th>Has pictures?</th>
			<th>Number of samples</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($locations as $location): ?>
			<tr>
				<td id="location_list_name_column">
					<?php echo link_to($location->getName(), 'location/edit?id='.$location->getId()) ?>
				</td>
				
				<td id="location_list_country_column">
					<?php echo link_to($location->getCountry()->getName(), 'location/edit?id='.$location->getId()) ?>
				</td>
				
				<td id="location_list_region_column">
					<?php echo link_to($location->getRegion()->getName(), 'location/edit?id='.$location->getId()) ?>
				</td>
				
				<td id="location_list_island_column">
					<?php
						if ( $location->getIslandId() )
							echo link_to($location->getIsland()->getName(), 'location/edit?id='.$location->getId());
						else
							echo '-';
					?>
				</td>
				
				<td id="location_list_picture_column">
					<?php echo link_to((count($location->getPictures()))?'yes':'no', 'location/edit?id='.$location->getId()) ?>
				</td>
				
				<td id="location_list_count_column">
					<?php echo link_to(count($location->getSamples()), 'location/edit?id='.$location->getId()) ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php echo link_to('Add a new location', 'location/new') ?>
