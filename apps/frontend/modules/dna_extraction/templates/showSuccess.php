<?php use_helper('Date'); ?>

<?php slot('main_header') ?>
<span>
	<?php echo $dnaExtraction->getNumber() ?>
</span>
<?php include_partial('global/back_header_action', array('module' => 'dna_extraction')) ?>
<?php include_partial('global/edit_header_action', array('module' => 'dna_extraction', 'id' => $dnaExtraction->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'dna_extraction', 'id' => $dnaExtraction->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_data_list">
		<dl>
			<dt>Strain:</dt>
			<dd><?php echo link_to($dnaExtraction->getStrain()->getNumber(), "@strain_show?id={$dnaExtraction->getStrain()->getId()}") ?></dd>
			<dt>Arrival date:</dt>
			<dd><?php echo format_date($dnaExtraction->getArrivalDate(), 'p') ?></dd>
			<dt>Extraction date:</dt>
			<dd><?php echo format_date($dnaExtraction->getExtractionDate(), 'p') ?></dd>
			<dt>Extraction kit:</dt>
			<dd><?php echo $dnaExtraction->getExtractionKit()->getName() ?></dd>
			<dt>Concentration:</dt>
			<dd><?php echo $dnaExtraction->getFormattedConcentration() ?></dd>
			<dt>260:280 quality:</dt>
			<dd><?php echo $dnaExtraction->get260280Ratio() ?></dd>
			<dt>260:230 quality:</dt>
			<dd><?php echo $dnaExtraction->get260230Ratio() ?></dd>
			<dt>Aliquots:</dt>
			<dd><?php echo $dnaExtraction->getAliquots() ?></dd>
			<dt>Is public:</dt>
			<dd><?php echo $dnaExtraction->getFormattedIsPublic() ?></dd>
			<dt>GenBank link:</dt>
			<dd><?php echo $dnaExtraction->getGenbankLink() ?></dd>
			<dt>Remarks:</dt>
			<dd><?php echo $dnaExtraction->getRemarks() ?></dd>
		</dl>
	</div>
	
	<div class="clear"></div>
</div>
