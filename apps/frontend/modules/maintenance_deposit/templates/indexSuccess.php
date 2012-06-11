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
<span>All maintenance deposits</span>
	<?php include_partial('global/search_box_header_action', array('route' => '@maintenance_deposit_search?criteria=')) ?>
<?php include_partial('global/new_header_action', array('message' => 'Add a new maintenance_deposit', 'route' => '@maintenance_deposit_new')) ?>
<?php end_slot() ?>

<?php if ( $pager->count() ): ?>
<table id="maintenance_deposit_list">
	<tbody>
		<tr>
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th><?php echo link_to('Code', '@maintenance_deposit?sort_column=depositor_code&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Depositor', '@maintenance_deposit?sort_column=Depositor.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Deposition date', '@maintenance_deposit?sort_column=deposition_date&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Taxonomy', '@strain?sort_column=TaxonomicClass.name&sort_direction='.$sortDirection) ?></th>
			<th></th>
		</tr>

		<?php foreach ($pager->getResults() as $maintenanceDeposit): ?>
		<tr>
			<?php $url = url_for('@maintenance_deposit_show?id='.$maintenanceDeposit->getId()) ?>
			<td class="maintenance_deposit_depositor_code"><?php echo link_to($maintenanceDeposit->getDepositorCode(), $url) ?></td>
			<td class="depositor_name"><?php echo link_to($maintenanceDeposit->getDepositor(), $url) ?></td>
			<td class="maintenance_deposit_deposition_date"><?php echo link_to($maintenanceDeposit->getDepositionDate(), $url) ?></td>
			<td class="maintenance_deposit_name">
				<span class="species_name">
					<?php echo link_to(sprintf('%s %s %s', $maintenanceDeposit->getTaxonomicClass(), $maintenanceDeposit->getGenus(), $maintenanceDeposit->getSpecies()), $url) ?>
				</span>
			</td>

			<td class="actions">
				<a href="<?php echo $url ?>">
					<?php echo link_to('Edit', '@maintenance_deposit_edit?id='.$maintenanceDeposit->getId()) ?>
					<?php echo link_to('Delete', '@maintenance_deposit_delete?id='.$maintenanceDeposit->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
				</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'maintenance_deposit', 'sort_direction' => $sortDirection, 'sort_column' => $sortColumn)) ?>
<?php endif ?>

<?php else: ?>
	<p>There are no maintenance deposits to show.</p>
<?php endif; ?>
