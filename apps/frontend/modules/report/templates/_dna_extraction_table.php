<?php include_partial('report_conditions', array('modelToGroupBy' => $modelToGroupBy, 'filters' => $filters)) ?>

<?php if ( $modelToGroupBy ): ?>
	<table id="report_results_list">
		<tbody>
			<tr>
				<th>
					<?php
						if ( $modelToGroupBy == '260_280_ratio' || $modelToGroupBy == '260_230_ratio' ) {
							echo preg_replace('/^(\d+)_(\d+)_ratio$/', '$1:$2 ratio', $modelToGroupBy);
						}
						else {
							echo sfInflector::humanize($modelToGroupBy);
						}
					?>
				</th>
				<th class="report_object_count">DNA extractions</th>
			</tr>
			<?php foreach ( $results as $extraction ): ?>
			<tr>
				<td>
					<?php
						$value = $extraction->value;
						if ( $modelToGroupBy == 'strain' ) {
							echo sprintf('BEA%s%s', str_pad($value, 4, '0', STR_PAD_LEFT), ($extraction->axenic)?'':'B');
						}
						else {
							echo ( $value ) ? $value: sfConfig::get('app_no_data_message');
						}
					?>
				</td>
				<td class="report_object_count"><?php echo $extraction->n_dna_extractions ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php else: ?>
	<table id="report_results_list">
		<tbody>
			<tr>
				<th>DNA extraction</th>

				<?php if ( !$filters->offsetExists('ExtractionKit') ): ?>
				<th>Extraction kit</th>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Concentration') ): ?>
				<th class="report_object_count">Concentration (<?php echo sfConfig::get('app_concentration_unit') ?>)</th>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Aliquots') ): ?>
				<th class="report_object_count">Aliquots</th>
				<?php endif ?>
			</tr>
			<?php foreach ( $results as $extraction ): ?>
			<tr>
				<td><?php echo $extraction->getCode() ?></td>

				<?php if ( !$filters->offsetExists('ExtractionKit') ): ?>
				<td><?php echo $extraction->getExtractionKit() ?></td>
				<?php endif ?>
								
				<?php if ( !$filters->offsetExists('Concentration') ): ?>
				<td class="report_object_count"><?php echo $extraction->getFormattedConcentration() ?></td>
				<?php endif ?>
				
				<?php if ( !$filters->offsetExists('Aliquots') ): ?>
				<td class="report_object_count"><?php echo $extraction->getAliquots() ?></td>
				<?php endif ?>
				
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif ?>