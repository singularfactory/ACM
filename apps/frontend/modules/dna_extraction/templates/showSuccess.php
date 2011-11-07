<?php use_helper('Date'); ?>

<?php slot('main_header') ?>
<span>
	Extraction <?php echo $dnaExtraction->getCode() ?>
</span>
<?php include_partial('global/back_header_action', array('module' => 'dna_extraction')) ?>
<?php include_partial('global/edit_header_action', array('module' => 'dna_extraction', 'id' => $dnaExtraction->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'dna_extraction', 'id' => $dnaExtraction->getId())) ?>
<?php include_partial('global/new_header_action', array('message' => 'Add a PCR', 'route' => "@pcr_new?dna_extraction={$dnaExtraction->getId()}")) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_data_list">
		<dl>
			<dt>Strain:</dt>
			<dd><?php echo link_to($dnaExtraction->getStrain()->getFullCode(), "@strain_show?id={$dnaExtraction->getStrain()->getId()}") ?></dd>
			<dt>Arrival date:</dt>
			<dd><?php echo format_date($dnaExtraction->getArrivalDate(), 'p') ?></dd>
			<dt>Extraction date:</dt>
			<dd><?php echo format_date($dnaExtraction->getExtractionDate(), 'p') ?></dd>
			<dt>Extraction kit:</dt>
			<dd><?php echo $dnaExtraction->getExtractionKit()->getName() ?></dd>
			<dt>Concentration:</dt>
			<dd><?php echo $dnaExtraction->getFormattedConcentration() ?></dd>
			<dt>260:280 quality:</dt>
			<dd><?php echo $dnaExtraction->getFormatted260280Ratio() ?></dd>
			<dt>260:230 quality:</dt>
			<dd><?php echo $dnaExtraction->getFormatted260230Ratio() ?></dd>
			<dt>PCR tests:</dt>
			<dd>
				<?php $nbPcr = $pcrResults->count() ?>
				<?php echo $nbPcr ?>
				<?php if ( $nbPcr > 0 ): ?>
					<a href="#dna_extraction_pcr_list" title="List of PCR tests made with this extraction" class="page_jump">see below</a>
				<?php endif; ?>
			</dd>
			<dt>Aliquots:</dt>
			<dd><?php echo $dnaExtraction->getAliquots() ?></dd>
			<dt>Is public:</dt>
			<dd><?php echo $dnaExtraction->getFormattedIsPublic() ?></dd>
			<dt>GenBank link:</dt>
			<dd><?php echo $dnaExtraction->getFormattedGenbankLink() ?></dd>
			<dt>Remarks:</dt>
			<dd><?php echo $dnaExtraction->getRemarks() ?></dd>
		</dl>
	</div>
	
	<?php if ( $nbPcr > 0 ): ?>
	<div id="dna_extraction_pcr_list" class="object_related_model_long_list">
		<h2>PCR tests</h2>
		<table>
			<tr>
				<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
				<?php $dnaExtractionId = $dnaExtraction->getId() ?>
				
				
				<th><?php echo link_to('DNA polymerase', "dna_extraction/show?id=$dnaExtractionId&sort_column=DnaPolymerase.name&sort_direction=$sortDirection") ?></th>
				<th class="dna_primer"><?php echo link_to('Forward primer', "dna_extraction/show?id=$dnaExtractionId&sort_column=ForwardPrimer.name&sort_direction=$sortDirection") ?></th>
				<th class="dna_primer"><?php echo link_to('Reverse primer', "dna_extraction/show?id=$dnaExtractionId&sort_column=ReversePrimer.name&sort_direction=$sortDirection") ?></th>
				<th class="pcr_concentration"><?php echo link_to('Concentration', "dna_extraction/show?id=$dnaExtractionId&sort_column=concentration&sort_direction=$sortDirection") ?></th>
				<th class="quality_ratio"><?php echo link_to('260:280', "dna_extraction/show?id=$dnaExtractionId&sort_column=260_280_ratio&sort_direction=$sortDirection") ?></th>
				<th class="quality_ratio"><?php echo link_to('260:230', "dna_extraction/show?id=$dnaExtractionId&sort_column=260_230_ratio&sort_direction=$sortDirection") ?></th>
				<th class="can_be_sequenced"><?php echo link_to('Can be sequenced', "dna_extraction/show?id=$dnaExtractionId&sort_column=can_be_sequenced&sort_direction=$sortDirection") ?></th>
				<th></th>
			</tr>
			<?php foreach ($pcrResults->getResults() as $pcr ): ?>
				<?php $url = url_for('@pcr_show?id='.$pcr->getId()) ?>
				<tr>
					<td><?php echo link_to($pcr->getDnaPolymerase(), $url) ?></td>
					<td class="dna_primer"><?php echo link_to($pcr->getForwardPrimer(), $url) ?></td>
					<td class="dna_primer"><?php echo link_to($pcr->getReversePrimer(), $url) ?></td>
					<td class="pcr_concentration"><?php echo link_to($pcr->getConcentration(), $url) ?></td>
					<td class="quality_ratio"><?php echo link_to($pcr->get260280Ratio(), $url) ?></td>
					<td class="quality_ratio"><?php echo link_to($pcr->get260230Ratio(), $url) ?></td>
					<td class="can_be_sequenced"><?php echo link_to($pcr->getFormattedCanBeSequenced(), $url) ?></td>
					<td class="actions">
						<a href="<?php echo $url ?>">
							<?php echo link_to('Edit', '@pcr_edit?id='.$pcr->getId()) ?>
							<?php echo link_to('Delete', '@pcr_delete?id='.$pcr->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
						</a>
					</td>
				</tr>
			<?php endforeach ?>
		</table>
	</div>
	<?php endif ?>
	
	<div class="clear"></div>
</div>
