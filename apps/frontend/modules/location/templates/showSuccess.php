<?php use_helper('GMap') ?>

<?php slot('main_header') ?>
<span><?php echo $location->getName() ?></span>
<?php include_partial('global/back_header_action', array('module' => 'location')) ?>
<?php include_partial('global/edit_header_action', array('module' => 'location', 'id' => $location->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'location', 'id' => $location->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	
	
	<div id="object_google_map">
		<?php include_map($googleMap, array('width' => '400px', 'height' => '400px')); ?>
		<?php include_partial('global/gmap_legend', array('name' => 'location')) ?>
	</div>
	
	<div id="object_data_list">
		<dl>
			<dt>Country:</dt>
			<dd><?php echo $location->getCountry()->getName() ?></dd>
			<dt>Region:</dt>
			<dd><?php echo $location->getRegion()->getName() ?></dd>
			<dt>Island:</dt>
			<dd><?php echo $location->getIsland()->getName() ?></dd>
			<dt>GPS coordinates:</dt>
			<dd><?php echo $location->getFormattedGPSCoordinates() ?></dd>
			<dt>Samples:</dt>
			<dd>
				<?php echo $nbSamples = $location->getNbSamples() ?>
				<?php if ( $nbSamples > 0 ): ?>
					<a href="#location_sample_list" title="List of samples linked to this location" class="page_jump">see below</a>
				<?php endif; ?>
			</dd>
			<dt>Remarks:</dt>
			<dd><?php echo $location->getRemarks() ?></dd>
		</dl>
	</div>

	<?php if ( $location->getNbPictures() > 0 ): ?>
	<div id="object_picture_list">
		<h2>Pictures</h2>
		<?php $i = 1 ?>
		<?php foreach ($location->getPictures() as $picture): ?>
		<?php if ( $picture->getFilename() === null ) continue ?>
		<?php $image = sfConfig::get('app_pictures_dir').sfConfig::get('app_location_pictures_dir').'/'.$picture->getFilename() ?>
		<?php $thumbnail = sfConfig::get('app_pictures_dir').sfConfig::get('app_location_pictures_dir').sfConfig::get('app_thumbnails_dir').'/'.$picture->getFilename() ?>
		<div class="thumbnail">
			<div id="thumbnail_image">
				<a href="<?php echo $image ?>" rel="thumbnail_link" title="Picture <?php echo $i ?>" class="cboxElement">
					<img src="<?php echo $thumbnail ?>" alt="Picture <?php echo $i ?>" />
				</a>
			</div>
		</div>
		<?php $i++ ?>
		<?php endforeach; ?>
	</div>
	<?php endif ?>

	<?php if ( $nbSamples > 0): ?>
	<div id="location_sample_list">
		<h2>Samples</h2>
		<table>
			<tr>
				<th>Number</th>
				<th>Collector</th>
				<th>Date</th>
			</tr>
			<?php foreach ($location->getSamples() as $sample ): ?>
				<tr>
					<td><?php echo link_to($sample->getNumber(), '@sample_show?id='.$sample->getId()) ?></td>
					<td><?php echo link_to($sample->getCollector(), '@sample_show?id='.$sample->getId()) ?></td>
					<td><?php echo link_to($sample->getCollectionDate(), '@sample_show?id='.$sample->getId()) ?></td>
				</tr>
			<?php endforeach ?>
		</table>
	</div>
	<?php endif ?>
	
	<div class="clear"></div>
</div>

<?php include_map_javascript($googleMap); ?>