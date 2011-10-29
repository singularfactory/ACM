<?php include_partial('report_conditions', array('modelToGroupBy' => $modelToGroupBy, 'filters' => $filters)) ?>

<?php if ( $modelToGroupBy ): ?>
	<table id="report_results_list">
		<tbody>
			<tr>
				<th><?php echo sfInflector::humanize($modelToGroupBy) ?></th>
				<th class="report_object_count">Strains</th>
				<th class="report_object_count">DNA extractions</th>
			</tr>
			<?php foreach ( $results as $strain ): ?>
			<tr>
				<td>
					<?php
						$value = $strain->value;
						if ( $modelToGroupBy == 'is_epitype' || $modelToGroupBy == 'is_axenic' ) {
							echo ($value)? 'yes' : 'no' ;
						}
						else {
							echo ($value) ? $value: sfConfig::get('app_no_data_message');
						}
					?>
				</td>
				<td class="report_object_count"><?php echo $strain->n_strains ?></td>
				<td class="report_object_count"><?php echo $strain->n_dna_extractions ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php else: ?>
	<table id="report_results_list">
		<tbody>
			<tr>
				<th>Strain</th>

				<?php if ( !$filters->offsetExists('TaxonomicClass') ): ?>
				<th>Taxonomic class</th>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Genus') ): ?>
				<th>Genus</th>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Species') ): ?>
				<th>Species</th>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Authority') ): ?>
				<th>Authority</th>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Epitype') ): ?>
				<th>Epitype?</th>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Axenic') ): ?>
				<th>Axenic?</th>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('TransferInterval') ): ?>
				<th class="report_object_count">Transference (weeks)</th>
				<?php endif ?>
				
				<th class="report_object_count">DNA extractions</th>
			</tr>
			<?php foreach ( $results as $strain ): ?>
			<tr>
				<td><?php echo $strain->getCode() ?></td>

				<?php if ( !$filters->offsetExists('TaxonomicClass') ): ?>
				<td><?php echo $strain->getTaxonomicClass() ?></td>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Genus') ): ?>
				<td><em><?php echo $strain->getGenus() ?></em></td>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Species') ): ?>
				<td><em><?php echo $strain->getSpecies() ?></em></td>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Authority') ): ?>
				<td><?php echo $strain->getAuthority() ?></td>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Epitype') ): ?>
				<td><?php echo $strain->getFormattedIsEpitype() ?></td>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Axenic') ): ?>
				<td><?php echo $strain->getFormattedIsAxenic() ?></td>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('TransferInterval') ): ?>
				<td class="report_object_count"><?php echo $strain->getTransferInterval() ?></td>
				<?php endif ?>
				
				<td class="report_object_count"><?php echo $strain->getNbDnaExtractions() ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif ?>