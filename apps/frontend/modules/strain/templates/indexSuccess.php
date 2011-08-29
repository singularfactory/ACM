<?php use_helper('Date') ?>

<?php slot('main_header') ?>
<span>All strains</span>
	<?php include_partial('global/search_box_header_action', array('route' => '@strain_search?criteria=')) ?>
<?php include_partial('global/new_header_action', array('message' => 'Add a new strain', 'route' => '@strain_new')) ?>
<?php end_slot() ?>

<?php if ( $pager->count() ): ?>
<table id="strain_list">
	<tbody>
		<tr>
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th><?php echo link_to('Number', 'strain/index?sort_column=id&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Name', 'strain/index?sort_column=TaxonomicClass.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Sample', 'strain/index?sort_column=Sample.id&sort_direction='.$sortDirection) ?></th>
			<th class="dna_availability">Has DNA</th>
			<th><?php echo link_to('Isolation date', 'strain/index?sort_column=isolation_date&sort_direction='.$sortDirection) ?></th>
			<th class="amount"><?php echo link_to('Amount', 'strain/index?sort_column=amount&sort_direction='.$sortDirection) ?></th>
			<th></th>
		</tr>
		
		<?php foreach ($pager->getResults() as $strain): ?>
		<tr>
			<?php $url = url_for('@strain_show?id='.$strain->getId()) ?>
			<td class="strain_code"><?php echo link_to($strain->getNumber(), $url) ?></td>
			<?php
				$strainName = $strain->getTaxonomicClass().'&nbsp;<span class="species_name">'.$strain->getGenus().'</span>&nbsp;';
				if ( $strain->getSpecies() !== sfConfig::get('app_unkown_species_name') ) {
					$strainName .= '<span class="species_name">'.$strain->getSpecies().'</span>';
				}
				else {
					$strainName .= $strain->getSpecies();
				}
			?>
			<td class="strain_name"><?php echo link_to($strainName, $url) ?></td>
			<td class="sample_code"><?php echo link_to($strain->getFormattedSampleNumber(), $url) ?></td>
			<td class="dna_availability"><?php echo link_to($strain->getFormattedHasDna(), $url) ?></td>
			<td class="isolation_date"><?php echo link_to(format_date($strain->getIsolationDate(), 'p'), $url) ?></td>
			<td class="amount"><?php echo link_to($strain->getAmount(), $url) ?></td>

			<td class="actions">
				<a href="<?php echo $url ?>">
					<?php echo link_to('Edit', 'strain/edit?id='.$strain->getId()) ?>
					<?php echo link_to('Delete', 'strain/delete?id='.$strain->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
				</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'strain')) ?>
<?php endif ?>

<?php else: ?>
	<p>There are no strains to show.</p>
<?php endif; ?>