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
	<?php echo $strain->getFullCode() ?> - <?php echo $strainClass = $strain->getTaxonomicClass() ?>
	<span class="species_name">
		<?php echo $strainGenus = $strain->getGenus() ?>
		<?php echo $strainSpecies = $strain->getSpecies() ?>
	</span>
</span>
<?php include_partial('global/back_header_action', array('module' => 'strain')) ?>
<?php include_partial('global/create_from_template_header_action', array('module' => 'strain', 'id' => $strain->getId())) ?>
<?php include_partial('global/edit_header_action', array('module' => 'strain', 'id' => $strain->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'strain', 'id' => $strain->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_related_models">
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

		<?php $nbIsolators = $strain->getNbIsolators() ?>
		<?php if ( $nbIsolators > 0): ?>
		<div class="object_related_model_list">
			<h2>Isolators</h2>
			<a href="<?php echo url_for('@strain_update_isolators_order?strain_id='.$strain->getId()) ?>" class="strain_isolators_list_url"></a>
			<table id="strain_isolators_list">
				<thead>
				<tr>
					<th class="isolator_id">Id</th>
					<th class="isolator_name">Name</th>
					<th class="object_count_long">Total strains</th>
				</tr>
				</thead>
				<tbody>
					<?php foreach ($strain->getIsolators() as $isolator ): ?>
					<tr>
						<td class="isolator_id"><?php echo $isolator->getId() ?></td>
						<td class="isolator_name"><?php echo $isolator->getName() ?> <?php echo $isolator->getSurname() ?></td>
						<td class="object_count_long"><?php echo $isolator->getNbStrains() ?></span></td>
					</tr>
					<?php endforeach ?>
				</tbody>
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

		<?php $nbCryopreservations = $strain->getNbCryopreservations() ?>
		<?php if ( $nbCryopreservations > 0): ?>
		<div class="object_related_model_list">
			<h2>Cryopreservations</h2>
			<table>
				<tr>
					<th class="date">Date</th>
					<th class="cryopreservation_method">Method</th>
					<th class="cryopreservation_replicate">1<sup>st</sup>&nbsp;replicate</th>
					<th class="cryopreservation_replicate">2<sup>nd</sup>&nbsp;replicate</th>
					<th class="cryopreservation_replicate">3<sup>rd</sup>&nbsp;replicate</th>
				</tr>
				<?php foreach ($strain->getCryopreservations() as $cryopreservation): ?>
					<?php $url = '@cryopreservation_show?id='.$cryopreservation->getId() ?>
					<tr>
						<td class="date"><?php echo link_to($cryopreservation->getCryopreservationDate(), $url) ?></td>
						<td class="cryopreservation_method"><?php echo link_to($cryopreservation->getCryopreservationMethod(), $url) ?></td>
						<td class="cryopreservation_replicate"><?php echo link_to($cryopreservation->getFirstReplicate(), $url) ?></td>
						<td class="cryopreservation_replicate"><?php echo link_to($cryopreservation->getSecondReplicate(), $url) ?></td>
						<td class="cryopreservation_replicate"><?php echo link_to($cryopreservation->getThirdReplicate(), $url) ?></td>
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

		<?php $nbContainers = $strain->getNbContainers() ?>
		<?php if ( $nbContainers > 0): ?>
		<div class="object_related_model_list">
			<h2>Containers</h2>
			<table>
				<tr>
					<th class="container_name">Name</th>
					<th class="object_count_long">Total strains</th>
				</tr>
				<?php foreach ($strain->getContainers() as $container ): ?>
					<tr>
						<td class="container_name"><?php echo $container->getName() ?></td>
						<td class="object_count_long"><?php echo $container->getNbStrains() ?></td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
		<?php endif ?>

		<?php if ( $strain->getPhylogeneticTree() ): ?>
		<div class="object_related_model_list">
			<h2>Phylogenetic tree</h2>
			<div class="thumbnail">
				<div class="thumbnail_image">
					<a href="<?php echo $strain->getPhylogeneticTreePath() ?>" rel="thumbnail_link" title="Phylogenetic tree" class="cboxElement">
						<img src="<?php echo $strain->getPhylogeneticTreeThumbnail() ?>" alt="Phylogenetic tree" />
					</a>
				</div>
			</div>
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
					<th class="petitioner_name">Petitioner</th>
					<th class="project_amount">Amount (<?php echo sfConfig::get('app_project_amount_unit') ?>)</th>
				</tr>
				<?php foreach ($strain->getProjects() as $project ): ?>
					<?php $url = '@project_show?id='.$project->getId() ?>
					<tr>
						<td class="project_inoculation_date"><?php echo link_to($project->getInoculationDate(), $url) ?></td>
						<td class="petitioner_name"><?php echo link_to($project->getPetitioner()->getName(), $url) ?></td>
						<td class="project_amount"><?php echo link_to($project->getAmount(), $url) ?></td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
		<?php endif ?>

		<?php $nbPotentialUsages = $strain->getNbPotentialUsages() ?>
		<?php if ($nbPotentialUsages > 0): ?>
		<div class="object_related_model_list">
			<h2>Potential applications</h2>
			<table>
				<tr>
					<th class="usage_target_name">Area</th>
					<th class="usage_target_name">Application</th>
				</tr>
				<?php foreach ($strain->getPotentialUsages() as $potentialUsage): ?>
					<?php $url = '@potential_usage_show?id='.$potentialUsage->getStrainTaxonomy()->getId() ?>
					<tr>
						<td class="usage_target_name"><?php echo link_to($potentialUsage->getStrainUsage()->getUsageArea()->getName(), $url) ?></td>
						<td class="usage_target_name"><?php echo link_to($potentialUsage->getStrainUsage()->getUsageTarget()->getName(), $url) ?></td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
		<?php endif ?>
	</div>

	<div id="object_data_list">
		<dl>
			<dt>Code:</dt>
			<dd><?php echo $strain->getFullCode() ?></dd>
			<dt>Is axenic:</dt>
			<dd><?php echo $strain->getFormattedIsAxenic() ?></dd>
			<br />

			<dt>Sample:</dt>
			<dd><?php echo  ($strain->getSample() != '') ? link_to($strain->getFormattedSampleCode(), "@sample_show?id={$strain->getSample()->getId()}") : sfConfig::get('app_no_data_message') ?></dd>
			<dt>Habitat description:</dt>
			<dd><?php echo $strain->getHabitatDescription() ?></dd>
			<br />

			<dt>Kingdom:</dt>
			<dd><?php echo $strain->getFormattedKingdom() ?></dd>
			<dt>Subkingdom:</dt>
			<dd><?php echo $strain->getFormattedSubkingdom() ?></dd>
			<dt>Phylum:</dt>
			<dd><?php echo $strain->getFormattedPhylum() ?></dd>
			<dt>Class:</dt>
			<dd><?php echo $strainClass ?></dd>
			<dt>Order:</dt>
			<dd><?php echo $strain->getFormattedTaxonomicOrder() ?></dd>
			<dt>Family:</dt>
			<dd><?php echo $strain->getFormattedFamily() ?></dd>
			<dt>Genus:</dt>
			<dd><span class="species_name"><?php echo $strainGenus ?></span></dd>
			<dt>Species:</dt>
			<dd><span class="species_name"><?php echo $strainSpecies ?></span></dd>
			<dt>Authority:</dt>
			<dd><?php echo $strain->getAuthority() ?></dd>
			<dt>Article description:</dt>
			<dd><?php echo $strain->getArticleDescription() ?></dd>
			<dt>Worldwide distribution:</dt>
			<dd><?php echo $strain->getDistribution() ?></dd>
			<dt>Is epitype:</dt>
			<dd><?php echo $strain->getFormattedIsEpitype() ?></dd>
			<br />

			<dt>Isolators:</dt>
			<dd><?php echo $nbIsolators ?>	</dd>
			<dt>Isolations:</dt>
			<dd><?php echo $nbIsolations ?></dd>
			<?php if ( $strain->getIdentifier()->getName() ): ?>
			<dt>Identifier:</dt>
			<dd><?php echo $strain->getIdentifier() ?></dd>
			<?php endif; ?>
			<dt>Depositor:</dt>
			<dd><?php echo $strain->getDepositor() ?></dd>
			<dt>Remarks:</dt>
			<dd><?php echo $strain->getRemarks() ?></dd>
			<br />

			<dt>Maintenance status:</dt>
			<dd><?php echo $strain->getFormattedMaintenanceStatusList() ?></dd>
			<dt>Best culture medium:</dt>
			<dd><?php echo $strain->getFormattedCultureMedium() ?></dd>
			<dt>Best container:</dt>
			<dd><?php echo $strain->getFormattedContainer() ?></dd>
			<dt>Transfer interval:</dt>
			<dd><?php echo $strain->getFormattedTransferInterval() ?></dd>
			<?php if ( $strain->getSupervisor()->getName() ): ?>
			<dt>Supervisor:</dt>
			<dd><?php echo $strain->getSupervisor()->getFullNameWithInitials() ?></dd>
			<?php endif; ?>
			<dt>Temperature:</dt>
			<dd><?php echo $strain->getFormattedTemperature() ?></dd>
			<dt>Photoperiod:</dt>
			<dd><?php echo $strain->getFormattedPhotoperiod() ?></dd>
			<dt>Irradiation:</dt>
			<dd><?php echo $strain->getFormattedIrradiation() ?></dd>
			<dt>Observation:</dt>
			<dd><?php echo $strain->getFormattedObservation() ?></dd>
			<br />

			<dt>Is public:</dt>
			<dd><?php echo $strain->getFormattedIsPublic() ?></dd>
			<dt>In G catalog:</dt>
			<dd><?php echo $strain->getFormattedInGCatalog() ?></dd>
			<dt>Deceased:</dt>
			<dd><?php echo $strain->getFormattedDeceased() ?></dd>
			<dt>Has DNA:</dt>
			<dd><?php echo $strain->getFormattedHasDna() ?></dd>
			<dt>DNA extractions:</dt>
			<dd>
				<?php echo $nbDnaExtractions = $strain->getNbDnaExtractions() ?>
				<?php if ( $nbDnaExtractions > 0 ): ?>
					<a href="#strain_dna_extractions_list" title="List of DNA extractions linked to this strain" class="page_jump">see below</a>
				<?php endif; ?>
			</dd>
			<dt>Sequenced genes</dt>
			<dd><?php $genes = array(); foreach($strain->getSequencedGenes() as $gen) $genes[] = $gen; echo implode(', ', $genes) ?></dd>
			<br />

			<dt>Phylogenetic description:</dt>
			<dd><?php echo $strain->getPhylogeneticDescription() ?></dd>
			<br />

			<dt>Web notes:</dt>
			<dd><?php echo $strain->getWebNotes() ?></dd>
			<dt>Projects:</dt>
			<dd><?php echo $nbProjects ?></dd>
			<dt>Citations:</dt>
			<dd><?php echo $strain->getFormattedCitations() ?></dd>
			<dt>Relatives:</dt>
			<dd><?php echo $nbRelatives ?></dd>
		</dl>
	</div>

	<?php if ( $nbDnaExtractions > 0): ?>
	<div id="strain_dna_extractions_list" class="object_related_model_long_list">
		<h2>DNA extractions</h2>
		<table>
			<tr>
				<th class="date">Extraction date</th>
				<th class="date">Arrival date</th>
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
					<td>
						<?php
							if ( $date = $dnaExtraction->getArrivalDate() ) {
								 $date = format_date($dnaExtraction->getArrivalDate(), 'p');
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
