<?php use_helper('CrossAppLink') ?>

<?php slot('main_header', 'Add a new project') ?>
<?php
if ( ! $hasStrains )
	echo '<p>You must '.link_to('add a strain', 'strain/new').' first before creating projects.</p>';
else
	include_partial('form', array('form' => $form));
?>