<?php use_helper('Date') ?>
<?php slot('main_header') ?>
<?php echo link_to('Back to all samples', '@sample') ?>
<?php end_slot() ?>
<table>
	<tbody>
		<tr>
			<td>Number:</td>
			<td><?php echo $sample->getNumber() ?></td>
		</tr>
		<tr>
			<td>Notebook code:</td>
			<td><?php echo $sample->getNotebookCode() ?></td>
		</tr>
		<tr>
			<td>Location:</td>
			<td><?php echo $sample->getLocation()->getName() ?></td>
		</tr>
		<tr>
			<td>GPS coordinates:</td>
			<td><?php echo $sample->getFormattedGPSCoordinates() ?></td>
		</tr>
		<tr>
			<td>Environment:</td>
			<td><?php echo $sample->getEnvironment()->getName() ?></td>
		</tr>
			<td>Is extremophile?</td>
			<td><?php echo $sample->getFormattedIsExtremophile() ?></td>
		<tr>
			<td>Habitat:</td>
			<td><?php echo $sample->getHabitat()->getName() ?></td>
		</tr>
		<tr>
			<td>Ph:</td>
			<td><?php echo $sample->getFormattedPh() ?></td>
		</tr>
		<tr>
			<td>Conductivity:</td>
			<td><?php echo $sample->getFormattedConductivity() ?></td>
		</tr>
		<tr>
			<td>Temperature:</td>
			<td><?php echo $sample->getFormattedTemperature() ?> </td>
		</tr>
		<tr>
			<td>Salinity:</td>
			<td><?php echo $sample->getFormattedSalinity() ?></td>
		</tr>
		<tr>
			<td>Altitude:</td>
			<td><?php echo $sample->getFormattedAltitude() ?></td>
		</tr>
		
		<tr>
			<td>Radiation:</td>
			<td><?php echo $sample->getRadiation()->getName() ?></td>
		</tr>
		
		<tr>
			<td>Field picture:</td>
			<td><?php echo $sample->getFieldPicture() ?></td>
		</tr>
		<tr>
			<td>Detailed picture:</td>
			<td><?php echo $sample->getDetailedPicture() ?></td>
		</tr>
		<tr>
			<td>Microscopic picture:</td>
			<td><?php echo $sample->getMicroscopicPicture() ?></td>
		</tr>
		<tr>
			<td>Collector:</td>
			<td><?php echo $sample->getCollector()->getFullName() ?></td>
		</tr>
		<tr>
			<td>Collection date:</td>
			<td><?php echo format_date($sample->getCollectionDate(), 'p') ?></td>
		</tr>
		<tr>
			<td>Remarks:</td>
			<td><?php echo $sample->getRemarks() ?></td>
		</tr>
	</tbody>
</table>

<hr />

<?php echo link_to('Edit', 'sample/edit?id='.$sample->getId()) ?>
