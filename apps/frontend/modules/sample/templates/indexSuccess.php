<?php use_helper('Date') ?>

<?php slot('main_header') ?>
<span>All samples</span>
<div id="main_header_action_new" class="main_header_action">
	<?php echo link_to('Add a new sample', 'sample/new') ?>
</div>
<?php end_slot() ?>

<?php if ( $pager->count() ): ?>
<table id="sample_list">
	<tbody>
		<tr>
			<?php if ( $sortType === 'asc' ) $sortType = 'desc'; else $sortType = 'asc' ?>
			<th><?php echo link_to('Number', 'sample/index?sort=id&sort_type='.$sortType) ?></th>
			<th><?php echo link_to('Location', 'sample/index?sort=Location.name&sort_type='.$sortType) ?></th>
			<th><?php echo link_to('Collector', 'sample/index?sort=Collector.name&sort_type='.$sortType) ?></th>
			<th><?php echo link_to('Date', 'sample/index?sort=collection_date&sort_type='.$sortType) ?></th>
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