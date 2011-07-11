<?php slot('main_header') ?>
<span>
	PCR test details
</span>
<?php include_partial('global/back_to_parent_header_action', array('title' => 'Back to DNA extraction', 'module' => 'dna_extraction', 'id' => $pcr->getDnaExtraction()->getId())) ?>
<?php include_partial('global/edit_header_action', array('module' => 'pcr', 'id' => $pcr->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'pcr', 'id' => $pcr->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_data_list">
		<dl>
			<dt>DNA extraction:</dt>
			<dd><?php echo link_to($pcr->getDnaExtraction()->getNumber(), "@dna_extraction_show?id={$pcr->getDnaExtraction()->getId()}") ?></dd>
			<dt>DNA forward primer:</dt>
			<dd><?php echo $pcr->getForwardPrimer()->getStrand() ?></dd>
			<dt>DNA reverse primer:</dt>
			<dd><?php echo $pcr->getReversePrimer()->getStrand() ?></dd>
			<dt>Polymerase kit:</dt>
			<dd><?php echo $pcr->getDnaPolymerase() ?></dd>
			<dt>Concentration:</dt>
			<dd><?php echo $pcr->getFormattedConcentration() ?></dd>
			<dt>260:280 quality:</dt>
			<dd><?php echo $pcr->get260280Ratio() ?></dd>
			<dt>260:230 quality:</dt>
			<dd><?php echo $pcr->get260230Ratio() ?></dd>
			<dt>Can be sequenced:</dt>
			<dd><?php echo $pcr->getFormattedCanBeSequenced() ?></dd>
			<dt>Remarks:</dt>
			<dd><?php echo $pcr->getRemarks() ?></dd>
		</dl>
	</div>
	
	<div class="clear"></div>
</div>
