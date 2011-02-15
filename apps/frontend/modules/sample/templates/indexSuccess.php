<table id="samples_list">
	<thead>
		<tr>
			<th>Number</th>
			<th>Ecosystem</th>
			<th>Location</th>
			<th>Collector</th>
			<th>Date</th>
			<th>Number of strains</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($samples as $sample): ?>
			<tr>
				<td id="samples_list_number_column"><a href="<?php echo url_for('sample/show?id='.$sample->getId()) ?>"><?php echo $sample->getNumber() ?></a></td>
				<td id="samples_list_ecosystem_column"><a href="<?php echo url_for('sample/show?id='.$sample->getId()) ?>"><?php echo $sample->getEcosystemId() ?></a></td>
				<td id="samples_list_location_column"><a href="<?php echo url_for('sample/show?id='.$sample->getId()) ?>"><?php echo $sample->getLocation() ?></a></td>
				<td id="samples_list_collector_column"><a href="<?php echo url_for('sample/show?id='.$sample->getId()) ?>"><?php echo $sample->getCollectorId() ?></a></td>
				<td id="samples_list_date_column"><a href="<?php echo url_for('sample/show?id='.$sample->getId()) ?>"><?php echo $sample->getCollectionDate() ?></a></td>
				<td id="samples_list_count_column"><a href="<?php echo url_for('sample/show?id='.$sample->getId()) ?>"><?php echo '0' ?></a></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<a href="<?php echo url_for('sample/new') ?>">New</a>
