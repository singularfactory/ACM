<?php use_helper('Thumbnail', 'PictureUpload') ?>

<?php slot('main_header', 'Add a new sample') ?>
<?php
if ( $hasLocations )
	include_partial('form', array('form' => $form, 'locationName' => $locationName));
else
	echo '<p>You must '.link_to('add a location', 'location/new').' first before creating samples.</p>'
?>