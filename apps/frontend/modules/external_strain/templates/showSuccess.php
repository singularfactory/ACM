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
	<?php echo $externalStrainClass = $externalStrain->getTaxonomicClass() ?>
	<span class="species_name"><?php echo $externalStrainGenus = $externalStrain->getGenus() ?></span>
	<?php if ( ($externalStrainSpecies = $externalStrain->getSpecies()) !== sfConfig::get('app_unknown_species_name') ): ?>
		<span class="species_name"><?php echo $externalStrainSpecies ?></span>
	<?php else: ?>
		<?php echo $externalStrainSpecies ?>
	<?php endif; ?>
</span>
<?php include_partial('global/back_header_action', array('module' => 'external_strain')) ?>
<?php include_partial('global/edit_header_action', array('module' => 'external_strain', 'id' => $externalStrain->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'external_strain', 'id' => $externalStrain->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_related_models">
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

		<?php $nbIsolators = $externalStrain->getNbIsolators() ?>
		<?php if ( $nbIsolators > 0): ?>
		<div class="object_related_model_list">
			<h2>Isolators</h2>
			<table>
				<tr>
					<th class="isolator_name">Name</th>
					<th class="object_count_long">Total strains</th>
				</tr>
				<?php foreach ($externalStrain->getIsolators() as $isolator ): ?>
				<tr>
					<td class="isolator_name"><?php echo $isolator ?></td>
					<td class="object_count_long"><?php echo $isolator->getNbExternalStrains() ?></span></td>
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
	</div>

	<div id="object_data_list">
		<dl>
			<dt>Location:</dt>
			<dd><?php echo link_to($externalStrain->getLocation()->getName(), "@location_show?id={$externalStrain->getLocationId()}") ?></dd>
			<dt>Environment:</dt>
			<dd><?php echo $externalStrain->getFormattedEnvironment() ?></dd>
			<dt>Habitat:</dt>
			<dd><?php echo $externalStrain->getFormattedHabitat() ?></dd>
			<dt>Class:</dt>
			<dd><?php echo $externalStrainClass ?></dd>
			<dt>Genus:</dt>
			<dd><span class="species_name"><?php echo $externalStrainGenus ?></span></dd>
			<dt>Species:</dt>
			<dd>
				<?php if ( $externalStrainSpecies !== sfConfig::get('app_unknown_species_name') ): ?>
				<span class="species_name"><?php echo $externalStrainSpecies ?></span>
				<?php else: ?>
				<?php echo $externalStrainSpecies ?>
				<?php endif; ?>
			</dd>
			<dt>Authority:</dt>
			<dd><?php echo $externalStrain->getAuthority() ?></dd>

			<dt>Collection date:</dt>
			<dd><?php echo $externalStrain->getFormattedCollectionDate() ?></dd>

			<dt>Isolators:</dt>
			<dd><?php echo $nbIsolators ?>	</dd>
			<dt>Isolation date:</dt>
			<dd><?php echo $externalStrain->getFormattedIsolationDate() ?></dd>

			<dt>Culture media:</dt>
			<dd><?php echo $nbCultureMedia ?></dd>
			<dt>Containers:</dt>
			<dd><?php echo $nbContainers ?></dd>
			<dt>Maintenance status:</dt>
			<dd>
			<?php
				$isCryopreserved = false;
				$firstMaintenanceStatus = true;
				foreach ($externalStrain->getMaintenanceStatus() as $status ) {
					if ( $status->getName() === sfConfig::get('app_maintenance_status_cryopreserved') ) {
						$isCryopreserved = true;
					}

					if ( !$firstMaintenanceStatus ) {
						echo sprintf(', %s', sfInflector::tableize($status->getName()));
						continue;
					}
					echo $status->getName();
					$firstMaintenanceStatus = false;
				}
			?>
			</dd>

			<?php if ( $isCryopreserved ): ?>
			<dt>Cryopreservation:</dt>
			<dd><?php echo $externalStrain->getCryopreservationMethod() ?></dd>
			<?php endif; ?>
			<dt>Transfer interval:</dt>
			<dd><?php echo $externalStrain->getFormattedTransferInterval() ?></dd>

			<?php if ( $externalStrain->getSupervisor()->getName() ): ?>
			<dt>Supervisor:</dt>
			<dd><?php echo $externalStrain->getSupervisor()->getFullNameWithInitials() ?></dd>
			<?php endif; ?>

			<dt>Is epitype:</dt>
			<dd><?php echo $externalStrain->getFormattedIsEpitype() ?></dd>
			<dt>Is axenic:</dt>
			<dd><?php echo $externalStrain->getFormattedIsAxenic() ?></dd>
			<dt>Has DNA:</dt>
			<dd><?php echo $externalStrain->getFormattedHasDna() ?></dd>

			<?php if ( $externalStrain->getIdentifier()->getName() ): ?>
			<dt>Identifier:</dt>
			<dd><?php echo $externalStrain->getIdentifier() ?></dd>
			<?php endif; ?>

			<dt>Relatives:</dt>
			<dd><?php echo $nbRelatives ?></dd>

			<dt>Observation:</dt>
			<dd><?php echo $externalStrain->getFormattedObservation() ?></dd>

			<dt>Citations:</dt>
			<dd><?php echo $externalStrain->getFormattedCitations() ?></dd>

			<dt>Remarks:</dt>
			<dd><?php echo $externalStrain->getRemarks() ?></dd>

		</dl>
	</div>

	<div class="clear"></div>
</div>
