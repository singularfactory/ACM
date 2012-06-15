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

<?php if ($maintenanceDeposits->count()): ?>
<table id="maintenance_deposit_list">
	<thead>
		<tr>
			<th>Code</th>
			<th>Depositor</th>
			<th>Name</th>
		</tr>
	</thead>

	<tbody>
		<?php foreach ($maintenanceDeposits as $maintenanceDeposit): ?>
		<?php $species = $maintenanceDeposit->getSpecies() ? $maintenanceDeposit->getSpecies()->getName() : sfConfig::get('app_unknown_species_name') ?>
		<tr>
			<td class="maintenance_deposit_depositor_code"><?php echo $maintenanceDeposit->getCode() ?></td>
			<td class="maintenance_deposit_depositor_name"><?php echo $maintenanceDeposit->getDepositor() ?></td>
			<td class="maintenance_deposit_name">
				<?php echo $maintenanceDeposit->getTaxonomicClass() ?>
				<span class="species_name"><?php echo sprintf('%s %s', $maintenanceDeposit->getGenus(), $species) ?></span>
			</td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>
<?php endif ?>

<div id="copies">
	<label for="copies">Copies per deposit</label>
	<input type="text" name="copies" value="1" id="maintenance_deposit_copies">
</div>
