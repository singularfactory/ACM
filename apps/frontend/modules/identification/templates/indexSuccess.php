<?php use_helper('Date', 'Text') ?>

<?php slot('main_header') ?>
<span>All identifications</span>
	<?php include_partial('global/search_box_header_action', array('route' => '@identification_search?criteria=')) ?>
	<?php include_partial('global/new_header_action', array('message' => 'Add a new identification', 'route' => '@identification_new')) ?>
<?php end_slot() ?>

<?php if ( $pager->count() ): ?>
<table id="identification_list">
	<tbody>
		<tr>
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th class="date"><?php echo link_to('Date', '@identification?sort_column=identification_date&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Sample', '@identification?sort_column=Strain.Sample.id&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Petitioner', '@identification?sort_column=petitioner&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Microscopy identification', '@identification?sort_column=microscopy_identification&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Molecular identification', '@identification?sort_column=molecular_identification&sort_direction='.$sortDirection) ?></th>
			<th></th>
		</tr>
		
		<?php foreach ($pager->getResults() as $identification): ?>
		<tr>
			<?php $url = url_for('@identification_show?id='.$identification->getId()) ?>
			<td class="date identification_date"><?php echo link_to($identification->getIdentificationDate(), $url) ?></td>
			<td class="sample_code"><?php echo link_to($identification->getSample()->getCode(), $url) ?></td>
			<td class="identification_petitioner"><?php echo link_to($identification->getFormattedPetitioner(), $url) ?></td>
			<td class="microscopy_identification"><?php echo link_to(truncate_text($identification->getFormattedMicroscopyIdentification(), 50), $url) ?></td>
			<td class="molecular_identification"><?php echo link_to(truncate_text($identification->getFormattedMolecularIdentification(), 50), $url) ?></td>

			<td class="actions">
				<a href="<?php echo $url ?>">
					<?php echo link_to('Edit', '@identification_edit?id='.$identification->getId()) ?>
					<?php echo link_to('Delete', '@identification_delete?id='.$identification->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
				</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'identification', 'sort_direction' => $sortDirection, 'sort_column' => $sortColumn)) ?>
<?php endif ?>

<?php else: ?>
	<p>There are no identifications to show.</p>
<?php endif; ?>