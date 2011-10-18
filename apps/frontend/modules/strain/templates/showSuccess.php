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
		
		<?php $nbIsolators = $strain->getNbIsolators() ?>
		<?php if ( $nbIsolators > 0): ?>
		<div class="object_related_model_list">
			<h2>Isolators</h2>
			<table>
				<tr>
					<th class="isolator_name">Name</th>
					<th class="object_count_long">Total strains</th>
				</tr>
				<?php foreach ($strain->getIsolators() as $isolator ): ?>
				<tr>
					<td class="isolator_name"><?php echo $isolator->getName() ?> <?php echo $isolator->getSurname() ?></td>
					<td class="object_count_long"><?php echo $isolator->getNbStrains() ?></span></td>
				</tr>
			<?php endforeach ?>
			</table>
		</div>
		<?php endif ?>
		
		<?php $nbAxenityTests = $strain->getNbAxenityTests() ?>
		<?php if ( $nbAxenityTests > 0): ?>
		<div class="object_related_model_list">
			<h2>Axenity tests</h2>
			<table>
				<tr>
					<th class="date">Date</th>
				</tr>
				<?php foreach ($strain->getAxenityTests() as $test ): ?>
					<tr>
						<td><?php echo $test->getFormattedDate() ?></td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
		<?php endif ?>
		
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
		
		<?php $nbProjects = $strain->getNbProjects() ?>
		<?php if ( $nbProjects > 0): ?>
		<div class="object_related_model_list">
			<h2>Projects</h2>
			<table>
				<tr>
					<th class="project_inoculation_date">Date</th>
					<th class="provider_name">Provider</th>
					<th class="project_amount">Amount (<?php echo sfConfig::get('app_project_amount_unit') ?>)</th>
				</tr>
				<?php foreach ($strain->getProjects() as $project ): ?>
					<?php $url = '@project_show?id='.$project->getId() ?>
					<tr>
						<td class="project_inoculation_date"><?php echo link_to($project->getInoculationDate(), $url) ?></td>
						<td class="provider_name"><?php echo link_to($project->getProvider()->getName(), $url) ?></td>
						<td class="project_amount"><?php echo link_to($project->getAmount(), $url) ?></td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
		<?php endif ?>
		
		<?php $nbIsolations = $strain->getNbIsolations() ?>
		<?php if ( $nbIsolations > 0): ?>
		<div class="object_related_model_list">
			<h2>Isolations</h2>
			<table>
				<tr>
					<th class="date reception_date">Reception date</th>
					<th class="date delivery_date">Delivery date</th>
					<th class="purification_method">Purification method</th>
					<th class="purification_details">Purification details</th>
				</tr>
				<?php foreach ($strain->getIsolations() as $isolation ): ?>
				<?php $url = '@isolation_show?id='.$isolation->getId() ?>
				<tr>
					<td class="date reception_date"><?php echo link_to($isolation->getReceptionDate(), $url) ?></td>
					<td class="date delivery_date"><?php echo link_to($isolation->getDeliveryDate(), $url) ?></td>
					<td class="purification_method"></td>
					<td class="purification_details"></td>
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
			
			<dt>Best container:</dt>
			<dd><?php echo $strain->getFormattedContainer() ?></dd>
			
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
			
			<dt>Projects:</dt>
			<dd><?php echo $nbProjects ?></dd>
			
			<dt>Isolations:</dt>
			<dd><?php echo $nbIsolations ?></dd>
			
			<dt>Transfer interval:</dt>
			<dd><?php echo $strain->getFormattedTransferInterval() ?></dd>
			
			<dt>Observation:</dt>
			<dd><?php echo $strain->getFormattedObservation() ?></dd>
			
			<dt>Isolators:</dt>
			<dd><?php echo $nbIsolators ?>	</dd>
			
			<?php if ( $strain->getIdentifier()->getName() ): ?>
			<dt>Identifier:</dt>
			<dd><?php echo $strain->getIdentifier() ?></dd>
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
