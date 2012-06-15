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

<?php if ($externalStrains->count()): ?>
<table id="external_strain_list">
	<thead>
		<tr>
			<th>Code</th>
			<th>Name</th>
		</tr>
	</thead>

	<tbody>
		<?php foreach ($externalStrains as $externalStrain): ?>
		<?php $species = $externalStrain->getSpecies() ? $externalStrain->getSpecies()->getName() : sfConfig::get('app_unknown_species_name') ?>
		<tr>
			<td class="external_strain_code"><?php echo $externalStrain->getFullCode() ?></td>
			<td class="external_strain_name">
				<?php echo $externalStrain->getTaxonomicClass() ?>
				<span class="species_name"><?php echo sprintf('%s %s', $externalStrain->getGenus(), $species) ?></span>
			</td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>
<?php endif ?>

<div id="copies">
	<label for="copies">Copies per external strain</label>
	<input type="text" name="copies" value="1" id="external_strain_copies">
</div>
