<?php use_helper('Date'); ?>

<?php slot('main_header') ?>
<span>
	<?php echo $strain->getCode() ?> - <?php echo $strainClass = $strain->getTaxonomicClass() ?>
	<span class="species_name"><?php echo $strainGenus = $strain->getGenus() ?></span>
	<?php if ( ($strainSpecies = $strain->getSpecies()) !== sfConfig::get('app_unknown_species_name') ): ?>
		<span class="species_name"><?php echo $strainSpecies ?></span>
	<?php else: ?>
		<?php echo $strainSpecies ?>
	<?php endif; ?>
</span>
<?php include_partial('global/back_header_action', array('module' => 'strain')) ?>
<?php include_partial('global/edit_header_action', array('module' => 'strain', 'id' => $strain->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'strain', 'id' => $strain->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_related_models">
		<?php $nbRelatives = $strain->getNbRelatives() ?>
		<?php if ( $nbRelatives > 0): ?>
		<div class="object_related_model_list">
			<h2>Relatives</h2>
			<table>
				<tr>
					<th class="name">Name</th>
				</tr>
				<?php foreach ($strain->getRelatives() as $relative ): ?>
					<tr>
						<td><?php echo $relative->getName() ?></td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
		<?php endif ?>
		
		<?php $nbCultureMedia = $strain->getNbCultureMedia() ?>
		<?php if ( $nbCultureMedia > 0): ?>
		<div class="object_related_model_list">
			<h2>Culture media</h2>
			<table>
				<tr>
					<th class="culture_medium_code">Code</th>
					<th class="culture_medium_name">Name</th>
				</tr>
				<?php foreach ($strain->getCultureMedia() as $cultureMedium ): ?>
					<?php $url = '@culture_medium_show?id='.$cultureMedium->getId() ?>
					<tr>
						<td class="culture_medium_code"><?php echo link_to($cultureMedium->getCode(), $url) ?></td>
						<td class="culture_medium_name"><?php echo link_to($cultureMedium->getName(), $url) ?></td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
		<?php endif ?>
		
		<?php if ( $strain->getNbPictures() > 0 ): ?>
		<div class="object_related_model_list">
			<h2>Pictures</h2>
			<?php $i = 1 ?>
			<?php foreach ($strain->getPictures() as $picture): ?>
			<?php if ( $picture->getFilename() === null ) continue ?>
			<div class="thumbnail">
				<div class="thumbnail_image">
					<a href="<?php echo $picture->getFilenameWithPath() ?>" rel="thumbnail_link" title="Picture <?php echo $i ?>" class="cboxElement">
						<img src="<?php echo $picture->getThumbnail() ?>" alt="Picture <?php echo $i ?>" />
					</a>
				</div>
			</div>
			<?php $i++ ?>
			<?php endforeach; ?>
		</div>
		<?php endif ?>
		
	</div>
	
	<div id="object_data_list">
		<dl>
			<dt>Sample:</dt>
			<dd>
				<?php
					if ( $strain->getSample() != '' ) {
						echo link_to($strain->getFormattedSampleCode(), "@sample_show?id={$strain->getSample()->getId()}");
					}
					else {
						echo sfConfig::get('app_no_data_message');
					}
				?>
			</dd>
			<dt>Has DNA:</dt>
			<dd><?php echo $strain->getFormattedHasDna() ?></dd>
			<dt>Is epitype:</dt>
			<dd><?php echo $strain->getFormattedIsEpitype() ?></dd>
			<dt>Is axenic:</dt>
			<dd><?php echo $strain->getFormattedIsAxenic() ?></dd>
			<dt>Is public:</dt>
			<dd><?php echo $strain->getFormattedIsPublic() ?></dd>
			<!--
			<dt>Amount:</dt>
			<dd><?php //echo $strain->getAmount() ?> <?php //echo sfConfig::get('app_stock_items_label') ?></dd>
			-->
			
			<dt>Class:</dt>
			<dd><?php echo $strainClass ?></dd>
			<dt>Genus:</dt>
			<dd><span class="species_name"><?php echo $strainGenus ?></span></dd>
			<dt>Species:</dt>
			<dd>
				<?php if ( $strainSpecies !== sfConfig::get('app_unknown_species_name') ): ?>
				<span class="species_name"><?php echo $strainSpecies ?></span>
				<?php else: ?>
				<?php echo $strainSpecies ?>
				<?php endif; ?>
			</dd>
			<dt>Authority:</dt>
			<dd><?php echo $strain->getAuthority() ?></dd>
			
			<dt>Maintenance status:</dt>
			<dd><?php echo $strain->getMaintenanceStatus() ?></dd>
									
			<?php if ( $strain->getMaintenanceStatus() === sfConfig::get('app_maintenance_status_cryopreserved') ): ?>
			<dt>Cryopreservation:</dt>
			<dd><?php echo $strain->getCryopreservationMethod() ?></dd>
			<?php endif; ?>
			
			<dt>Relatives:</dt>
			<dd><?php echo $nbRelatives ?></dd>
			
			<dt>Culture media:</dt>
			<dd><?php echo $nbCultureMedia ?></dd>
			
			<dt>DNA extractions:</dt>
			<dd>
				<?php echo $nbDnaExtractions = $strain->getNbDnaExtractions() ?>
				<?php if ( $nbDnaExtractions > 0 ): ?>
					<a href="#strain_dna_extractions_list" title="List of DNA extractions linked to this strain" class="page_jump">see below</a>
				<?php endif; ?>
			</dd>
			
			<dt>Transfer interval:</dt>
			<dd><?php echo $strain->getFormattedTransferInterval() ?></dd>
			
			<dt>Observation:</dt>
			<dd><?php echo $strain->getFormattedObservation() ?></dd>

			<?php if ( $strain->getIsolator()->getName() ): ?>
			<dt>Isolator:</dt>
			<dd><?php echo $strain->getIsolator() ?> ( <?php echo $strain->getFormattedIsolationDate() ?> )</dd>
			<?php endif; ?>
			
			<?php if ( $strain->getIdentifier()->getName() ): ?>
			<dt>Identifier:</dt>
			<dd><?php echo $strain->getIdentifier() ?></dd>
			<?php endif; ?>
			
			<?php if ( $strain->getDepositor()->getName() ): ?>
			<dt>Depositor:</dt>
			<dd><?php echo $strain->getDepositor() ?> (<?php echo $strain->getFormattedDepositionDate() ?>)</dd>
			<?php endif; ?>

			<dt>Citations:</dt>
			<dd><?php echo $strain->getFormattedCitations() ?></dd>
			
			<dt>Remarks:</dt>
			<dd><?php echo $strain->getRemarks() ?></dd>
			
			<dt>Web notes:</dt>
			<dd><?php echo $strain->getWebNotes() ?></dd>
		</dl>
	</div>
	
	<?php if ( $nbDnaExtractions > 0): ?>
	<div id="strain_dna_extractions_list" class="object_related_model_long_list">
		<h2>DNA extractions</h2>
		<table>
			<tr>
				<th class="date">Extraction date</th>
				<th class="description">Extraction kit</th>
				<th class="link">Concentration</th>
				<th class="link">Aliquots</th>
			</tr>
			<?php foreach ($strain->getDnaExtractions() as $dnaExtraction ): ?>
				<?php $url = '@dna_extraction_show?id='.$dnaExtraction->getId() ?>
				<tr>
					<td>
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
					<td><?php echo link_to($dnaExtraction->getExtractionKit()->getName(), $url) ?></td>
					<td><?php echo link_to($dnaExtraction->getFormattedConcentration(), $url) ?></td>
					<td><?php echo link_to($dnaExtraction->getAliquots(), $url) ?></td>
				</tr>
			<?php endforeach ?>
		</table>
	</div>
	<?php endif ?>
	
	<div class="clear"></div>
</div>
