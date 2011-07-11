<?php slot('main_header') ?>
<span>All growth mediums</span>
<?php include_partial('global/search_box_header_action', array('route' => '@growth_medium_search?criteria=')) ?>
<?php include_partial('global/new_header_action', array('message' => 'Add a new growth medium', 'route' => '@growth_medium_new')) ?>
<?php end_slot() ?>

<?php if ( $pager->count() ): ?>
<table id="growth_medium_list">
	<tbody>
		<tr>
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th><?php echo link_to('Name', 'growth_medium/index?sort_column=name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Link', 'growth_medium/index?sort_column=linkname&sort_direction='.$sortDirection) ?></th>
			<th>Strains</th>
			<th></th>
		</tr>

		<?php foreach ($pager->getResults() as $growthMedium): ?>
		<tr>
			<?php $url = url_for('@growth_medium_show?id='.$growthMedium->getId()) ?>
			<td class="growth_medium_name"><?php echo link_to($growthMedium->getName(), $url) ?></td>
			<td class="link"><?php echo link_to($growthMedium->getLink(), $url) ?></td>
			<td><?php echo link_to($growthMedium->getNbStrains(), $url) ?></td>
		
			<td class="actions">
				<?php echo link_to('Edit', 'growth_medium/edit?id='.$growthMedium->getId()) ?>
				<?php echo link_to('Delete', 'growth_medium/delete?id='.$growthMedium->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'growth_medium')) ?>
<?php endif ?>

<?php else: ?>
	<p>There are no growth mediums to show.</p>
<?php endif; ?>