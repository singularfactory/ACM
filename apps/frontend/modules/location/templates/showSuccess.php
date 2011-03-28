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
	      <dt>Remarks:</dt>
	      <dd><?php echo $location->getRemarks() ?></dd>
		</dl>
	</div>
	
	<div id="object_google_map">
		<?php include_map($googleMap, array('width' => '400px', 'height' => '400px')); ?>
	</div>
	
	<div id="object_picture_list">
		<h2>Pictures</h2>
	</div>

	<div class="clear"></div>
</div>

<?php include_map_javascript($googleMap); ?>