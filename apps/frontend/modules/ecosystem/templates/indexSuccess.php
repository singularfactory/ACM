<?php slot('content_title', 'All ecosystems') ?>

<table id="ecosystems_list">
	<thead>
		<tr>
			<th>Name</th>
			<th>City</th>
			<th>Has pictures?</th>
			<th>Number of samples</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($ecosystems as $ecosystem): ?>
			<tr>
				<td id="ecosystems_list_name_column">
					<?php echo link_to($ecosystem->getName(), 'ecosystem/edit?id='.$ecosystem->getId()) ?>
				</td>
				
				<td id="ecosystems_list_city_column">
					<?php echo link_to($ecosystem->getCity(), 'ecosystem/edit?id='.$ecosystem->getId()) ?>
				</td>
				
				<td id="ecosystems_list_picture_column">
					<?php echo link_to((count($ecosystem->getPictures()))?'yes':'no', 'ecosystem/edit?id='.$ecosystem->getId()) ?>
				</td>
				
				<td id="ecosystems_list_count_column">
					<?php echo link_to(count($ecosystem->getSamples()), 'ecosystem/edit?id='.$ecosystem->getId()) ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php echo link_to('Add a new ecosystem', 'ecosystem/new') ?>
