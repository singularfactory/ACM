<?php slot('main_header') ?>
<span>
	PCR test details
</span>
<?php include_partial('global/back_to_parent_header_action', array('title' => 'Back to DNA extraction', 'module' => 'dna_extraction', 'id' => $pcr->getDnaExtraction()->getId())) ?>
<?php include_partial('global/edit_header_action', array('module' => 'pcr', 'id' => $pcr->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'pcr', 'id' => $pcr->getId())) ?>
<?php include_partial('global/new_header_action', array('message' => 'Register a DNA sequence', 'route' => "@dna_sequence_new?pcr={$pcr->getId()}")) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_related_models">
		<?php $nbGel = $pcr->getNbGel() ?>
		<?php if ( $nbGel > 0): ?>
		<div class="object_related_model_list">
			<h2>Gel electrophoresis</h2>
			<table>
				<tr>
					<th class="object_count">#</th>
					<th class="quality_ratio">Ratio</th>
					<th class="is_valid">Is valid?</th>
					<th></th>
				</tr>
				<?php foreach ($pcr->getGel() as $gel ): ?>
					<tr>
						<td class="object_count"><?php echo $gel->getNumber() ?></td>
						<td class="quality_ratio"><?php echo $gel->getRatio() ?></td>
						<td class="is_valid"><?php echo $gel->getFormattedIsValid() ?></td>
						<td class="actions">
							<?php echo link_to('Edit', '@pcr_gel_edit?id='.$gel->getId()) ?>
							<?php echo link_to('Delete', '@pcr_gel_delete?id='.$gel->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
						</td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
		<?php endif ?>

		<?php $nbSequences = $pcr->getNbSequences() ?>
		<?php if ( $nbSequences > 0): ?>
		<div class="object_related_model_list">
			<h2>DNA sequences</h2>
			<table>
				<tr>
					<th class="gen">Gen</th>
					<th class="date">Date</th>
					<th class="worked">Worked?</th>
					<th class="object_count">Reactions</th>
					<th></th>
				</tr>
				<?php foreach ($pcr->getSequence() as $sequence ): ?>
					<tr>
						<td class="gen"><?php echo $sequence->getGen() ?></td>
						<td class="date"><?php echo $sequence->getDate() ?></td>
						<td class="worked"><?php echo $sequence->getFormattedWorked() ?></td>
						<td class="object_count"><?php echo $sequence->getNbReactions() ?></td>
						<td class="actions">
							<?php echo link_to('Edit', '@dna_sequence_edit?id='.$sequence->getId()) ?>
							<?php echo link_to('Delete', '@dna_sequence_delete?id='.$sequence->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
						</td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
		<?php endif ?>
	</div>
	
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
			<dt>Gel:</dt>
			<dd><?php echo $nbGel ?></dd>
			<dt>DNA sequences:</dt>
			<dd><?php echo $nbSequences ?></dd>
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
