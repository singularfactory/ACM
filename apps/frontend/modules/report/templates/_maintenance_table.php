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
				<th><?php echo ($modelToGroupBy == 'in_g_catalog') ? 'In G-catalog' : sfInflector::humanize($modelToGroupBy) ?></th>
				<th class="report_object_count">Strains</th>
				<th class="report_object_count">DNA extractions</th>
			</tr>
			<?php foreach ( $results as $strain ): ?>
			<tr>
				<td>
					<?php
						$value = $strain->value;
						if ( $modelToGroupBy == 'is_epitype' || $modelToGroupBy == 'is_axenic' || $modelToGroupBy == 'deceased' || $modelToGroupBy == 'in_g_catalog' ) {
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

				<?php if ( !$filters->offsetExists('Deceased') ): ?>
				<th>Deceased?</th>
				<?php endif ?>

				<?php if ( !$filters->offsetExists('In G-catalog') ): ?>
				<th>In G-catalog?</th>
				<?php endif ?>

				<?php if ( !$filters->offsetExists('TransferInterval') ): ?>
				<th class="report_object_count">Transference (weeks)</th>
				<?php endif ?>

				<th class="report_object_count">DNA extractions</th>
			</tr>
			<?php foreach ( $results as $strain ): ?>
			<tr>
				<td><?php echo $strain->getFullCode() ?></td>

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

				<?php if ( !$filters->offsetExists('In G-catalog') ): ?>
				<td><?php echo $strain->getFormattedInGCatalog() ?></td>
				<?php endif ?>

				<?php if ( !$filters->offsetExists('Deceased') ): ?>
				<td><?php echo $strain->getFormattedDeceased() ?></td>
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