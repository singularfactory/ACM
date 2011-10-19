<?php use_helper('CrossAppLink', 'Thumbnail', 'PictureUpload') ?>

<?php slot('main_header', 'Add a new strain') ?>
<?php
if ( ! $hasSamples )
	echo '<p>You must '.link_to('add a sample', 'sample/new').' first before creating strains.</p>';
elseif ( ! $hasTaxonomicClasses )
	echo '<p>You must '.link_to('add a taxonomic class', link_to_backend('taxonomic_class_new')).' first before creating strains.</p>';
elseif ( ! $hasGenus )
	echo '<p>You must '.link_to('add a genus', link_to_backend('genus_new')).' first before creating strains.</p>';
elseif ( ! $hasSpecies )
	echo '<p>You must '.link_to('add a species', link_to_backend('species_new')).' first before creating strains.</p>';
elseif ( ! $hasAuthorities )
	echo '<p>You must '.link_to('add an authority', link_to_backend('authority_new')).' first before creating strains.</p>';
elseif ( ! $hasIsolators )
	echo '<p>You must '.link_to('add an isolator', link_to_backend('isolator_new')).' first before creating strains.</p>';
elseif ( ! $hasCryopreservationMethods )
	echo '<p>You must '.link_to('add a cryopreservation method', link_to_backend('cryopreservation_method_new')).' first before creating strains.</p>';
elseif ( ! $hasCultureMedia )
	echo '<p>You must '.link_to('add a culture medium', '@culture_medium_new').' first before creating strains.</p>';
else
	include_partial('form', array('form' => $form, 'sampleCode' => $sampleCode));
?>