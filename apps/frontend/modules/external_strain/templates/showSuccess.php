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
	<?php echo $externalStrain->getFullCode() ?> - <?php echo $externalStrainClass = $externalStrain->getTaxonomicClass() ?>
	<span class="species_name">
		<?php echo $externalStrainGenus = $externalStrain->getGenus() ?>
		<?php echo $externalStrainSpecies = $externalStrain->getSpecies() ?>
	</span>
</span>
<?php include_partial('global/back_header_action', array('module' => 'external_strain')) ?>
<?php include_partial('global/edit_header_action', array('module' => 'external_strain', 'id' => $externalStrain->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'external_strain', 'id' => $externalStrain->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_related_models">
		<?php $nbIsolators = $externalStrain->getNbIsolators() ?>
		<?php if ( $nbIsolators > 0): ?>
		<div class="object_related_model_list">
			<h2>Isolators</h2>
			<a href="<?php echo url_for('@strain_update_isolators_order?strain_id='.$externalStrain->getId()) ?>" class="strain_isolators_list_url"></a>
			<table id="strain_isolators_list">
				<thead>
				<tr>
					<th class="isolator_id">Id</th>
					<th class="isolator_name">Name</th>
					<th class="object_count_long">Total strains</th>
				</tr>
				</thead>
				<tbody>
					<?php foreach ($externalStrain->getIsolators() as $isolator ): ?>
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

		<?php $nbIsolations = $externalStrain->getNbIsolations() ?>
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
				<?php foreach ($externalStrain->getIsolations() as $isolation ): ?>
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

		<?php $nbCryopreservations = $externalStrain->getNbCryopreservations() ?>
		<?php if ($nbCryopreservations > 0): ?>
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
				<?php foreach ($externalStrain->getCryopreservations() as $cryopreservation): ?>
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

		<?php $nbCultureMedia = $externalStrain->getNbCultureMedia() ?>
		<?php if ( $nbCultureMedia > 0): ?>
		<div class="object_related_model_list">
			<h2>Culture media</h2>
			<table>
				<tr>
					<th class="culture_medium_code">Code</th>
					<th class="culture_medium_name">Name</th>
				</tr>
				<?php foreach ($externalStrain->getCultureMedia() as $cultureMedium ): ?>
					<?php $url = '@culture_medium_show?id='.$cultureMedium->getId() ?>
					<tr>
						<td class="culture_medium_code"><?php echo link_to($cultureMedium->getCode(), $url) ?></td>
						<td class="culture_medium_name"><?php echo link_to($cultureMedium->getName(), $url) ?></td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
		<?php endif ?>

		<?php $nbContainers = $externalStrain->getNbContainers() ?>
		<?php if ( $nbContainers > 0): ?>
		<div class="object_related_model_list">
			<h2>Containers</h2>
			<table>
				<tr>
					<th class="container_name">Name</th>
					<th class="object_count_long">Total strains</th>
				</tr>
				<?php foreach ($externalStrain->getContainers() as $container ): ?>
					<tr>
						<td class="container_name"><?php echo $container->getName() ?></td>
						<td class="object_count_long"><?php echo $container->getNbStrains() ?></td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
		<?php endif ?>

		<?php $nbRelatives = $externalStrain->getNbRelatives() ?>
		<?php if ( $nbRelatives > 0): ?>
		<div class="object_related_model_list">
			<h2>Relatives</h2>
			<table>
				<tr>
					<th class="name">Name</th>
				</tr>
				<?php foreach ($externalStrain->getRelatives() as $relative ): ?>
					<tr>
						<td><?php echo $relative->getName() ?></td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
		<?php endif ?>

		<?php $nbProjects = $externalStrain->getNbProjects() ?>
		<?php if ( $nbProjects > 0): ?>
		<div class="object_related_model_list">
			<h2>Projects</h2>
			<table>
				<tr>
					<th class="project_inoculation_date">Date</th>
					<th class="petitioner_name">Petitioner</th>
					<th class="project_amount">Amount (<?php echo sfConfig::get('app_project_amount_unit') ?>)</th>
				</tr>
				<?php foreach ($externalStrain->getProjects() as $project ): ?>
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
	</div>

	<div id="object_data_list">
		<dl>
			<dt>Code:</dt>
			<dd><?php echo $externalStrain->getFullCode() ?></dd>
			<dt>Is axenic:</dt>
			<dd><?php echo $externalStrain->getFormattedIsAxenic() ?></dd>
			<br />

			<dt>Sample:</dt>
			<dd><?php echo  ($externalStrain->getSample() != '') ? link_to($externalStrain->getFormattedSampleCode(), "@sample_show?id={$externalStrain->getSample()->getId()}") : sfConfig::get('app_no_data_message') ?></dd>
			<br />

			<dt>Kingdom:</dt>
			<dd><?php echo $externalStrain->getFormattedKingdom() ?></dd>
			<dt>Subkingdom:</dt>
			<dd><?php echo $externalStrain->getFormattedSubkingdom() ?></dd>
			<dt>Phylum:</dt>
			<dd><?php echo $externalStrain->getFormattedPhylum() ?></dd>
			<dt>Class:</dt>
			<dd><?php echo $externalStrainClass ?></dd>
			<dt>Order:</dt>
			<dd><?php echo $externalStrain->getFormattedTaxonomicOrder() ?></dd>
			<dt>Family:</dt>
			<dd><?php echo $externalStrain->getFormattedFamily() ?></dd>
			<dt>Genus:</dt>
			<dd><span class="species_name"><?php echo $externalStrainGenus ?></span></dd>
			<dt>Species:</dt>
			<dd><span class="species_name"><?php echo $externalStrainSpecies ?></span></dd>
			<dt>Authority:</dt>
			<dd><?php echo $externalStrain->getAuthority() ?></dd>
			<dt>Is epitype:</dt>
			<dd><?php echo $externalStrain->getFormattedIsEpitype() ?></dd>
			<br />

			<dt>Isolators:</dt>
			<dd><?php echo $nbIsolators ?>	</dd>
			<dt>Isolations:</dt>
			<dd><?php echo $nbIsolations ?></dd>
			<?php if ( $externalStrain->getIdentifier()->getName() ): ?>
			<dt>Identifier:</dt>
			<dd><?php echo $externalStrain->getIdentifier() ?></dd>
			<?php endif; ?>
			<dt>Depositor:</dt>
			<dd><?php echo $externalStrain->getDepositor() ?></dd>
			<dt>Remarks:</dt>
			<dd><?php echo $externalStrain->getRemarks() ?></dd>
			<br />

			<dt>Maintenance status:</dt>
			<dd><?php echo $externalStrain->getFormattedMaintenanceStatusList() ?></dd>
			<dt>Culture media:</dt>
			<dd><?php echo $nbCultureMedia ?></dd>
			<dt>Best container:</dt>
			<dd><?php echo $externalStrain->getFormattedContainer() ?></dd>
			<dt>Transfer interval:</dt>
			<dd><?php echo $externalStrain->getFormattedTransferInterval() ?></dd>
			<?php if ( $externalStrain->getSupervisor()->getName() ): ?>
			<dt>Supervisor:</dt>
			<dd><?php echo $externalStrain->getSupervisor()->getFullNameWithInitials() ?></dd>
			<?php endif; ?>
			<dt>Temperature:</dt>
			<dd><?php echo $externalStrain->getFormattedTemperature() ?></dd>
			<dt>Photoperiod:</dt>
			<dd><?php echo $externalStrain->getFormattedPhotoperiod() ?></dd>
			<dt>Irradiation:</dt>
			<dd><?php echo $externalStrain->getFormattedIrradiation() ?></dd>
			<dt>Observation:</dt>
			<dd><?php echo $externalStrain->getFormattedObservation() ?></dd>
			<br />

			<dt>Projects:</dt>
			<dd><?php echo $nbProjects ?></dd>
			<dt>Citations:</dt>
			<dd><?php echo $externalStrain->getFormattedCitations() ?></dd>
			<dt>Relatives:</dt>
			<dd><?php echo $nbRelatives ?></dd>
		</dl>
	</div>

	<?php if (false && $nbDnaExtractions > 0): ?>
	<div id="strain_dna_extractions_list" class="object_related_model_long_list">
		<h2>DNA extractions</h2>
		<table>
			<tr>
				<th class="date">Extraction date</th>
				<th class="description">Extraction kit</th>
				<th class="link">Concentration</th>
				<th class="link">Aliquots</th>
			</tr>
			<?php foreach ($externalStrain->getDnaExtractions() as $dnaExtraction ): ?>
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
