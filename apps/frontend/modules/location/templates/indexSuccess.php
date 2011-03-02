<?php slot('content_title', 'All locations') ?>

<table id="locations_list">
	<thead>
		<tr>
			<th>Name</th>
			<th>City</th>
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
				
				<td id="location_list_city_column">
					<?php echo link_to($location->getCity(), 'location/edit?id='.$location->getId()) ?>
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
