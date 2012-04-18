<?php
/**
 * acm : Algae Culture Management (https://github.com/singularfactory/ACM)
 * Copyright 2012, Singular Factory <info@singularfactory.com>
 *
 * This file is part of ACM
 *
 * ACM is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ACM is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ACM.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright     Copyright 2012, Singular Factory <info@singularfactory.com>
 * @package       ACM.Frontend
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */
?>
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