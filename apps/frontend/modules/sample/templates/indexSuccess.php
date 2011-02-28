<?php use_helper('Date') ?>
<?php slot('content_title', 'All samples') ?>

<table id="samples_list">
	<thead>
		<tr>
			<th>Number</th>
			<th>Ecosystem</th>
			<th>Location</th>
			<th>User</th>
			<th>Date</th>
			<th>Number of strains</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($samples as $sample): ?>
			<tr>
				<td id="samples_list_number_column"><?php echo link_to($sample->getId(), 'sample/show?id='.$sample->getId()) ?></td>
				<td id="samples_list_ecosystem_column"><?php echo link_to($sample->getEcosystem()->getName(), 'sample/show?id='.$sample->getId()) ?></td>
				<td id="samples_list_location_column"><?php echo link_to($sample->getLocation(), 'sample/show?id='.$sample->getId()) ?></td>
				<td id="samples_list_collector_column"><?php echo link_to($sample->getCollector()->getName(), 'sample/show?id='.$sample->getId()) ?></td>
				<td id="samples_list_date_column"><?php echo link_to(format_date($sample->getCollectionDate(), 'p'), 'sample/show?id='.$sample->getId()) ?></td>
				<td id="samples_list_count_column"><?php echo link_to(0, 'sample/show?id='.$sample->getId()) ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php echo link_to('Add a new sample', 'sample/new') ?>
