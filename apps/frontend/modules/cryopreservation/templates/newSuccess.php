<?php use_helper('CrossAppLink') ?>

<?php slot('main_header', 'Add a new cryopreservation') ?>
<?php
if ( !$hasStrains || !$hasSamples || !$hasExternalStrains )
	echo '<p>You must first '.link_to('add a strain', 'strain/new').', '.link_to('add a sample', 'sample/new').' or '.link_to('choose a strain from research collection', 'external_strain/index').' before creating cryopreservations.</p>';
else
	include_partial('form', array('form' => $form));
?>