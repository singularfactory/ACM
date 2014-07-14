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
<?php use_helper('Date'); ?>

<?php slot('main_header') ?>
<span>
	Extraction <?php echo $dnaExtraction->getCode() ?>
</span>
<?php include_partial('global/back_header_action', array('module' => 'dna_extraction')) ?>
<?php include_partial('global/label_header_action', array('message' => 'Create label', 'route' => '@dna_extraction_create_label?id='.$dnaExtraction->getId())) ?>
<?php include_partial('global/edit_header_action', array('module' => 'dna_extraction', 'id' => $dnaExtraction->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'dna_extraction', 'id' => $dnaExtraction->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_data_list">
		<dl>
			<dt>Strain:</dt>
			<dd><?php echo link_to($dnaExtraction->getStrain()->getFullCode(), "@strain_show?id={$dnaExtraction->getStrain()->getId()}") ?></dd>
			<dt>Arrival date:</dt>
			<dd><?php echo $dnaExtraction->getFormattedArrivalDate() ?></dd>
			<dt>Extraction date:</dt>
			<dd><?php echo $dnaExtraction->getFormattedExtractionDate() ?></dd>
			<dt>Extraction kit:</dt>
			<dd><?php echo $dnaExtraction->getExtractionKit()->getName() ?></dd>
			<dt>Concentration:</dt>
			<dd><?php echo $dnaExtraction->getFormattedConcentration() ?></dd>
			<dt>Preservation:</dt>
			<dd><?php echo $dnaExtraction->getFormattedPreservation() ?></dd>
			<dt>260:280 quality:</dt>
			<dd><?php echo $dnaExtraction->getFormatted260280Ratio() ?></dd>
			<dt>260:230 quality:</dt>
			<dd><?php echo $dnaExtraction->getFormatted260230Ratio() ?></dd>
			<dt>Aliquots:</dt>
			<dd><?php echo $dnaExtraction->getAliquots() ?></dd>
			<dt>Is public:</dt>
			<dd><?php echo $dnaExtraction->getFormattedIsPublic() ?></dd>
			<dt>GenBank link:</dt>
			<dd><?php echo $dnaExtraction->getFormattedGenbankLink() ?></dd>
			<dt>Remarks:</dt>
			<dd><?php echo $dnaExtraction->getRemarks() ?></dd>
			<dt>Genes:</dt>
			<dd><?php echo $dnaExtraction->getGenes() ?></dd>
		</dl>
	</div>

	

	<div class="clear"></div>
</div>
