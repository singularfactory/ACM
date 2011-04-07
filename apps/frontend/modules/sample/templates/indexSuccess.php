<?php use_helper('Date') ?>

<?php slot('main_header') ?>
<span>All samples</span>
<?php include_partial('global/new_header_action', array('message' => 'Add a new sample', 'route' => '@sample_new')) ?>
<?php end_slot() ?>

<?php if ( $pager->count() ): ?>
<table id="sample_list">
	<tbody>
		<tr>
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th><?php echo link_to('Number', 'sample/index?sort_column=id&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Location', 'sample/index?sort_column=Location.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Collector', 'sample/index?sort_column=Collector.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Date', 'sample/index?sort_column=collection_date&sort_direction='.$sortDirection) ?></th>
			<th></th>
		</tr>

		<?php foreach ($pager->getResults() as $sample): ?>
		<tr>
			<?php $url = url_for('@sample_show?id='.$sample->getId()) ?>
			<td class="sample_code"><?php echo link_to($sample->getNumber(), $url) ?></td>
			<td class="location_name"><?php echo link_to($sample->getLocation()->getName(), $url) ?></td>
			<td class="collector_name"><?php echo link_to($sample->getCollector()->getFullName(), $url) ?></td>
			<td class="date"><?php echo link_to(format_date($sample->getCollectionDate(), 'p'), $url) ?></td>

			<td class="actions">
				<a href="<?php echo $url ?>">
					<?php echo link_to('Edit', 'sample/edit?id='.$sample->getId()) ?>
					<?php echo link_to('Delete', 'sample/delete?id='.$sample->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
				</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'sample')) ?>
<?php endif ?>

<?php else: ?>
	<p>There are no samples to show.</p>
<?php endif; ?>