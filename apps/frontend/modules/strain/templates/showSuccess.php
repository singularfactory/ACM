<?php use_helper('Date'); ?>

<?php slot('main_header') ?>
<span>
	<?php echo $strain->getNumber() ?> - <?php echo $strainClass = $strain->getTaxonomicClass() ?>
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
	<div id="object_google_map">
	</div>
	
	<div id="object_data_list">
		<dl>
			<dt>Sample:</dt>
			<dd><?php echo $strain->getSample()->getNumber() ?></dd>
			<dt>Has DNA:</dt>
			<dd><?php echo $strain->getFormattedHasDna() ?></dd>
			<dt>Is epitype:</dt>
			<dd><?php echo $strain->getFormattedIsEpitype() ?></dd>
			<dt>Is axenic:</dt>
			<dd><?php echo $strain->getFormattedIsAxenic() ?></dd>
			<dt>Is public:</dt>
			<dd><?php echo $strain->getFormattedIsPublic() ?></dd>
			
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
			
			<dt>Relatives:</dt>
			<dd>
				<?php echo $nbRelatives = $strain->getNbRelatives() ?>
				<?php if ( $nbRelatives > 0 ): ?>
					<a href="#strain_relatives_list" title="List of relatives linked to this strain" class="page_jump">see below</a>
				<?php endif; ?>
			</dd>
			
			<dt>Growth mediums:</dt>
			<dd>
				<?php echo $nbGrowthMediums = $strain->getNbGrowthMediums() ?>
				<?php if ( $nbGrowthMediums > 0 ): ?>
					<a href="#strain_growth_medium_list" title="List of growth mediums linked to this strain" class="page_jump">see below</a>
				<?php endif; ?>
			</dd>
			
			<dt>Transfer interval:</dt>
			<dd><?php echo $strain->getFormattedTransferInterval() ?></dd>
			
			<dt>Observation:</dt>
			<dd><?php echo $strain->getFormattedObservation() ?></dd>

			<?php if ( $strain->getIsolator()->getName() ): ?>
			<dt>Isolator:</dt>
			<dd><?php echo $strain->getIsolator() ?> ( <?php echo format_date($strain->getIsolationDate(), 'p') ?> )</dd>
			<?php endif; ?>
			
			<?php if ( $strain->getIdentifier()->getName() ): ?>
			<dt>Identifier:</dt>
			<dd><?php echo $strain->getIdentifier() ?> (<?php echo format_date($strain->getIdentificationDate(), 'p') ?>)</dd>
			<?php endif; ?>
			
			<?php if ( $strain->getDepositor()->getName() ): ?>
			<dt>Depositor:</dt>
			<dd><?php echo $strain->getDepositor() ?> (<?php echo format_date($strain->getDepositionDate(), 'p') ?>)</dd>
			<?php endif; ?>

			<dt>Citations:</dt>
			<dd><?php echo $strain->getFormattedCitations() ?></dd>
			
			<dt>Remarks:</dt>
			<dd><?php echo $strain->getRemarks() ?></dd>
		</dl>
	</div>
	
	<?php if ( $nbGrowthMediums > 0): ?>
	<div id="strain_growth_medium_list">
		<h2>Growth mediums</h2>
		<table>
			<tr>
				<th class="name">Name</th>
				<th class="description">Description</th>
				<th class="link">Link</th>
			</tr>
			<?php foreach ($strain->getGrowthMediums() as $growthMedium ): ?>
				<tr>
					<td><?php echo link_to($growthMedium->getName(), '@growth_medium_show?id='.$growthMedium->getId()) ?></td>
					<td><?php echo link_to($growthMedium->getDescription(), '@growth_medium_show?id='.$growthMedium->getId()) ?></td>
					<td><?php echo link_to($growthMedium->getLink(), '@growth_medium_show?id='.$growthMedium->getId()) ?></td>
				</tr>
			<?php endforeach ?>
		</table>
	</div>
	<?php endif ?>
	
	<?php if ( $nbRelatives > 0): ?>
	<div id="strain_relatives_list">
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
	
	<div class="clear"></div>
</div>
