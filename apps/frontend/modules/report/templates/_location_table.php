<?php if ( $modelToGroupBy ): ?>
	<table id="report_results_list">
		<tbody>
			<tr>
				<th><?php echo sfInflector::camelize($modelToGroupBy) ?></th>
				<th class="report_object_count">Locations</th>
				<th class="report_object_count">Samples</th>
			</tr>
			<?php foreach ( $results as $location ): ?>
			<tr>
				<td><?php echo $location->value ?></td>
				<td class="report_object_count"><?php echo $location->n_locations ?></td>
				<td class="report_object_count"><?php echo $location->n_samples ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php else: ?>
	<table id="report_results_list">
		<tbody>
			<tr>
				<th>Location</th>

				<?php if ( !$filters->offsetExists('Country') ): ?>
				<th>Country</th>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Region') ): ?>
				<th>Region</th>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Island') ): ?>
				<th>Island</th>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('LocationCategory') ): ?>
				<th>Category</th>
				<?php endif ?>
				
				<th class="report_object_count">Samples</th>
			</tr>
			<?php foreach ( $results as $location ): ?>
			<tr>
				<td><?php echo $location->name ?></td>

				<?php if ( !$filters->offsetExists('Country') ): ?>
				<td><?php echo $location->getCountry() ?></td>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Region') ): ?>
				<td><?php echo $location->getRegion() ?></td>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Island') ): ?>
				<td><?php echo $location->getIsland() ?></td>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('LocationCategory') ): ?>
				<td><?php echo $location->getCategory() ?></td>
				<?php endif ?>
				
				<td class="report_object_count"><?php echo $location->getNbSamples() ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif ?>