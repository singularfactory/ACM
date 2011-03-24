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
		<table>
		  <tbody>
		    <tr>
		      <th>Latitude:</th>
		      <td><?php echo $location->getLatitude() ?></td>
		    </tr>
		    <tr>
		      <th>Longitude:</th>
		      <td><?php echo $location->getLongitude() ?></td>
		    </tr>
		    <tr>
		      <th>Country:</th>
		      <td><?php echo $location->getCountry()->getName() ?></td>
		    </tr>
		    <tr>
		      <th>Region:</th>
		      <td><?php echo $location->getRegion()->getName() ?></td>
		    </tr>
		    <tr>
		      <th>Island:</th>
		      <td><?php echo $location->getIsland()->getName() ?></td>
		    </tr>
		    <tr>
		      <th>Remarks:</th>
		      <td><?php echo $location->getRemarks() ?></td>
		    </tr>
		  </tbody>
		</table>
	</div>
	
	<div id="object_picture_list">
		
	</div>
</div>