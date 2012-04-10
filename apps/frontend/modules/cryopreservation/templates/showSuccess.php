<?php use_helper('Date'); ?>

<?php $subject = strtolower(sfInflector::humanize($cryopreservation->getSubject())) ?>
<?php if ( $cryopreservation->getStrain()->exists() ): ?>
	<?php $strain = $cryopreservation->getStrain() ?>
	<?php $code = $strain->getFullCode() ?>
	<?php $route = "@strain_show?id={$strain->getId()}" ?>
	<?php $taxonomicClass = $strain->getTaxonomicClass() ?>
	<?php $genus = $strain->getGenus() ?>
	<?php $species = $strain->getSpecies() ?>
<?php elseif ( $cryopreservation->getExternalStrain()->exists() ): ?>
	<?php $subject = strtolower(sfInflector::humanize('research_collection')) ?>
	<?php $externalStrain = $cryopreservation->getExternalStrain() ?>
	<?php $code = $externalStrain->getFullCode() ?>
	<?php $route = "@external_strain_show?id={$externalStrain->getId()}" ?>
	<?php $taxonomicClass = $externalStrain->getTaxonomicClass() ?>
	<?php $genus = $externalStrain->getGenus() ?>
	<?php $species = $externalStrain->getSpecies() ?>
<?php elseif( $cryopreservation->getSample()->exists() ): ?>
	<?php $sample = $cryopreservation->getSample() ?>
	<?php $code = $sample->getCode() ?>
	<?php $route = "@sample_show?id={$sample->getId()}" ?>
	<?php $taxonomicClass = sfConfig::get('app_no_data_message') ?>
	<?php $genus = sfConfig::get('app_no_data_message') ?>
	<?php $species = sfConfig::get('app_no_data_message') ?>
<?php endif ?>

<?php slot('main_header') ?>
<span>
	Cryopreservation from <?php echo $subject ?> <?php echo $code ?>
</span>
<?php include_partial('global/back_header_action', array('module' => 'cryopreservation')) ?>
<?php include_partial('global/edit_header_action', array('module' => 'cryopreservation', 'id' => $cryopreservation->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'cryopreservation', 'id' => $cryopreservation->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_data_list">
		<dl>
			<?php $strain = $cryopreservation->getStrain() ?>
			<dt>Code:</dt>
			<dd><?php echo link_to($code, $route) ?></dd>
			
			<dt>Class:</dt>
			<dd><?php echo $taxonomicClass ?></dd>
			<dt>Genus:</dt>
			<dd><span class="species_name"><?php echo $genus ?></span></dd>
			<dt>Species:</dt>
			<dd><span class="species_name"><?php echo $species ?>&nbsp;</span></dd>
			
			<dt>Method:</dt>
			<dd><?php echo $cryopreservation->getCryopreservationMethod()->getName() ?></dd>
			<dt>Date:</dt>
			<dd><?php echo $cryopreservation->getCryopreservationDate() ?></dd>
			
			<dt>First replicate:</dt>
			<dd><?php echo $cryopreservation->getFirstReplicate() ?></dd>
			<dt>Second replicate:</dt>
			<dd><?php echo $cryopreservation->getSecondReplicate() ?></dd>
			<dt>Third replicate:</dt>
			<dd><?php echo $cryopreservation->getThirdReplicate() ?></dd>
			
			<dt>Density:</dt>
			<dd><?php echo $cryopreservation->getFormattedDensity() ?></dd>
			<dt>Revival date:</dt>
			<dd><?php echo $cryopreservation->getRevivalDate() ?></dd>
			<dt>Viability:</dt>
			<dd><?php echo $cryopreservation->getFormattedViability() ?></dd>
			<dt>Remarks:</dt>
			<dd><?php echo $cryopreservation->getRemarks() ?></dd>
		</dl>
	</div>
	
	<div class="clear"></div>
</div>