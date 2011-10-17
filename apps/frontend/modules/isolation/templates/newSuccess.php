<?php use_helper('CrossAppLink') ?>

<?php slot('main_header', 'Add a new isolation') ?>
<?php
if ( ! $hasPurificationMethods )
	echo '<p>You must '.link_to('add a purification method', link_to_backend('purification_method_new')).' first before creating isolations.</p>';
else
	include_partial('form', array('form' => $form));
?>