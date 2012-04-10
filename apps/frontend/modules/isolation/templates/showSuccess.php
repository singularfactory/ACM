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
	<?php $environment = $externalStrain->getEnvironment() ?>
	<?php $habitat = $externalStrain->getHabitat() ?>
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

			<dt>Reception date:</dt>
			<dd><?php echo $isolation->getReceptionDate() ?></dd>

			<dt>Delivery date:</dt>
			<dd><?php echo $isolation->getDeliveryDate() ?></dd>

			<dt>Purification method:</dt>
			<dd><?php echo $isolation->getPurificationMethod() ?></dd>

			<dt>Purification details:</dt>
			<dd><?php echo $isolation->getPurificationDetails() ?></dd>

			<dt>Observation:</dt>
			<dd><?php echo $isolation->getObservation() ?></dd>

			<dt>Remarks:</dt>
			<dd><?php echo $isolation->getRemarks() ?></dd>
		</dl>
	</div>
	
	<div class="clear"></div>
</div>
