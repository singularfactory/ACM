<?php use_helper('Date'); ?>

<?php slot('main_header') ?>
<span>
	<?php echo $maintenanceDeposit->getDepositorCode() ?> - <?php echo $maintenanceDepositClass = $maintenanceDeposit->getTaxonomicClass() ?>
	<span class="species_name"><?php echo $maintenanceDepositGenus = $maintenanceDeposit->getGenus() ?></span>
	<?php if ( ($maintenanceDepositSpecies = $maintenanceDeposit->getSpecies()) !== sfConfig::get('app_unknown_species_name') ): ?>
		<span class="species_name"><?php echo $maintenanceDepositSpecies ?></span>
	<?php else: ?>
		<?php echo $maintenanceDepositSpecies ?>
	<?php endif; ?>
</span>
<?php include_partial('global/back_header_action', array('module' => 'maintenance_deposit')) ?>
<?php include_partial('global/edit_header_action', array('module' => 'maintenance_deposit', 'id' => $maintenanceDeposit->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'maintenance_deposit', 'id' => $maintenanceDeposit->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_related_models">
		<?php $nbCultureMedia = $maintenanceDeposit->getNbCultureMedia() ?>
		<?php if ( $nbCultureMedia > 0): ?>
		<div class="object_related_model_list">
			<h2>Culture media</h2>
			<table>
				<tr>
					<th class="culture_medium_code">Code</th>
					<th class="culture_medium_name">Name</th>
				</tr>
				<?php foreach ($maintenanceDeposit->getCultureMedia() as $cultureMedium ): ?>
					<?php $url = '@culture_medium_show?id='.$cultureMedium->getId() ?>
					<tr>
						<td class="culture_medium_code"><?php echo link_to($cultureMedium->getCode(), $url) ?></td>
						<td class="culture_medium_name"><?php echo link_to($cultureMedium->getName(), $url) ?></td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
		<?php endif ?>
		
		<?php $nbIsolators = $maintenanceDeposit->getNbIsolators() ?>
		<?php if ( $nbIsolators > 0): ?>
		<div class="object_related_model_list">
			<h2>Isolators</h2>
			<table>
				<tr>
					<th class="isolator_name">Name</th>
					<th class="object_count_long">Total maintenance deposits</th>
				</tr>
				<?php foreach ($maintenanceDeposit->getIsolators() as $isolator ): ?>
				<tr>
					<td class="isolator_name"><?php echo $isolator ?></td>
					<td class="object_count_long"><?php echo $isolator->getNbMaintenanceDeposits() ?></span></td>
				</tr>
			<?php endforeach ?>
			</table>
		</div>
		<?php endif ?>
		
		<?php $nbCollectors = $maintenanceDeposit->getNbCollectors() ?>
		<?php if ( $nbCollectors > 0): ?>
		<div class="object_related_model_list">
			<h2>Collectors</h2>
			<table>
				<tr>
					<th class="collector_name">Name</th>
					<th class="object_count_long">Total maintenance deposits</th>
				</tr>
				<?php foreach ($maintenanceDeposit->getCollectors() as $collector ): ?>
				<tr>
					<td class="collector_name"><?php echo $collector ?></td>
					<td class="object_count_long"><?php echo $collector->getNbMaintenanceDeposits() ?></span></td>
				</tr>
			<?php endforeach ?>
			</table>
		</div>
		<?php endif ?>
		
		<?php $nbRelatives = $maintenanceDeposit->getNbRelatives() ?>
		<?php if ( $nbRelatives > 0): ?>
		<div class="object_related_model_list">
			<h2>Relatives</h2>
			<table>
				<tr>
					<th class="name">Name</th>
				</tr>
				<?php foreach ($maintenanceDeposit->getRelatives() as $relative ): ?>
					<tr>
						<td><?php echo $relative->getName() ?></td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
		<?php endif ?>
		
	</div>
	
	<div id="object_data_list">
		<dl>
			<dt>Depositor code:</dt>
			<dd><?php echo $maintenanceDeposit->getDepositorCode() ?></dd>

			<dt>Depositor:</dt>
			<dd><?php echo $maintenanceDeposit->getDepositor() ?></dd>

			<dt>Deposition date:</dt>
			<dd><?php echo $maintenanceDeposit->getDepositionDate() ?></dd>
			
			<dt>Location:</dt>
			<dd><?php echo link_to($maintenanceDeposit->getLocation()->getName(), "@location_show?id={$maintenanceDeposit->getLocationId()}") ?></dd>
			<dt>Environment:</dt>
			<dd><?php echo $maintenanceDeposit->getEnvironment() ?></dd>

			<dt>Habitat:</dt>
			<dd><?php echo $maintenanceDeposit->getHabitat() ?></dd>
			
			<dt>Class:</dt>
			<dd><?php echo $maintenanceDepositClass ?></dd>

			<dt>Genus:</dt>
			<dd><span class="species_name"><?php echo $maintenanceDepositGenus ?></span></dd>

			<dt>Species:</dt>
			<dd>
				<?php if ( $maintenanceDepositSpecies !== sfConfig::get('app_unknown_species_name') ): ?>
				<span class="species_name"><?php echo $maintenanceDepositSpecies ?></span>
				<?php else: ?>
				<?php echo $maintenanceDepositSpecies ?>
				<?php endif; ?>
			</dd>

			<dt>Authority:</dt>
			<dd><?php echo $maintenanceDeposit->getAuthority() ?></dd>
			
			<dt>Collectors:</dt>
			<dd><?php echo $nbCollectors ?></dd>
			
			<dt>Is epitype:</dt>
			<dd><?php echo $maintenanceDeposit->getFormattedIsEpitype() ?></dd>

			<dt>Is axenic:</dt>
			<dd><?php echo $maintenanceDeposit->getFormattedIsAxenic() ?></dd>

			<dt>Culture media:</dt>
			<dd><?php echo $nbCultureMedia ?></dd>
			
			<dt>Maintenance status:</dt>
			<dd>
			<?php
				$isCryopreserved = false;
				$firstMaintenanceStatus = true;
				foreach ($maintenanceDeposit->getMaintenanceStatus() as $status ) {
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
									
			<?php if ( $maintenanceDeposit->getMaintenanceStatus() === sfConfig::get('app_maintenance_status_cryopreserved') ): ?>
			<dt>Cryopreservation:</dt>
			<dd><?php echo $maintenanceDeposit->getCryopreservationMethod() ?></dd>
			<?php endif; ?>
			
			<dt>Isolators:</dt>
			<dd><?php echo $nbIsolators ?>	</dd>
			
			<dt>Has DNA:</dt>
			<dd><?php echo $maintenanceDeposit->getFormattedHasDna() ?></dd>
			
			<?php if ( $maintenanceDeposit->getIdentifier()->getName() ): ?>
			<dt>Identifier:</dt>
			<dd><?php echo $maintenanceDeposit->getIdentifier() ?></dd>
			<?php endif; ?>
			
			<dt>Gen sequence:</dt>
			<dd><?php echo $maintenanceDeposit->getGenSequence() ?></dd>
			
			<dt>Relatives:</dt>
			<dd><?php echo $nbRelatives ?></dd>
			
			<dt>Transfer interval:</dt>
			<dd><?php echo $maintenanceDeposit->getFormattedTransferInterval() ?></dd>
			
			<dt>Observation:</dt>
			<dd><?php echo $maintenanceDeposit->getFormattedObservation() ?></dd>
			
			<dt>Viability test:</dt>
			<dd><?php echo $maintenanceDeposit->getFormattedViabilityTest() ?></dd>
			
			<dt>Citations:</dt>
			<dd><?php echo $maintenanceDeposit->getFormattedCitations() ?></dd>
			
			<dt>Remarks:</dt>
			<dd><?php echo $maintenanceDeposit->getRemarks() ?></dd>
			
			<dt>MF1 document:</dt>
			<dd>
				<?php if ( $url = $maintenanceDeposit->getMf1DocumentUrl() ): ?>
				<?php echo link_to($maintenanceDeposit->getMf1Document(), $url) ?>
				<?php else: ?>
				<?php echo sfConfig::get('app_no_data_message') ?>
				<?php endif; ?>
			</dd>
		</dl>
	</div>
	
	<div class="clear"></div>
</div>
