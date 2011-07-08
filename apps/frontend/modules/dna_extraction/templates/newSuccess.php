<?php use_helper('CrossAppLink') ?>

<?php slot('main_header', 'Add a new DNA extraction') ?>
<?php
if ( ! $hasStrains )
	echo '<p>You must '.link_to('add a strain', 'strain/new').' first before creating DNA extractions.</p>';
elseif ( ! $hasExtractionKits )
	echo '<p>You must '.link_to('add a extraction kit', link_to_backend('extraction_kit_new')).' first before creating DNA extractions.</p>';
else
	include_partial('form', array('form' => $form));
?>