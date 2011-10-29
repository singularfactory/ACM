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

				<?php if ( !$filters->offsetExists('Country') ): ?>
				<th>Country</th>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Region') ): ?>
				<th>Region</th>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Island') ): ?>
				<th>Island</th>
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
				
				<td class="report_object_count"><?php echo $location->getNbSamples() ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif ?>