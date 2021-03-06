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

<?php if ( $project->getStrain()->exists() ): ?>
	<?php $strain = $project->getStrain() ?>
	<?php $code = $strain->getFullCode() ?>
	<?php $route = "@strain_show?id={$strain->getId()}" ?>
	<?php $taxonomicClass = $strain->getTaxonomicClass() ?>
	<?php $genus = $strain->getGenus() ?>
	<?php $species = $strain->getSpecies() ?>
<?php elseif ( $project->getExternalStrain()->exists() ): ?>
	<?php $externalStrain = $project->getExternalStrain() ?>
	<?php $code = $externalStrain->getFullCode() ?>
	<?php $route = "@external_strain_show?id={$externalStrain->getId()}" ?>
	<?php $taxonomicClass = $externalStrain->getTaxonomicClass() ?>
	<?php $genus = $externalStrain->getGenus() ?>
	<?php $species = $externalStrain->getSpecies() ?>
<?php elseif( $project->getSample()->exists() ): ?>
	<?php $sample = $project->getSample() ?>
	<?php $code = $sample->getCode() ?>
	<?php $route = "@sample_show?id={$sample->getId()}" ?>
	<?php $taxonomicClass = sfConfig::get('app_no_data_message') ?>
	<?php $genus = sfConfig::get('app_no_data_message') ?>
	<?php $species = sfConfig::get('app_no_data_message') ?>
<?php endif ?>

<?php slot('main_header') ?>
<span>
	Project transference from <?php echo $project->getSubject() ?> <?php echo $code ?>
</span>
<?php include_partial('global/back_header_action', array('module' => 'project')) ?>
<?php include_partial('global/edit_header_action', array('module' => 'project', 'id' => $project->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'project', 'id' => $project->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_data_list">
		<dl>
			<?php $strain = $project->getStrain() ?>
			<dt>Code:</dt>
			<dd><?php echo link_to($code, $route) ?></dd>

			<dt>Name:</dt>
			<dd><?php echo $project->getProjectName()->getName() ?></dd>
			<dt>Petitioner:</dt>
			<dd><?php echo $project->getPetitioner()->getName() ?></dd>

			<dt>Class:</dt>
			<dd><?php echo $taxonomicClass ?></dd>
			<dt>Genus:</dt>
			<dd><span class="species_name"><?php echo $genus ?></span></dd>
			<dt>Species:</dt>
			<dd><span class="species_name"><?php echo $species ?>&nbsp;</span></dd>

			<dt>Provider:</dt>
			<dd><?php echo $project->getProvider()->getName() ?></dd>
			<dt>Inoculation date:</dt>
			<dd><?php echo $project->getInoculationDate() ?></dd>
			<dt>Amount:</dt>
			<dd><?php echo $project->getFormattedAmount() ?></dd>

			<dt>Delivery date:</dt>
			<dd><?php echo $project->getDeliveryDate() ?></dd>
			<dt>Purpose:</dt>
			<dd><?php echo $project->getPurpose() ?></dd>
			<dt>Remarks:</dt>
			<dd><?php echo $project->getRemarks() ?></dd>
		</dl>
	</div>

	<div id="project_description_obligations" class="object_related_model_long_list">
		<?php if ( $description = $project->getProjectName()->getDescription() ): ?>
		<div id="project_description">
			<h2>Project description</h2>
			<p><?php echo $description ?></p>
		</div>
		<?php endif ?>

		<?php if ( $obligations = $project->getProjectName()->getObligations() ): ?>
		<div id="project_obligations">
			<h2>Project obligations</h2>
			<p><?php echo $obligations ?></p>
		</div>
		<?php endif ?>
	</div>

	<div class="clear"></div>
</div>