<?php use_helper('Date') ?>

<?php slot('main_header') ?>
<span>All patent deposits</span>
	<?php include_partial('global/search_box_header_action', array('route' => '@patent_deposit_search?criteria=')) ?>
<?php include_partial('global/new_header_action', array('message' => 'Add a new patent_deposit', 'route' => '@patent_deposit_new')) ?>
<?php end_slot() ?>

<?php if ( $pager->count() ): ?>
<table id="patent_deposit_list">
	<tbody>
		<tr>
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th><?php echo link_to('Code', '@patent_deposit?sort_column=depositor_code&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Depositor', '@patent_deposit?sort_column=Depositor.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Deposition date', '@patent_deposit?sort_column=deposition_date&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Taxonomy', '@strain?sort_column=TaxonomicClass.name&sort_direction='.$sortDirection) ?></th>
			<th></th>
		</tr>
		
		<?php foreach ($pager->getResults() as $patentDeposit): ?>
		<tr>
			<?php $url = url_for('@patent_deposit_show?id='.$patentDeposit->getId()) ?>
			<td class="patent_deposit_depositor_code"><?php echo link_to($patentDeposit->getDepositorCode(), $url) ?></td>
			<td class="depositor_name"><?php echo link_to($patentDeposit->getDepositor(), $url) ?></td>
			<td class="patent_deposit_deposition_date"><?php echo link_to($patentDeposit->getDepositionDate(), $url) ?></td>
			<?php
				$patentDepositName = $patentDeposit->getTaxonomicClass().'&nbsp;<span class="species_name">'.$patentDeposit->getGenus().'</span>&nbsp;';
				if ( $patentDeposit->getSpecies() !== sfConfig::get('app_unknown_species_name') ) {
					$patentDepositName .= '<span class="species_name">'.$patentDeposit->getSpecies().'</span>';
				}
				else {
					$patentDepositName .= $patentDeposit->getSpecies();
				}
			?>
			<td class="patent_deposit_name"><?php echo link_to($patentDepositName, $url) ?></td>

			<td class="actions">
				<a href="<?php echo $url ?>">
					<?php echo link_to('Edit', '@patent_deposit_edit?id='.$patentDeposit->getId()) ?>
					<?php echo link_to('Delete', '@patent_deposit_delete?id='.$patentDeposit->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
				</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'patent_deposit')) ?>
<?php endif ?>

<?php else: ?>
	<p>There are no patent deposits to show.</p>
<?php endif; ?>