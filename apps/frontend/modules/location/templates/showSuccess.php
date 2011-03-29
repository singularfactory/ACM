<?php use_helper('GMap') ?>

<?php slot('main_header') ?>
<span><?php echo $location->getName() ?></span>
<div id="main_header_action_back" class="main_header_action">
	<?php echo link_to('Back to all locations', '@location') ?>
</div>
<div id="main_header_action_edit" class="main_header_action">
	<?php echo link_to('Edit this location', '@location_edit?id='.$location->getId()) ?>
</div>
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
			<dt>Remarks:</dt>
			<dd><?php echo $location->getRemarks() ?></dd>
		</dl>
	</div>
	
	<div id="object_google_map">
		<?php include_map($googleMap, array('width' => '400px', 'height' => '400px')); ?>
	</div>
	
	<div id="object_picture_list">
		<script type="text/javascript" charset="utf-8">
			
		</script>
		<?php $i = 1 ?>
		<?php foreach ($location->getPictures() as $picture): ?>
		<?php $imageLink = sfConfig::get('app_pictures_dir').sfConfig::get('app_location_pictures_dir').sfConfig::get('app_thumbnails_dir').'/'.$picture->getFilename() ?>
		<div class="thumbnail">
			<a href="<?php echo $imageLink ?>" rel="thumbnail_link">
				<img src="<?php echo $imageLink ?>" alt="Picture <?php echo $i++ ?>" />
			</a>
		</div>
		<?php endforeach; ?>
		<p class="thumbnail_message">Click on an image to see it full size</p>
	</div>

	<div class="clear"></div>
</div>

<?php include_map_javascript($googleMap); ?>