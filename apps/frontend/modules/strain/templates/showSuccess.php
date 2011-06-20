<?php use_helper('Date'); ?>

<?php slot('main_header') ?>
<span>Strain <?php echo $strain->getNumber() ?></span>
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
			<dd><?php echo $strain->getTaxonomicClass() ?></dd>
			<dt>Genus:</dt>
			<dd><?php echo $strain->getGenus() ?></dd>
			<dt>Species:</dt>
			<dd><?php echo $strain->getSpecies() ?></dd>
			<dt>Authority:</dt>
			<dd><?php echo $strain->getAuthority() ?></dd>
			
			<dt>Maintenance status:</dt>
			<dd><?php echo $strain->getMaintenanceStatus() ?></dd>
			
			<dt>Cryopreservation:</dt>
			<dd><?php echo $strain->getCryopreservationMethod() ?></dd>
			
			<dt>Growth mediums:</dt>
			<dd>
				<?php echo $nbGrowthMediums = $strain->getNbGrowthMediums() ?>
				<?php if ( $nbGrowthMediums > 0 ): ?>
					<a href="#strain_growth_medium_list" title="List of growth mediums linked to this strain" class="page_jump">see below</a>
				<?php endif; ?>
			</dd>
			
			<dt>Transfer interval:</dt>
			<dd><?php echo $strain->getTransferInterval() ?></dd>
			
			<dt>Observation:</dt>
			<dd><?php echo $strain->getObservation() ?></dd>

			<dt>Isolator:</dt>
			<dd><?php echo $strain->getIsolator() ?></dd>
			<dt>Isolation date:</dt>
			<dd><?php echo format_date($strain->getIsolationDate(), 'p') ?></dd>
			
			<dt>Identifier:</dt>
			<dd><?php echo $strain->getIdentifier() ?></dd>
			<dt>Identification date:</dt>
			<dd><?php echo format_date($strain->getIdentificationDate(), 'p') ?></dd>
			
			<dt>Depositor:</dt>
			<dd><?php echo $strain->getDepositor() ?></dd>
			<dt>Deposition date:</dt>
			<dd><?php echo format_date($strain->getDepositionDate(), 'p') ?></dd>

			<dt>Citations:</dt>
			<dd><?php echo $strain->getCitations() ?></dd>
			
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
	

	<div class="clear"></div>
</div>
