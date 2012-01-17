<?php use_helper('CrossAppLink') ?>

<?php slot('main_header', 'Add a new project transference') ?>
<?php
if ( !$hasStrains || !$hasSamples )
	echo '<p>You must first '.link_to('add a strain', 'strain/new').' or '.link_to('add a sample', 'sample/new').' before creating projects.</p>';
elseif( !$hasProjectNames ) {
	echo '<p>You must '.link_to('add a project name', link_to_backend('project_name_new')).' first before creating projects.</p>';
}
else
	include_partial('form', array('form' => $form));
?>