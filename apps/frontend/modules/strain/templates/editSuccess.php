<?php use_helper('CrossAppLink', 'Thumbnail', 'PictureUpload') ?>

<?php slot('main_header', 'Edit this strain') ?>
<?php include_partial('form', array('form' => $form, 'sampleCode' => $sampleCode)) ?>
