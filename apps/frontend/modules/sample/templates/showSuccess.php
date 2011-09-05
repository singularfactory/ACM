<?php use_helper('Date'); use_helper('GMap') ?>

<?php slot('main_header') ?>
<span>Sample <?php echo $sample->getCode() ?></span>
<?php include_partial('global/back_header_action', array('module' => 'sample')) ?>
<?php include_partial('global/edit_header_action', array('module' => 'sample', 'id' => $sample->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'sample', 'id' => $sample->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_google_map">
		<?php include_map($googleMap, array('width' => '400px', 'height' => '400px')); ?>
		<?php include_partial('global/gmap_legend', array('name' => 'sample')) ?>
	</div>
	
	<div id="object_data_list">
		<dl>
			<dt>Notebook code:</dt>
			<dd><?php echo $sample->getNotebookCode() ?></dd>
			<dt>Location:</dt>
			<dd><?php echo link_to($sample->getLocation()->getName(), "@location_show?id={$sample->getLocation()->getId()}") ?></dd>
			<dt>Environment:</dt>
			<dd><?php echo $sample->getEnvironment()->getName() ?></dd>
			<dt>Is extremophile:</dt>
			<dd><?php echo $sample->getFormattedIsExtremophile() ?></dd>
			<dt>Habitat:</dt>
			<dd><?php echo $sample->getHabitat()->getName() ?></dd>
			<dt>Ph:</dt>
			<dd><?php echo $sample->getFormattedPh() ?></dd>
			<dt>Conductivity:</dt>
			<dd><?php echo $sample->getFormattedConductivity() ?></dd>
			<dt>Temperature:</dt>
			<dd><?php echo $sample->getFormattedTemperature() ?></dd>
			<dt>Salinity:</dt>
			<dd><?php echo $sample->getFormattedSalinity() ?></dd>
			<dt>Altitude:</dt>
			<dd><?php echo $sample->getFormattedAltitude() ?></dd>
			<dt>Radiation:</dt>
			<dd><?php echo $sample->getRadiation()->getName() ?></dd>
			<dt>Strains:</dt>
			<dd>
				<?php echo $nbStrains = $sample->getNbStrains() ?>
				<?php if ( $nbStrains > 0 ): ?>
					<a href="#sample_strains_list" title="List of strains who come from this sample" class="page_jump">see below</a>
				<?php endif; ?>
			</dd>
			<dt>Collector:</dt>
			<dd><?php echo $sample->getCollector() ?></dd>
			<dt>Collection date:</dt>
			<dd><?php echo $sample->getFormattedCollectionDate() ?></dd>
			<dt>GPS coordinates:</dt>
			<dd><?php echo $sample->getFormattedGPSCoordinates() ?></dd>
			<dt>Remarks:</dt>
			<dd><?php echo $sample->getRemarks() ?></dd>
		</dl>
	</div>
		
	<?php if ( $sample->getNbFieldPictures() > 0 ): ?>
	<div class="object_related_model_long_list">
		<h2>Field pictures</h2>
		<?php $i = 1 ?>
		<?php foreach ($sample->getFieldPictures() as $picture): ?>
		<?php if ( $picture->getFilename() === null ) continue ?>
		<div class="thumbnail">
			<div class="thumbnail_image">
				<a href="<?php echo $picture->getFilenameWithPath() ?>" rel="thumbnail_link" title="Picture <?php echo $i ?>" class="cboxElement">
					<img src="<?php echo $picture->getThumbnail() ?>" alt="Picture <?php echo $i ?>" />
				</a>
			</div>
		</div>
		<?php $i++ ?>
		<?php endforeach; ?>
	</div>
	<?php endif ?>
	
	<?php if ( $sample->getNbDetailedPictures() > 0 ): ?>
	<div class="object_related_model_long_list">
		<h2>Detailed pictures</h2>
		<?php $i = 1 ?>
		<?php foreach ($sample->getDetailedPictures() as $picture): ?>
		<?php if ( $picture->getFilename() === null ) continue ?>
		<div class="thumbnail">
			<div class="thumbnail_image">
				<a href="<?php echo $picture->getFilenameWithPath() ?>" rel="thumbnail_link" title="Picture <?php echo $i ?>" class="cboxElement">
					<img src="<?php echo $picture->getThumbnail() ?>" alt="Picture <?php echo $i ?>" />
				</a>
			</div>
		</div>
		<?php $i++ ?>
		<?php endforeach; ?>
	</div>
	<?php endif ?>

	<?php if ( $sample->getNbMicroscopicPictures() > 0 ): ?>
	<div class="object_related_model_long_list">
		<h2>Microscopic pictures</h2>
		<?php $i = 1 ?>
		<?php foreach ($sample->getMicroscopicPictures() as $picture): ?>
		<?php if ( $picture->getFilename() === null ) continue ?>
		<div class="thumbnail">
			<div class="thumbnail_image">
				<a href="<?php echo $picture->getFilenameWithPath() ?>" rel="thumbnail_link" title="Picture <?php echo $i ?>" class="cboxElement">
					<img src="<?php echo $picture->getThumbnail() ?>" alt="Picture <?php echo $i ?>" />
				</a>
			</div>
		</div>
		<?php $i++ ?>
		<?php endforeach; ?>
	</div>
	<?php endif ?>

	<?php if ( $nbStrains > 0): ?>
	<div id="sample_strains_list" class="object_related_model_long_list">
		<h2>Strains</h2>
		<table>
			<tr>
				<th class="code">Code</th>
				<th>Class:</th>
				<th>Genus:</th>
				<th>Species:</th>
			</tr>
			<?php foreach ($sample->getStrains() as $strain ): ?>
			<?php $url = '@strain_show?id='.$strain->getId() ?>
			<tr>
				<td><?php echo link_to($strain->getCode(), $url) ?></td>
				<td><?php echo link_to($strain->getTaxonomicClass(), $url) ?></td>
				<td><span class="species_name"><?php echo link_to($strain->getGenus(), $url) ?></span></td>
				<td>
					<?php $strainSpecies = $strain->getSpecies() ?>
					<?php if ( $strainSpecies !== sfConfig::get('app_unknown_species_name') ): ?>
					<span class="species_name"><?php echo link_to($strainSpecies, $url) ?></span>
					<?php else: ?>
					<?php echo link_to($strainSpecies, $url) ?>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach ?>
		</table>
	</div>
	<?php endif ?>
	
	<div class="clear"></div>
</div>

<?php include_map_javascript($googleMap); ?>