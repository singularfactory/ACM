<?php slot('content_title', 'All habitats') ?>

<table>
	<thead>
		<tr>
			<th>Name</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($habitats as $habitat): ?>
			<tr>
				<td>
					<?php echo link_to($habitat->getName(), 'settings/habitat/edit?id='.$habitat->getId()) ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php echo link_to('Add a new habitat', 'settings/habitat/new') ?>
