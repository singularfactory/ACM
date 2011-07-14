<?php use_helper('CrossAppLink') ?>

<?php slot('main_header', 'Register a DNA sequence') ?>
<?php
if ( ! $pcr )
	echo '<p>Every DNA sequence must be linked to a PCR product of a DNA extraction.'.link_to('Go to the extractions list', '@dna_extraction').' and choose one.</p>';
else
	include_partial('form', array('form' => $form));
?>