<?php use_helper('Date'); ?>

<?php if ( $project->getStrain()->exists() ): ?>
	<?php $strain = $project->getStrain() ?>
	<?php $code = $strain->getFullCode() ?>
	<?php $route = "@strain_show?id={$strain->getId()}" ?>
	<?php $taxonomicClass = $strain->getTaxonomicClass() ?>
	<?php $genus = $strain->getGenus() ?>
	<?php $species = $strain->getSpecies() ?>
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
			<dd><?php echo $project->getName() ?></dd>
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
	
	<div class="clear"></div>
</div>
