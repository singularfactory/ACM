<?php use_helper('Thumbnail', 'PictureUpload') ?>
<?php slot('main_header', 'Add a new identification request') ?>
<?php
if ( ! $hasSamples )
	echo sprintf('<p>You must %s before registering a new identification request</p>', link_to('add at least one sample', '@sample_new'));
else
	include_partial('form', array('form' => $form));
?>