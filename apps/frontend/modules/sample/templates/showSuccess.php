<?php use_helper('Date') ?>
<?php slot('content_title') ?>
<?php echo link_to('All samples', '@sample') ?>
<?php end_slot() ?>
<table>
	<tbody>
		<tr>
			<th>Number:</th>
			<td><?php echo $sample->getNumber() ?></td>
		</tr>
		<tr>
			<th>Ecosystem:</th>
			<td><?php echo $sample->getEcosystem()->getName() ?></td>
		</tr>
		<tr>
			<th>Location:</th>
			<td><?php echo $sample->getLocation() ?></td>
		</tr>
		<tr>
			<th>GPS coordinates:</th>
			<td>
				<?php echo $sample->getLatitudeDegrees() ?>
				<?php echo $sample->getLongitudeDegrees() ?>
				<?php echo $sample->getLatitudeMinutes() ?>
				<?php echo $sample->getLongitudeMinutes() ?>
			</td>
		</tr>
		<tr>
			<th>Environment:</th>
			<td><?php echo $sample->getEnvironment()->getName() ?></td>
		</tr>
		<tr>
			<th>Habitat:</th>
			<td><?php echo $sample->getHabitat()->getName() ?></td>
		</tr>
		<tr>
			<th>Ph:</th>
			<td><?php echo $sample->getPh() ?></td>
		</tr>
		<tr>
			<th>Conductivity:</th>
			<td><?php echo $sample->getConductivity() ?></td>
		</tr>
		<tr>
			<th>Temperature:</th>
			<td><?php echo $sample->getTemperature() ?></td>
		</tr>
		<tr>
			<th>Salinity:</th>
			<td><?php echo $sample->getSalinity() ?></td>
		</tr>
		<tr>
			<th>Close picture:</th>
			<td><?php echo $sample->getClosePicture() ?></td>
		</tr>
		<tr>
			<th>Laboratory picture:</th>
			<td><?php echo $sample->getLaboratoryPicture() ?></td>
		</tr>
		<tr>
			<th>Collector:</th>
			<td><?php echo $sample->getCollector()->getName() ?></td>
		</tr>
		<tr>
			<th>Collection date:</th>
			<td><?php echo format_date($sample->getCollectionDate(), 'p') ?></td>
		</tr>
		<tr>
			<th>Remarks:</th>
			<td><?php echo $sample->getRemarks() ?></td>
		</tr>
	</tbody>
</table>

<hr />

<?php echo link_to('Edit', 'sample/edit?id='.$sample->getId()) ?>
