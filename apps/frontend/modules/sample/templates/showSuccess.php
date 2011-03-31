<?php use_helper('Date'); use_helper('GMap') ?>

<?php slot('main_header') ?>
<span>Sample <?php echo $sample->getNumber() ?></span>
<div id="main_header_action_back" class="main_header_action">
	<?php echo link_to('Back to all samples', '@sample') ?>
</div>
<div id="main_header_action_edit" class="main_header_action">
	<?php echo link_to('Edit this sample', '@sample_edit?id='.$sample->getId()) ?>
</div>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_data_list">
		<dl>
			<dt>Notebook code:</dt>
			<dd><?php echo $sample->getNotebookCode() ?></dd>
			<dt>Location:</dt>
			<dd><?php echo $sample->getLocation()->getName() ?></dd>
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
			<dt>Collector:</dt>
			<dd><?php echo $sample->getCollector()->getFullName() ?></dd>
			<dt>Collection date:</dt>
			<dd><?php echo format_date($sample->getCollectionDate(), 'p') ?></dd>
			<dt>GPS coordinates:</dt>
			<dd><?php echo $sample->getFormattedGPSCoordinates() ?></dd>
			<dt>Remarks:</dt>
			<dd><?php echo $sample->getRemarks() ?></dd>
		</dl>
	</div>
	
	<div id="object_google_map">
		<?php include_map($googleMap, array('width' => '400px', 'height' => '400px')); ?>
	</div>
	
	<div id="object_picture_list">
		<?php $pictureAccessorMethods = array('getMicroscopicPicture', 'getDetailedPicture', 'getFieldPicture') ?>
		<?php foreach ($pictureAccessorMethods as $accessorMethod): ?>
			<?php $image = sfConfig::get('app_pictures_dir').sfConfig::get('app_sample_pictures_dir').'/'.$sample->$accessorMethod() ?>
			<?php $thumbnail = sfConfig::get('app_pictures_dir').sfConfig::get('app_sample_pictures_dir').sfConfig::get('app_thumbnails_dir').'/'.$sample->$accessorMethod() ?>
			<?php $caption = preg_replace('/^get(.+)Picture$/', "$1 picture", $accessorMethod) ?>
			<?php if ( file_exists(sfConfig::get('sf_web_dir').$thumbnail) ): ?>
			<div class="thumbnail">
				<p class="thumbnail_caption"><?php echo $caption ?></p>
				<div id="thumbnail_image">
					<a href="<?php echo $image ?>" rel="thumbnail_link" title="<?php echo $caption ?>" class="cboxElement">
						<img src="<?php echo $thumbnail ?>" alt="<?php echo $caption ?>" />
					</a>
				</div>
			</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>

	<div class="clear"></div>
</div>

<?php include_map_javascript($googleMap); ?>