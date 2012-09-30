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
<span>Potential applications</span>
<?php include_partial('global/search_box_header_action') ?>
<?php include_partial('global/new_header_action', array('message' => 'Add a new potential application', 'route' => '@potential_usage_new')) ?>
<?php end_slot() ?>

<?php include_partial('global/filter_options', array('module' => 'potential_usage', 'form' => $form)) ?>
<?php include_partial('global/filter_conditions', array('groupBy' => $groupBy, 'filters' => $filters, 'module' => 'potential_usage')) ?>

<?php if (!empty($groupBy)): ?>
<?php include_partial('group_by_index', array('results' => $results, 'groupBy' => $groupBy)) ?>
<?php elseif (count($results)): ?>
<table id="strain_taxonomy_list">
	<tbody>
		<tr>
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th><?php echo link_to('Class', '@potential_usage?sort_column=TaxonomicClass.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Genus', '@potential_usage?sort_column=Genus.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Species', '@potential_usage?sort_column=Species.name&sort_direction='.$sortDirection) ?></th>
			<th class="object_count">Potential applications</th>
			<th></th>
		</tr>

		<?php foreach ($results as $strainTaxonomy): ?>
		<tr>
			<?php $url = url_for('@potential_usage_show?id='.$strainTaxonomy->getId()) ?>
			<td class="taxonomic_class_name"><?php echo link_to($strainTaxonomy->getTaxonomicClass()->getName(), $url) ?></td>
			<td class="genus_name"><em><?php echo link_to($strainTaxonomy->getGenus()->getName(), $url) ?></em></td>
			<?php $species = $strainTaxonomy->getSpecies() ?>
			<td class="species_name"><em><?php echo link_to($species ? $species->getName() : sfConfig::get('app_unknown_species_name'), $url) ?></em></td>
			<td class="object_count"><?php echo link_to($strainTaxonomy->getPotentialUsages()->count(), $url) ?></td>

			<td class="actions">
				<a href="<?php echo $url ?>">
					<?php echo link_to('Edit', '@potential_usage_edit?id='.$strainTaxonomy->getId()) ?>
					<?php echo link_to('Delete', '@potential_usage_delete?id='.$strainTaxonomy->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
				</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'potential_usage', 'sort_direction' => $sortDirection, 'sort_column' => $sortColumn)) ?>
<?php endif ?>

<?php else: ?>
	<p>There are no records to show.</p>
<?php endif; ?>
