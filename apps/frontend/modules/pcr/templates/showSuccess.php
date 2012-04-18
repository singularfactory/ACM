<?php
/**
 * acm : Algae Culture Management (https://github.com/singularfactory/ACM)
 * Copyright 2012, Singular Factory <info@singularfactory.com>
 *
 * This file is part of ACM
 *
 * ACM is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ACM is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ACM.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright     Copyright 2012, Singular Factory <info@singularfactory.com>
 * @package       ACM.Frontend
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */
?>
<?php slot('main_header') ?>
<span>
	PCR details
</span>
<?php include_partial('global/back_to_parent_header_action', array('title' => 'Back to DNA extraction', 'module' => 'dna_extraction', 'id' => $pcr->getDnaExtraction()->getId())) ?>
<?php include_partial('global/edit_header_action', array('module' => 'pcr', 'id' => $pcr->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'pcr', 'id' => $pcr->getId())) ?>
<?php include_partial('global/new_header_action', array('message' => 'Sequencing', 'route' => "@dna_sequence_new?pcr={$pcr->getId()}")) ?>
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
					<th class="band">Band (<?php echo sfConfig::get('app_pcr_gel_band_unit') ?>)</th>
					<th class="is_valid">Is valid?</th>
					<th></th>
				</tr>
				<?php foreach ($pcr->getGel() as $gel ): ?>
					<tr>
						<td class="object_count"><?php echo $gel->getNumber() ?></td>
						<td class="band"><?php echo $gel->getBand() ?></td>
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
			<dd><?php echo link_to($pcr->getDnaExtraction()->getCode(), "@dna_extraction_show?id={$pcr->getDnaExtraction()->getId()}") ?></dd>
			<dt>DNA forward primer:</dt>
			<dd><?php echo $pcr->getForwardPrimer()->getName() ?></dd>
			<dt>DNA reverse primer:</dt>
			<dd><?php echo $pcr->getReversePrimer()->getName() ?></dd>
			<dt>DNA Polymerase:</dt>
			<dd><?php echo $pcr->getDnaPolymerase() ?></dd>
			<dt>Program:</dt>
			<dd><?php echo $pcr->getPcrProgram()->getName() ?></dd>
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
