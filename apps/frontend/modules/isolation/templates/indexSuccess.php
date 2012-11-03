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
<?php use_helper('Date') ?>

<?php slot('main_header') ?>
<span>All isolations</span>
	<?php include_partial('global/search_box_header_action') ?>
	<?php include_partial('global/new_header_action', array('message' => 'Add a new isolation', 'route' => '@isolation_new')) ?>
<?php end_slot() ?>

<?php include_partial('global/filter_options', array('module' => 'isolation', 'form' => $form)) ?>
<?php include_partial('global/filter_conditions', array('groupBy' => $groupBy, 'filters' => $filters, 'module' => 'isolation')) ?>

<?php if (!empty($groupBy)): ?>
<?php include_partial('group_by_index', array('results' => $results, 'groupBy' => $groupBy)) ?>
<?php elseif (count($results)): ?>
<table id="isolation_list">
	<tbody>
		<tr>
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th>Code</th>
			<th><?php echo link_to('Material', '@isolation?sort_column=isolation_subject&sort_direction='.$sortDirection) ?></th>
			<th>Related code</th>
			<th><?php echo link_to('Class', '@isolation?sort_column=Strain.TaxonomicClass.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Name', '@isolation?sort_column=Strain.Genus.name&sort_direction='.$sortDirection) ?></th>
			<th class="date"><?php echo link_to('Reception date', '@isolation?sort_column=reception_date&sort_direction='.$sortDirection) ?></th>
			<th class="date"><?php echo link_to('Delivery date', '@isolation?sort_column=delivery_date&sort_direction='.$sortDirection) ?></th>
			<th></th>
		</tr>

		<?php foreach ($results as $isolation): ?>
		<tr>
			<?php $url = url_for('@isolation_show?id='.$isolation->getId()) ?>
			<?php $code = $isolation->getCode() ?>
			<?php $externalCode = $isolation->getExternalCode() ?>
			<?php $taxonomicClass = $isolation->getFormattedTaxonomicClass() ?>
			<?php $genusAndSpecies = $isolation->getGenusAndSpecies() ?>
			<?php $subject = $isolation->getIsolationSubject() ?>

			<?php if ( $sample = $isolation->getSample() ): ?>
				<?php $externalCode = $sample->getCode() ?>
			<?php elseif ( $strain = $isolation->getStrain() ): ?>
				<?php $externalCode = $strain->getFullCode() ?>
				<?php $taxonomicClass = $strain->getTaxonomicClass() ?>
				<?php $genusAndSpecies = $strain->getGenusAndSpecies() ?>
			<?php elseif ( $externalStrain = $isolation->getExternalStrain() ): ?>
				<?php $subject = 'research_collection' ?>
				<?php $externalCode = $externalStrain->getFullCode() ?>
				<?php $taxonomicClass = $externalStrain->getTaxonomicClass() ?>
				<?php $genusAndSpecies = $externalStrain->getGenusAndSpecies() ?>
			<?php endif ?>

			<td class="external_strain_code"><?php echo link_to($code, $url) ?></td>
			<td class="isolation_subject"><?php echo link_to(sfInflector::humanize($subject), $url) ?></td>
			<td class="sample_code"><?php echo link_to($externalCode, $url) ?></td>
			<td class="taxonomic_class_name"><?php echo link_to($taxonomicClass, $url) ?></td>
			<td class="isolation_name"><span class="species_name"><?php echo link_to($genusAndSpecies, $url) ?></span></td>
			<td class="date reception_date"><?php echo link_to($isolation->getReceptionDate(), $url) ?></td>
			<td class="date delivery_date"><?php echo link_to($isolation->getDeliveryDate(), $url) ?></td>

			<td class="actions">
				<a href="<?php echo $url ?>">
					<?php echo link_to('Edit', '@isolation_edit?id='.$isolation->getId()) ?>
					<?php echo link_to('Delete', '@isolation_delete?id='.$isolation->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
				</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'isolation', 'sort_direction' => $sortDirection, 'sort_column' => $sortColumn)) ?>
<?php endif ?>

<?php else: ?>
	<p>There are no isolations to show.</p>
<?php endif; ?>
