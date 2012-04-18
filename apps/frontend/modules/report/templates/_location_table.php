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
				<th class="report_object_count">Locations</th>
				<th class="report_object_count">Samples</th>
				<th class="report_object_count">Strains</th>
			</tr>
			<?php foreach ( $results as $location ): ?>
			<tr>
				<td><?php echo $location->value ?></td>
				<td class="report_object_count"><?php echo $location->n_locations ?></td>
				<td class="report_object_count"><?php echo $location->n_samples ?></td>
				<td class="report_object_count"><?php echo $location->n_strains ?></td>
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

				<th class="report_object_count">Strains</th>
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

				<td class="report_object_count"><?php echo $location->getNbStrains() ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif ?>