<?php slot('content_title', 'All environments') ?>

<table>
	<thead>
		<tr>
			<th>Name</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($environments as $environment): ?>
			<tr>
				<td>
					<?php echo link_to($environment->getName(), 'settings/environment/edit?id='.$environment->getId()) ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php echo link_to('Add a new environment', 'settings/environment/new') ?>
