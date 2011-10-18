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
			<th><?php echo link_to('Code', '@strain?sort_column=id&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Name', '@strain?sort_column=TaxonomicClass.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Sample', '@strain?sort_column=Sample.id&sort_direction='.$sortDirection) ?></th>
			<th class="dna_availability">Has DNA</th>
			<th><?php echo link_to('Isolation date', '@strain?sort_column=isolation_date&sort_direction='.$sortDirection) ?></th>
			<!-- <th class="amount"><?php //echo link_to('Amount', '@strain?sort_column=amount&sort_direction='.$sortDirection) ?></th> -->
			<th></th>
		</tr>
		
		<?php foreach ($pager->getResults() as $strain): ?>
		<tr>
			<?php $url = url_for('@strain_show?id='.$strain->getId()) ?>
			<td class="strain_code"><?php echo link_to($strain->getCode(), $url) ?></td>
			<td class="strain_name"><?php echo $strain->getTaxonomicClass() ?> <span class="species_name"><?php echo $strain->getGenus() ?> <?php echo $strain->getSpecies() ?></span></td>
			<td class="sample_code"><?php echo link_to($strain->getFormattedSampleCode(), $url) ?></td>
			<td class="dna_availability"><?php echo link_to($strain->getFormattedHasDna(), $url) ?></td>
			<td class="isolation_date"><?php echo link_to($strain->getFormattedIsolationDate(), $url) ?></td>
			<!-- <td class="amount"><?php //echo link_to($strain->getAmount(), $url) ?></td> -->

			<td class="actions">
				<a href="<?php echo $url ?>">
					<?php echo link_to('Edit', '@strain_edit?id='.$strain->getId()) ?>
					<?php echo link_to('Delete', '@strain_delete?id='.$strain->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
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