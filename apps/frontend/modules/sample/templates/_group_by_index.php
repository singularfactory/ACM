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
 * @since         1.2
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */
?>

<table id="report_results_list">
	<tbody>
		<tr>
			<th><?php echo sfInflector::camelize($groupBy) ?></th>
			<th class="object_count">Samples</th>
			<th class="object_count">Strains</th>
		</tr>
		<?php foreach ($results as $location): ?>
		<tr>
			<td><?php echo $location->value ?></td>
			<td class="object_count"><?php echo $location->n_samples ?></td>
			<td class="object_count"><?php echo $location->n_strains ?></td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>
