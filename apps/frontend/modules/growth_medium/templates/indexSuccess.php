<?php slot('main_header') ?>
<span>All culture media</span>
<?php include_partial('global/search_box_header_action', array('route' => '@growth_medium_search?criteria=')) ?>
<?php include_partial('global/new_header_action', array('message' => 'Add a new culture medium', 'route' => '@growth_medium_new')) ?>
<?php end_slot() ?>

<?php if ( $pager->count() ): ?>
<table id="growth_medium_list">
	<tbody>
		<tr>
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th class="growth_medium_name"><?php echo link_to('Name', 'growth_medium/index?sort_column=name&sort_direction='.$sortDirection) ?></th>
			<th class="link"><?php echo link_to('Link', 'growth_medium/index?sort_column=link&sort_direction='.$sortDirection) ?></th>
			<th class="is_public"><?php echo link_to('Is public', 'growth_medium/index?sort_column=is_public&sort_direction='.$sortDirection) ?></th>
			<th class="amount"><?php echo link_to('Amount', 'growth_medium/index?sort_column=amount&sort_direction='.$sortDirection) ?></th>
			<th class="object_count">Strains</th>
			<th></th>
		</tr>

		<?php foreach ($pager->getResults() as $growthMedium): ?>
		<tr>
			<?php $url = url_for('@growth_medium_show?id='.$growthMedium->getId()) ?>
			<td class="growth_medium_name"><?php echo link_to($growthMedium->getName(), $url) ?></td>
			<td class="link"><?php echo link_to($growthMedium->getLink(), $url) ?></td>
			<td class="is_public"><?php echo link_to($growthMedium->getFormattedIsPublic(), $url) ?></td>
			<td class="amount"><?php echo link_to($growthMedium->getAmount(), $url) ?></td>
			<td class="object_count"><?php echo link_to($growthMedium->getNbStrains(), $url) ?></td>
		
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