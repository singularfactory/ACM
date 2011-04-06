<?php use_helper('GMap') ?>

<?php slot('main_header') ?>
<span><?php echo $location->getName() ?></span>
<div id="main_header_action_back" class="main_header_action">
	<?php echo link_to('Back to list', '@location?page='.$sf_user->getAttribute('location_index_page')) ?>
</div>
<div id="main_header_action_edit" class="main_header_action">
	<?php echo link_to('Edit', '@location_edit?id='.$location->getId()) ?>
</div>
<div id="main_header_action_delete" class="main_header_action">
	<?php echo link_to('Delete', '@location_delete?id='.$location->getId(), array('method' => 'delete', 'confirm' => 'Are you sure you want to delete this location?')) ?>
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

	<div class="clear"></div>
</div>

<?php include_map_javascript($googleMap); ?>