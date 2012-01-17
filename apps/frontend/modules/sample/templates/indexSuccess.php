<?php use_helper('Date') ?>

<?php slot('main_header') ?>
<span>All samples</span>
<?php include_partial('global/search_box_header_action', array('route' => '@sample_search?criteria=')) ?>
<?php include_partial('global/new_header_action', array('message' => 'Add a new sample', 'route' => '@sample_new')) ?>
<?php end_slot() ?>

<?php if ( $pager->count() ): ?>
<table id="sample_list">
	<tbody>
		<tr>
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th><?php echo link_to('Code', '@sample?sort_column=id&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Location', '@sample?sort_column=Location.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Collector', '@sample?sort_column=Collectors.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Date', '@sample?sort_column=collection_date&sort_direction='.$sortDirection) ?></th>
			<th class="object_count">Strains</th>
			<th></th>
		</tr>

		<?php foreach ($pager->getResults() as $sample): ?>
		<tr>
			<?php $url = url_for('@sample_show?id='.$sample->getId()) ?>
			<td class="sample_code"><?php echo link_to($sample->getCode(), $url) ?></td>
			<td class="location_name"><?php echo link_to($sample->getLocationNameAndDetails(), $url) ?></td>
			<td class="collectors_name"><?php echo link_to($sample->getFormattedCollectors(), $url) ?></td>
			<td class="date"><?php echo link_to($sample->getFormattedCollectionDate(), $url) ?></td>
			<td class="object_count"><?php echo link_to($sample->getNbStrains(), $url) ?></td>

			<td class="actions">
				<a href="<?php echo $url ?>">
					<?php echo link_to('Edit', '@sample_edit?id='.$sample->getId()) ?>
					<?php echo link_to('Delete', '@sample_delete?id='.$sample->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
				</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'sample', 'sort_direction' => $sortDirection, 'sort_column' => $sortColumn)) ?>
<?php endif ?>

<?php else: ?>
	<p>There are no samples to show.</p>
<?php endif; ?>