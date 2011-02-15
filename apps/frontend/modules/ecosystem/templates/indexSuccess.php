<table id="ecosystems">
	<thead>
		<tr>
			<th>Name</th>
			<th>City</th>
			<th>With picture?</th>
			<th>Number of samples</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($ecosystems as $ecosystem): ?>
			<tr>
				<td><a href="<?php echo url_for('ecosystem/edit?id='.$ecosystem->getId()) ?>"><?php echo $ecosystem->getName() ?></a></td>
				<td><a href="<?php echo url_for('ecosystem/edit?id='.$ecosystem->getId()) ?>"><?php echo $ecosystem->getCity() ?></a></td>
				<td><a href="<?php echo url_for('ecosystem/edit?id='.$ecosystem->getId()) ?>"><?php echo ($ecosystem->getPicture())?'yes':'no' ?></a></td>
				<td><a href="<?php echo url_for('ecosystem/edit?id='.$ecosystem->getId()) ?>"><?php echo count($ecosystem->getSamples()) ?></a></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<a href="<?php echo url_for('ecosystem/new') ?>">New</a>
