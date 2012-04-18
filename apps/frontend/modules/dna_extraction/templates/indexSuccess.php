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
<?php use_helper('Date') ?>

<?php slot('main_header') ?>
<span>All DNA extractions</span>
	<?php include_partial('global/search_box_header_action', array('route' => '@dna_extraction_search?criteria=')) ?>
	<?php include_partial('global/new_header_action', array('message' => 'Add a new extraction', 'route' => '@dna_extraction_new')) ?>
<?php end_slot() ?>

<?php if ( $pager->count() ): ?>
<table id="dna_extraction_list">
	<tbody>
		<tr>
			<?php if ( $allResults ) $allResults = '&all=1'; else $allResults = '' ?>
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th><?php echo link_to('Number', '@dna_extraction?sort_column=id&sort_direction='.$sortDirection.$allResults) ?></th>
			<th><?php echo link_to('Class', '@dna_extraction?sort_column=Strain.TaxonomicClass.name&sort_direction='.$sortDirection.$allResults) ?></th>
			<th><?php echo link_to('Name', '@dna_extraction?sort_column=Strain.Genus.name&sort_direction='.$sortDirection.$allResults) ?></th>
			<th class="date extraction_date"><?php echo link_to('Extraction date', '@dna_extraction?sort_column=extraction_date&sort_direction='.$sortDirection.$allResults) ?></th>
			<th><?php echo link_to('Extraction kit', '@dna_extraction?sort_column=ExtractionKit.name&sort_direction='.$sortDirection.$allResults) ?></th>
			<th><?php echo link_to('Concentration ('.sfConfig::get('app_concentration_unit').')', '@dna_extraction?sort_column=concentration&sort_direction='.$sortDirection.$allResults) ?></th>
			<th class="dna_availability"><?php echo link_to('DNA bank', '@dna_extraction?sort_column=aliquots&sort_direction='.$sortDirection.$allResults)?></th>
			<th class="object_count">PCR</th>
			<th class="sequence_availability">Has sequence?</th>
			<th></th>
		</tr>

		<?php foreach ($pager->getResults() as $dnaExtraction): ?>
		<tr>
			<?php $url = url_for('@dna_extraction_show?id='.$dnaExtraction->getId()) ?>
			<td class="dna_extraction_code"><?php echo link_to($dnaExtraction->getCode(), $url) ?></td>
			<?php $strain = $dnaExtraction->getStrain() ?>
			<td class="taxonomic_class_name"><?php echo link_to($strain->getTaxonomicClass(), $url) ?></td>
			<?php
				$strainName = '<span class="species_name">'.$strain->getGenus().'</span>&nbsp;';
				if ( $strain->getSpecies() !== sfConfig::get('app_unknown_species_name') ) {
					$strainName .= '<span class="species_name">'.$strain->getSpecies().'</span>';
				}
				else {
					$strainName .= $strain->getSpecies();
				}
			?>
			<td class="dna_extraction_name"><?php echo link_to($strainName, $url) ?></td>
			<td class="date extraction_date">
				<?php
					if ( $date = $dnaExtraction->getExtractionDate() ) {
						 $date = format_date($dnaExtraction->getExtractionDate(), 'p');
					}
					else {
						$date = sfConfig::get('app_no_data_message');
					}

					echo link_to($date, $url);
				?>
			</td>
			<td class="extraction_kit"><?php echo link_to($dnaExtraction->getExtractionKit()->getName(), $url) ?></td>
			<td class="concentration"><?php echo link_to($dnaExtraction->getFormattedConcentration(), $url) ?></td>
			<td class="aliquots"><?php echo link_to($dnaExtraction->getFormattedAliquots(), $url) ?></td>
			<td class="object_count"><?php echo link_to($dnaExtraction->getNbPcr(), $url) ?></td>
			<td class="sequence_availability"><?php echo link_to($dnaExtraction->getFormattedHasDnaSequence(), $url) ?></td>

			<td class="actions">
				<a href="<?php echo $url ?>">
					<?php echo link_to('Edit', '@dna_extraction_edit?id='.$dnaExtraction->getId()) ?>
					<?php echo link_to('Delete', '@dna_extraction_delete?id='.$dnaExtraction->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
				</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'dna_extraction', 'sort_direction' => $sortDirection, 'sort_column' => $sortColumn, 'warning' => false)) ?>
<?php endif ?>

<?php else: ?>
	<p>There are no extractions to show.</p>
<?php endif; ?>