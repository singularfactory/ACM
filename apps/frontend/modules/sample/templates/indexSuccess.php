<?php use_helper('Date') ?>
<?php slot('content_title', 'All samples') ?>

<table id="sample_list">
	<thead>
		<tr>
			<th>Number</th>
			<th>Location</th>
			<th>Collector</th>
			<th>Date</th>
			<th>Number of strains</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($samples as $sample): ?>
			<tr>
				<td id="sample_list_number_column"><?php echo link_to($sample->getNumber(), 'sample/show?id='.$sample->getId()) ?></td>
				<td id="sample_list_location_column"><?php echo link_to($sample->getLocation()->getName(), 'sample/show?id='.$sample->getId()) ?></td>
				<td id="sample_list_collector_column"><?php echo link_to($sample->getCollector()->getName(), 'sample/show?id='.$sample->getId()) ?></td>
				<td id="sample_list_date_column"><?php echo link_to(format_date($sample->getCollectionDate(), 'p'), 'sample/show?id='.$sample->getId()) ?></td>
				<td id="sample_list_count_column"><?php echo link_to(0, 'sample/show?id='.$sample->getId()) ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php echo link_to('Add a new sample', 'sample/new') ?>
