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
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th><?php echo link_to('Number', 'dna_extraction/index?sort_column=id&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Class', 'dna_extraction/index?sort_column=Strain.TaxonomicClass.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Name', 'dna_extraction/index?sort_column=Strain.Genus.name&sort_direction='.$sortDirection) ?></th>
			<th class="date"><?php echo link_to('Extraction date', 'dna_extraction/index?sort_column=extraction_date&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Extraction kit', 'dna_extraction/index?sort_column=ExtractionKit.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Concentration ('.sfConfig::get('app_concentration_unit').')', 'dna_extraction/index?sort_column=concentration&sort_direction='.$sortDirection) ?></th>
			<th class="dna_availability"><?php echo link_to('DNA bank', 'dna_extraction/index?sort_column=aliquots&sort_direction='.$sortDirection)?></th>
			<th class="object_count">PCR</th>
			<th class="sequence_availability">Has sequence?</th>
			<th></th>
		</tr>
		
		<?php foreach ($pager->getResults() as $dnaExtraction): ?>
		<tr>
			<?php $url = url_for('@dna_extraction_show?id='.$dnaExtraction->getId()) ?>
			<td class="dna_extraction_code"><?php echo link_to($dnaExtraction->getNumber(), $url) ?></td>
			<?php $strain = $dnaExtraction->getStrain() ?>
			<td class="taxonomic_class_name"><?php echo link_to($strain->getTaxonomicClass(), $url) ?></td>
			<?php
				$strainName = '<span class="species_name">'.$strain->getGenus().'</span>&nbsp;';
				if ( $strain->getSpecies() !== sfConfig::get('app_unkown_species_name') ) {
					$strainName .= '<span class="species_name">'.$strain->getSpecies().'</span>';
				}
				else {
					$strainName .= $strain->getSpecies();
				}
			?>
			<td class="dna_extraction_name"><?php echo link_to($strainName, $url) ?></td>
			<td class="date">
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
			<td class="sequence_availability">-</td>

			<td class="actions">
				<a href="<?php echo $url ?>">
					<?php echo link_to('Edit', 'dna_extraction/edit?id='.$dnaExtraction->getId()) ?>
					<?php echo link_to('Delete', 'dna_extraction/delete?id='.$dnaExtraction->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
				</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'dna_extraction')) ?>
<?php endif ?>

<?php else: ?>
	<p>There are no extractions to show.</p>
<?php endif; ?>