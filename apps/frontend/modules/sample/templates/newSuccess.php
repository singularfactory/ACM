<?php slot('content_title', 'Add a new sample') ?>
<?php
if ( $hasLocations )
	include_partial('form', array('form' => $form));
else
	echo '<p>You must '.link_to('add a location', 'location/new').' first before creating samples.</p>'
?>