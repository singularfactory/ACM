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
			<th><?php echo link_to('Sample', 'strain/index?sort_column=Sample.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Has DNA', 'strain/index?sort_column=Collector.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Is public', 'strain/index?sort_column=collection_date&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Pending orders', 'strain/index?sort_column=collection_date&sort_direction='.$sortDirection) ?></th>
			<th></th>
		</tr>
		
		<?php foreach ($pager->getResults() as $strain): ?>
		<tr>
			<?php $url = url_for('@strain_show?id='.$strain->getId()) ?>
			<td class="strain_code"><?php echo link_to($strain->getNumber(), $url) ?></td>
			<td class="sample_code"><?php echo link_to($strain->getSample()->getNumber(), $url) ?></td>
			<td class="dna_availability"><?php echo link_to($strain->getFormattedHasDna(), $url) ?></td>
			<td class="public_status"><?php echo link_to($strain->getFormattedIsPublic(), $url) ?></td>
			<td>0</td>

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