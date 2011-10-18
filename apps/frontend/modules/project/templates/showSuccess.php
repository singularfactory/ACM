<?php use_helper('Date'); ?>

<?php slot('main_header') ?>
<span>
	Project transference from strain <?php echo $project->getStrain()->getCode() ?>
</span>
<?php include_partial('global/back_header_action', array('module' => 'project')) ?>
<?php include_partial('global/edit_header_action', array('module' => 'project', 'id' => $project->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'project', 'id' => $project->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_data_list">
		<dl>
			<?php $strain = $project->getStrain() ?>
			<dt>Strain:</dt>
			<dd><?php echo link_to($strain->getCode(), "@strain_show?id={$strain->getId()}") ?></dd>
			
			<dt>Class:</dt>
			<dd><?php echo $strain->getTaxonomicClass() ?></dd>
			<dt>Genus:</dt>
			<dd><span class="species_name"><?php echo $strain->getGenus() ?></span></dd>
			<dt>Species:</dt>
			<dd>
				<?php if ( ($strainSpecies = $strain->getSpecies()) !== sfConfig::get('app_unknown_species_name') ): ?>
					<span class="species_name"><?php echo $strainSpecies ?></span>
				<?php else: ?>
					<?php echo $strainSpecies ?>
				<?php endif; ?>
			</dd>
			<dt>Inoculation date:</dt>
			<dd><?php echo $project->getInoculationDate() ?></dd>
			<dt>Provider:</dt>
			<dd><?php echo $project->getProvider()->getName() ?></dd>
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
