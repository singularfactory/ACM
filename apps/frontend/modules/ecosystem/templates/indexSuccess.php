<table id="ecosystems_list">
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
				<td id="ecosystems_list_name_column"><a href="<?php echo url_for('ecosystem/edit?id='.$ecosystem->getId()) ?>"><?php echo $ecosystem->getName() ?></a></td>
				<td id="ecosystems_list_city_column"><a href="<?php echo url_for('ecosystem/edit?id='.$ecosystem->getId()) ?>"><?php echo $ecosystem->getCity() ?></a></td>
				<td id="ecosystems_list_picture_column"><a href="<?php echo url_for('ecosystem/edit?id='.$ecosystem->getId()) ?>"><?php echo ($ecosystem->getPicture())?'yes':'no' ?></a></td>
				<td id="ecosystems_list_count_column"><a href="<?php echo url_for('ecosystem/edit?id='.$ecosystem->getId()) ?>"><?php echo count($ecosystem->getSamples()) ?></a></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<a href="<?php echo url_for('ecosystem/new') ?>">New</a>
