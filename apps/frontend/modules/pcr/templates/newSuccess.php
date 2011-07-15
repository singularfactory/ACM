<?php use_helper('CrossAppLink') ?>

<?php slot('main_header', 'Add a PCR') ?>
<?php
if ( ! $dnaExtraction )
	echo '<p>Every PCR test must be linked to a DNA extraction.'.link_to('Go to the DNA extractions list', '@dna_extraction').' and choose a extraction.</p>';
elseif ( ! $hasDnaPrimers )
	echo '<p>You must '.link_to('add a DNA primer', link_to_backend('dna_primer_new')).' first before creating PCR tests.</p>';
elseif ( ! $hasDnaPolymeraseKits )
	echo '<p>You must '.link_to('add a DNA polymerase kit', link_to_backend('dna_polymerase_new')).' first before creating PCR tests.</p>';
else
	include_partial('form', array('form' => $form));
?>