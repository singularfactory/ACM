<?php if ( $modelToGroupBy ): ?>
	<table id="report_results_list">
		<tbody>
			<tr>
				<th><?php echo sfInflector::camelize($modelToGroupBy) ?></th>
				<th class="report_object_count">Samples</th>
				<th class="report_object_count">Strains</th>
			</tr>
			<?php foreach ( $results as $sample ): ?>
			<tr>
				<td><?php echo ($sample->value) ? $sample->value: sfConfig::get('app_no_data_message') ?></td>
				<td class="report_object_count"><?php echo $sample->n_samples ?></td>
				<td class="report_object_count"><?php echo $sample->n_strains ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php else: ?>
	<table id="report_results_list">
		<tbody>
			<tr>
				<th>Sample</th>

				<?php if ( !$filters->offsetExists('Environment') ): ?>
				<th>Environment</th>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Habitat') ): ?>
				<th>Habitat</th>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Radiation') ): ?>
				<th>Radiation</th>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Extremophile') ): ?>
				<th>Extremophile?</th>
				<?php endif ?>
				
				<th class="report_object_count">Strains</th>
			</tr>
			<?php foreach ( $results as $sample ): ?>
			<tr>
				<td><?php echo $sample->getCode() ?></td>

				<?php if ( !$filters->offsetExists('Environment') ): ?>
				<td><?php echo $sample->getEnvironment() ?></td>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Habitat') ): ?>
				<td><?php echo $sample->getHabitat() ?></td>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Radiation') ): ?>
				<td><?php echo $sample->getRadiation() ?></td>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Extremophile') ): ?>
				<td><?php echo $sample->getFormattedIsExtremophile() ?></td>
				<?php endif ?>
				
				<td class="report_object_count"><?php echo $sample->getNbStrains() ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif ?>