<?php use_helper('Date') ?>

<?php slot('main_header') ?>
<span>All samples</span>
<div id="index_new_action">
	<?php echo link_to('Add a new sample', 'sample/new') ?>
</div>
<?php end_slot() ?>

<table id="sample_list">
	<tbody>
		<tr>
			<th>Number</th>
			<th>Location</th>
			<th>Collector</th>
			<th>Date</th>
			<th>Strains</th>
			<th class="actions"></th>
		</tr>

		<?php foreach ($pager->getResults() as $sample): ?>
			<tr>
				<td class="sample_code"><?php echo $sample->getNumber() ?></td>
				<td class="location_name"><?php echo $sample->getLocation()->getName() ?></td>
				<td class="collector_name"><?php echo $sample->getCollector()->getFullName() ?></td>
				<td class="date"><?php echo format_date($sample->getCollectionDate(), 'p') ?></td>
				<td class="object_count"><?php echo 0 ?></td>

				<td class="actions">
					<?php echo link_to('Edit', 'sample/edit?id='.$sample->getId()) ?>
					<?php echo link_to('Delete', 'sample/delete?id='.$sample->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'sample')) ?>
<?php endif ?>