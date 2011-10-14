<?php use_helper('CrossAppLink') ?>

<?php slot('main_header', 'Add a new maintenance deposit') ?>
<?php $warning = '<p>You must ### before registering a new maintenance deposit</p>' ?>
<?php
if ( ! $hasIdentifiers )
	echo str_replace('###', link_to('add at least one identifier', link_to_backend('identifier_new')), $warning);
elseif ( ! $hasDepositors )
	echo str_replace('###', link_to('add at least one depositor', link_to_backend('depositor_new')), $warning);
elseif ( ! $hasCultureMedia )
	echo str_replace('###', link_to('add at least one culture medium', '@culture_media_new'), $warning);
elseif ( ! $hasLocations )
	echo str_replace('###', link_to('add at least one location', '@location_new'), $warning);
else
	include_partial('form', array('form' => $form));
?>