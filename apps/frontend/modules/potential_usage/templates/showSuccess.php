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

<?php slot('main_header') ?>
<span>
	<?php echo $strainClass = $strainTaxonomy->getTaxonomicClass() ?>
	<span class="species_name">
		<?php echo $strainGenus = $strainTaxonomy->getGenus() ?>
		<?php echo $strainSpecies = $strainTaxonomy->getSpecies() ?>
	</span>
</span>
<?php include_partial('global/back_header_action', array('module' => 'potential_usage')) ?>
<?php include_partial('global/edit_header_action', array('module' => 'potential_usage', 'id' => $strainTaxonomy->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'potential_usage', 'id' => $strainTaxonomy->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_related_models">
		<?php $nbPotentialUsages = $strainTaxonomy->getPotentialUsages()->count() ?>
		<?php if ($nbPotentialUsages > 0): ?>
		<div class="object_related_model_list">
			<h2>Potential applications</h2>
			<table id="strain_taxonomy_potential_usages_list">
				<thead>
				<tr>
					<th class="usage_target_name">Area</th>
					<th class="usage_target_name">Application</th>
				</tr>
				</thead>
				<tbody>
					<?php foreach ($strainTaxonomy->getPotentialUsages() as $potentialUsage): ?>
					<tr>
						<td class="usage_target_name"><?php echo $potentialUsage->getUsageArea()->getName() ?></td>
						<td class="usage_target_name"><?php echo $potentialUsage->getUsageTarget()->getName() ?></td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
		<?php endif ?>
	</div>

	<div id="object_data_list">
		<dl>
			<dt>Class:</dt>
			<dd><?php echo $strainClass ?></dd>
			<dt>Genus:</dt>
			<dd><span class="species_name"><?php echo $strainGenus ?></span></dd>
			<dt>Species:</dt>
			<dd><span class="species_name"><?php echo $strainSpecies ?></span></dd>
			<dt>Isolators:</dt>
			<dd><?php echo $nbPotentialUsages ?>	</dd>
		</dl>
	</div>
	<div class="clear"></div>
</div>

