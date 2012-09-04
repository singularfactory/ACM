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
<span>All projects</span>
	<?php include_partial('global/search_box_header_action') ?>
	<?php include_partial('global/new_header_action', array('message' => 'Add a new project', 'route' => '@project_new')) ?>
<?php end_slot() ?>

<?php include_partial('global/filter_options', array('module' => 'project', 'form' => $form)) ?>
<?php include_partial('global/filter_conditions', array('groupBy' => $groupBy, 'filters' => $filters, 'module' => 'project')) ?>

<?php if (!empty($groupBy)): ?>
<?php include_partial('group_by_index', array('results' => $results, 'groupBy' => $groupBy)) ?>
<?php elseif (count($results)): ?>
<table id="project_list">
	<tbody>
		<tr>
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th>Code</th>
			<th><?php echo link_to('Subject', '@project?sort_column=subject&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Name', '@project?sort_column=Project.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Class', '@project?sort_column=Strain.TaxonomicClass.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Genus', '@project?sort_column=Strain.Genus.name&sort_direction='.$sortDirection) ?></th>
			<th class="date"><?php echo link_to('Inoculation date', '@project?sort_column=inoculation_date&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Petitioner', '@project?sort_column=Petitioner.name&sort_direction='.$sortDirection) ?></th>
			<th class="date"><?php echo link_to('Delivery date', '@project?sort_column=delivery_date&sort_direction='.$sortDirection) ?></th>
			<th></th>
		</tr>

		<?php foreach ($results as $project): ?>
		<tr>
			<?php $url = url_for('@project_show?id='.$project->getId()) ?>

			<?php $code = '' ?>
			<?php $taxonomicClass = sfConfig::get('app_no_data_message') ?>
			<?php $genusAndSpecies = sfConfig::get('app_no_data_message') ?>
			<?php $subject = $project->getSubject() ?>

			<?php if ( $project->getSubject() == 'sample' ): ?>
				<?php $code = $project->getSample()->getCode() ?>
			<?php elseif ( $project->getSubject() == 'strain' ): ?>
				<?php $strain = $project->getStrain() ?>
				<?php $code = $strain->getFullCode() ?>
				<?php $taxonomicClass = $strain->getTaxonomicClass() ?>
				<?php $genusAndSpecies = $strain->getGenusAndSpecies() ?>
			<?php elseif ( $project->getSubject() == 'external_strain' ): ?>
				<?php $subject = 'research_collection' ?>
				<?php $externalStrain = $project->getExternalStrain() ?>
				<?php $code = $externalStrain->getFullCode() ?>
				<?php $taxonomicClass = $externalStrain->getTaxonomicClass() ?>
				<?php $genusAndSpecies = $externalStrain->getGenusAndSpecies() ?>
			<?php endif ?>

			<td class="project_code"><?php echo link_to($code, $url) ?></td>
			<td class="project_subject"><?php echo link_to(sfInflector::humanize($subject), $url) ?></td>
			<td class="project_name"><?php echo link_to($project->getProjectName()->getName(), $url) ?></td>
			<td class="taxonomic_class_name"><?php echo link_to($taxonomicClass, $url) ?></td>
			<td class="genus_name"><span class="species_name"><?php echo link_to($genusAndSpecies, $url) ?></span></td>
			<td class="date inoculation_date"><?php echo link_to($project->getInoculationDate(), $url) ?></td>
			<td class="petitioner_name"><?php echo link_to($project->getPetitioner()->getName(), $url) ?></td>
			<td class="date delivery_date"><?php echo link_to($project->getDeliveryDate(), $url) ?></td>

			<td class="actions">
				<a href="<?php echo $url ?>">
					<?php echo link_to('Edit', '@project_edit?id='.$project->getId()) ?>
					<?php echo link_to('Delete', '@project_delete?id='.$project->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
				</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'project', 'sort_direction' => $sortDirection, 'sort_column' => $sortColumn)) ?>
<?php endif ?>

<?php else: ?>
	<p>There are no projects to show.</p>
<?php endif; ?>
