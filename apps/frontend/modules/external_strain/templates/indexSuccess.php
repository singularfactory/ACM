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
	<span>All strains</span>
	<?php include_partial('global/search_box_header_action', array('route' => '@external_strain_search?criteria=')) ?>
	<?php include_partial('global/label_header_action', array('message' => 'Create labels', 'route' => '@external_strain_create_label')) ?>
	<?php include_partial('global/new_header_action', array('message' => 'Add a new strain', 'route' => '@external_strain_new')) ?>
<?php end_slot() ?>

<?php if ( $pager->count() ): ?>
<table id="external_strain_list">
	<tbody>
		<tr>
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th><?php echo link_to('Code', '@external_strain?sort_column=depositor_code&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Name', '@external_strain?sort_column=TaxonomicClass.name&sort_direction='.$sortDirection) ?></th>
			<th class="supervisor"><?php echo link_to('Supervisor', '@external_strain?sort_column=Supervisor.first_name&sort_direction='.$sortDirection) ?></th>
			<th></th>
		</tr>

		<?php foreach ($pager->getResults() as $externalStrain): ?>
		<tr>
			<?php $url = url_for('@external_strain_show?id='.$externalStrain->getId()) ?>
			<td class="strain_code"><?php echo link_to($externalStrain->getFullCode(), $url) ?></td>
			<td class="strain_name"><?php echo link_to("{$externalStrain->getTaxonomicClass()} <span class=\"species_name\">{$externalStrain->getGenus()} {$externalStrain->getSpecies()}</span>", $url) ?></td>
			<td class="supervisor"><?php echo link_to($externalStrain->getFormattedSupervisorWithInitials(), $url) ?></td>

			<td class="actions">
				<a href="<?php echo $url ?>">
					<?php echo link_to('Edit', '@external_strain_edit?id='.$externalStrain->getId()) ?>
					<?php echo link_to('Delete', '@external_strain_delete?id='.$externalStrain->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
				</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'external_strain', 'sort_direction' => $sortDirection, 'sort_column' => $sortColumn)) ?>
<?php endif ?>

<?php else: ?>
	<p>There are no strains to show.</p>
<?php endif; ?>
