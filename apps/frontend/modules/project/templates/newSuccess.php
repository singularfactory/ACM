<?php slot('main_header', 'Add a new project') ?>
<?php
if ( !$hasStrains || !$hasSamples)
	echo '<p>You must first '.link_to('add a strain', 'strain/new').' or '.link_to('add a sample', 'sample/new').' before creating projects.</p>';
else
	include_partial('form', array('form' => $form));
?>