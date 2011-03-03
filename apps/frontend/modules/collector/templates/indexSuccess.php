<?php slot('content_title', 'All collectors') ?>
<table>
	<thead>
		<tr>
			<th>Name</th>
			<th>Email</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($collectors as $collector): ?>
			<tr>
				<td>
					<?php echo link_to($collector->getName().' '.$collector->getSurname(), '/settings/collector/edit?id='.$collector->getId()) ?>
				</td>
				<td>
					<?php if ( $email = $collector->getEmail() ) echo link_to($email, '/settings/collector/edit?id='.$collector->getId()) ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php echo link_to('Add a new collector', '/settings/collector/new')?>
