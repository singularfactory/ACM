<?php if ( $modelToGroupBy ): ?>
	<div id="report_results_conditions">
		<span>Results <strong>grouped by <?php echo $modelToGroupBy ?></strong>
		<?php if ( count($filters) ): ?>
			and limited to the following conditions:</span>
			<dl>
			<?php foreach ( $filters as $key => $value ): ?>
				<dt><?php echo $key ?>:</dt>
				<dd><?php echo $value ?></dd>
			<?php endforeach ?>
			</dl>
		<?php else: ?>
			</span>
		<?php endif ?>
	</div>

	<table id="report_results_list">
		<tbody>
			<tr>
				<th><?php echo sfInflector::camelize($modelToGroupBy) ?></th>
				<th class="report_object_count">Locations</th>
				<th class="report_object_count">Samples</th>
			</tr>
			<?php foreach ( $results as $location ): ?>
			<tr>
				<td><?php echo $location->name ?></td>
				<td class="report_object_count"><?php echo $location->n_locations ?></td>
				<td class="report_object_count"><?php echo $location->n_samples ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php else: ?>
	<div id="report_results_conditions">		
		<?php if ( count($filters) ): ?>
			<span>Results limited to the following conditions:</span>
			<dl>
			<?php foreach ( $filters as $key => $value ): ?>
				<dt><?php echo $key ?>:</dt>
				<dd><?php echo $value ?></dd>
			<?php endforeach ?>
			</dl>
		<?php endif ?>
	</div>		

	<table id="report_results_list">
		<tbody>
			<tr>
				<th>Location</th>
				<th>Country</th>
				<th>Region</th>
				<th>Island</th>
				<th class="report_object_count">Samples</th>
			</tr>
			<?php foreach ( $results as $location ): ?>
			<tr>
				<td><?php echo $location->name ?></td>
				<td><?php echo $location->getCountry() ?></td>
				<td><?php echo $location->getRegion() ?></td>
				<td><?php echo $location->getIsland() ?></td>
				<td class="report_object_count"><?php echo $location->getNbSamples() ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif ?>