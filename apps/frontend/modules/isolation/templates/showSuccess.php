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

<?php $isolationSubject = sfInflector::humanize($isolation->getIsolationSubject()) ?>
<?php $code = $isolation->getExternalCode() ?>
<?php $taxonomicClass = $isolation->getFormattedTaxonomicClass() ?>
<?php $genus = $isolation->getFormattedGenus() ?>
<?php $species = $isolation->getFormattedSpecies() ?>
<?php $authority = $isolation->getFormattedAuthority() ?>
<?php $location = $isolation->getFormattedLocation() ?>
<?php $environment = $isolation->getFormattedEnvironment() ?>
<?php $habitat = $isolation->getFormattedHabitat() ?>

<?php if ( $isolation->getStrain()->exists() ): ?>
	<?php $strain = $isolation->getStrain() ?>
	<?php $code = $strain->getFullCode() ?>
	<?php $route = "@strain_show?id={$strain->getId()}" ?>
	<?php $taxonomicClass = $strain->getTaxonomicClass() ?>
	<?php $genus = $strain->getGenus() ?>
	<?php $species = $strain->getSpecies() ?>
	<?php $authority = $strain->getAuthority() ?>
	<?php $location = link_to($strain->getSample()->getLocation(), "@location_show?id={$strain->getSample()->getLocationId()}") ?>
	<?php $environment = $strain->getSample()->getEnvironment() ?>
	<?php $habitat = $strain->getSample()->getHabitat() ?>
<?php elseif ( $isolation->getExternalStrain()->exists() ): ?>
	<?php $isolationSubject = sfInflector::humanize('research_collection') ?>
	<?php $externalStrain = $isolation->getExternalStrain() ?>
	<?php $code = $externalStrain->getFullCode() ?>
	<?php $route = "@external_strain_show?id={$externalStrain->getId()}" ?>
	<?php $taxonomicClass = $externalStrain->getTaxonomicClass() ?>
	<?php $genus = $externalStrain->getGenus() ?>
	<?php $species = $externalStrain->getSpecies() ?>
	<?php $authority = $externalStrain->getAuthority() ?>
	<?php $sample = $externalStrain->getSample() ?>
	<?php $environment = $sample->getEnvironment() ?>
	<?php $habitat = $sample->getHabitat() ?>
<?php elseif( $isolation->getSample()->exists() ): ?>
	<?php $sample = $isolation->getSample() ?>
	<?php $code = $sample->getCode() ?>
	<?php $location = link_to($sample->getLocation(), "@location_show?id={$sample->getLocationId()}") ?>
	<?php $environment = $sample->getEnvironment() ?>
	<?php $habitat = $sample->getHabitat() ?>
	<?php $route = "@sample_show?id={$sample->getId()}" ?>
<?php endif ?>

<?php slot('main_header') ?>
<span><?php echo $isolationSubject ?> <?php echo $code ?></span>
<?php include_partial('global/back_header_action', array('module' => 'isolation')) ?>
<?php include_partial('global/label_header_action', array('message' => 'Create label', 'route' => '@isolation_create_label?id='.$isolation->getId())) ?>
<?php include_partial('global/edit_header_action', array('module' => 'isolation', 'id' => $isolation->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'isolation', 'id' => $isolation->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_data_list">
		<dl>
			<dt><?php echo $isolationSubject ?>:</dt>
			<dd><?php echo (isset($route))?link_to($code, $route):$code ?></dd>

			<dt>Class:</dt>
			<dd><?php echo $taxonomicClass ?></dd>

			<dt>Genus:</dt>
			<dd><span class="species_name"><?php echo $genus ?></span></dd>

			<dt>Species:</dt>
			<dd><span class="species_name"><?php echo $species ?></span></dd>

			<dt>Authority:</dt>
			<dd><?php echo $authority ?></dd>

			<dt>Location:</dt>
			<dd><?php echo $location ?></dd>

			<dt>Environment:</dt>
			<dd><?php echo $environment ?></dd>

			<dt>Habitat:</dt>
			<dd><?php echo $habitat ?></dd>

			<dt>Isolation date:</dt>
			<dd><?php echo $isolation->getIsolationDate() ?></dd>

			<dt>Reception date:</dt>
			<dd><?php echo $isolation->getReceptionDate() ?></dd>

			<dt>Delivery date:</dt>
			<dd><?php echo $isolation->getDeliveryDate() ?></dd>

			<dt>Purification method:</dt>
			<dd><?php echo $isolation->getPurificationMethod() ?></dd>

			<dt>Purification details:</dt>
			<dd><?php echo $isolation->getPurificationDetails() ?></dd>

			<dt>Supervisor:</dt>
			<dd><?php echo $isolation->getSupervisor() ?></dd>

			<dt>Observation:</dt>
			<dd><?php echo $isolation->getObservation() ?></dd>

			<dt>Remarks:</dt>
			<dd><?php echo $isolation->getRemarks() ?></dd>
		</dl>
	</div>

	<div class="clear"></div>
</div>
