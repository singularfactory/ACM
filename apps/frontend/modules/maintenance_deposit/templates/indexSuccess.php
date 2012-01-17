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
			<?php
				$maintenanceDepositName = $maintenanceDeposit->getTaxonomicClass().'&nbsp;<span class="species_name">'.$maintenanceDeposit->getGenus().'</span>&nbsp;';
				if ( $maintenanceDeposit->getSpecies() !== sfConfig::get('app_unknown_species_name') ) {
					$maintenanceDepositName .= '<span class="species_name">'.$maintenanceDeposit->getSpecies().'</span>';
				}
				else {
					$maintenanceDepositName .= $maintenanceDeposit->getSpecies();
				}
			?>
			<td class="maintenance_deposit_name"><?php echo link_to($maintenanceDepositName, $url) ?></td>

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