<h1>Samples List</h1>

<table>
	<thead>
		<tr>
			<th>Number</th>
			<th>Location</th>
			<th>Ecosystem</th>
			<th>Environment</th>
			<th>Habitat</th>
			<th>Collector</th>
			<th>Collection date</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($samples as $sample): ?>
			<tr>
				<td><a href="<?php echo url_for('sample/show?id='.$sample->getId()) ?>"><?php echo $sample->getNumber() ?></a></td>
				<td><a href="<?php echo url_for('sample/show?id='.$sample->getId()) ?>"><?php echo $sample->getLocation() ?></a></td>
				<td><a href="<?php echo url_for('sample/show?id='.$sample->getId()) ?>"><?php echo $sample->getEcosystemId() ?></a></td>
				<td><a href="<?php echo url_for('sample/show?id='.$sample->getId()) ?>"><?php echo $sample->getEnvironmentId() ?></a></td>
				<td><a href="<?php echo url_for('sample/show?id='.$sample->getId()) ?>"><?php echo $sample->getHabitatId() ?></a></td>
				<td><a href="<?php echo url_for('sample/show?id='.$sample->getId()) ?>"><?php echo $sample->getCollectorId() ?></a></td>
				<td><a href="<?php echo url_for('sample/show?id='.$sample->getId()) ?>"><?php echo $sample->getCollectionDate() ?></a></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<a href="<?php echo url_for('sample/new') ?>">New</a>
