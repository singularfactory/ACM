<?php slot('content_title', 'All provinces and islands') ?>

<table id="provinces_list">
	<thead>
		<tr>
			<th>Name</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($provinces as $province): ?>
			<tr>
				<td>
					<?php echo link_to($province->getName(), '/settings/province/edit?id='.$province->getId()) ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php echo link_to('Add a new province or island', '/settings/province/new') ?>
