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