<?php use_helper('GMap') ?>

<?php slot('main_header') ?>
<span><?php echo $location->getName() ?></span>
<?php include_partial('global/back_header_action', array('module' => 'location')) ?>
<?php include_partial('global/edit_header_action', array('module' => 'location', 'id' => $location->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'location', 'id' => $location->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
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
	
	<div id="object_google_map">
		<?php include_map($googleMap, array('width' => '400px', 'height' => '400px')); ?>
		<?php include_partial('global/gmap_legend', array('name' => 'location')) ?>
	</div>
	
	<div id="object_picture_list">
		<?php $i = 1 ?>
		<?php foreach ($location->getPictures() as $picture): ?>
		<?php if ( $picture->getFilename() === null ) continue ?>
		<?php $image = sfConfig::get('app_pictures_dir').sfConfig::get('app_location_pictures_dir').'/'.$picture->getFilename() ?>
		<?php $thumbnail = sfConfig::get('app_pictures_dir').sfConfig::get('app_location_pictures_dir').sfConfig::get('app_thumbnails_dir').'/'.$picture->getFilename() ?>
		<div class="thumbnail">
			<p class="thumbnail_caption"><?php echo "Picture $i" ?></p>
			<div id="thumbnail_image">
				<a href="<?php echo $image ?>" rel="thumbnail_link" title="Picture <?php echo $i ?>" class="cboxElement">
					<img src="<?php echo $thumbnail ?>" alt="Picture <?php echo $i ?>" />
				</a>
			</div>
		</div>
		<?php $i++ ?>
		<?php endforeach; ?>
	</div>

	<div id="location_sample_list">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	</div>
</div>

<?php include_map_javascript($googleMap); ?>