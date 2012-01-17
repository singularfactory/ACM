<?php use_helper('CrossAppLink') ?>

<?php slot('main_header', 'Add a new cryopreservation') ?>
<?php
if ( !$hasStrains || !$hasSamples )
	echo '<p>You must first '.link_to('add a strain', 'strain/new').' or '.link_to('add a sample', 'sample/new').' before creating cryopreservations.</p>';
else
	include_partial('form', array('form' => $form));
?>