<?php use_helper('Date'); ?>

<?php slot('main_header') ?>
<span>
	<?php echo $patentDeposit->getDepositorCode() ?> - <?php echo $patentDepositClass = $patentDeposit->getTaxonomicClass() ?>
	<span class="species_name"><?php echo $patentDepositGenus = $patentDeposit->getGenus() ?></span>
	<?php if ( ($patentDepositSpecies = $patentDeposit->getSpecies()) !== sfConfig::get('app_unknown_species_name') ): ?>
		<span class="species_name"><?php echo $patentDepositSpecies ?></span>
	<?php else: ?>
		<?php echo $patentDepositSpecies ?>
	<?php endif; ?>
</span>
<?php include_partial('global/back_header_action', array('module' => 'patent_deposit')) ?>
<?php include_partial('global/edit_header_action', array('module' => 'patent_deposit', 'id' => $patentDeposit->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'patent_deposit', 'id' => $patentDeposit->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_related_models">
		<?php $nbCultureMedia = $patentDeposit->getNbCultureMedia() ?>
		<?php if ( $nbCultureMedia > 0): ?>
		<div class="object_related_model_list">
			<h2>Culture media</h2>
			<table>
				<tr>
					<th class="culture_medium_code">Code</th>
					<th class="culture_medium_name">Name</th>
				</tr>
				<?php foreach ($patentDeposit->getCultureMedia() as $cultureMedium ): ?>
					<?php $url = '@culture_medium_show?id='.$cultureMedium->getId() ?>
					<tr>
						<td class="culture_medium_code"><?php echo link_to($cultureMedium->getCode(), $url) ?></td>
						<td class="culture_medium_name"><?php echo link_to($cultureMedium->getName(), $url) ?></td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
		<?php endif ?>
		
		<?php $nbIsolators = $patentDeposit->getNbIsolators() ?>
		<?php if ( $nbIsolators > 0): ?>
		<div class="object_related_model_list">
			<h2>Isolators</h2>
			<table>
				<tr>
					<th class="isolator_name">Name</th>
					<th class="object_count_long">Total patent deposits</th>
				</tr>
				<?php foreach ($patentDeposit->getIsolators() as $isolator ): ?>
				<tr>
					<td class="isolator_name"><?php echo $isolator ?></td>
					<td class="object_count_long"><?php echo $isolator->getNbPatentDeposits() ?></span></td>
				</tr>
			<?php endforeach ?>
			</table>
		</div>
		<?php endif ?>
		
		<?php $nbCollectors = $patentDeposit->getNbCollectors() ?>
		<?php if ( $nbCollectors > 0): ?>
		<div class="object_related_model_list">
			<h2>Collectors</h2>
			<table>
				<tr>
					<th class="collector_name">Name</th>
					<th class="object_count_long">Total patent deposits</th>
				</tr>
				<?php foreach ($patentDeposit->getCollectors() as $collector ): ?>
				<tr>
					<td class="collector_name"><?php echo $collector ?></td>
					<td class="object_count_long"><?php echo $collector->getNbPatentDeposits() ?></span></td>
				</tr>
			<?php endforeach ?>
			</table>
		</div>
		<?php endif ?>
		
		<?php $nbRelatives = $patentDeposit->getNbRelatives() ?>
		<?php if ( $nbRelatives > 0): ?>
		<div class="object_related_model_list">
			<h2>Relatives</h2>
			<table>
				<tr>
					<th class="name">Name</th>
				</tr>
				<?php foreach ($patentDeposit->getRelatives() as $relative ): ?>
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
			<dd><?php echo $patentDeposit->getDepositorCode() ?></dd>

			<dt>Depositor:</dt>
			<dd><?php echo $patentDeposit->getDepositor() ?></dd>

			<dt>Deposition date:</dt>
			<dd><?php echo $patentDeposit->getDepositionDate() ?></dd>
			
			<dt>Location:</dt>
			<dd><?php echo link_to($patentDeposit->getLocation()->getName(), "@location_show?id={$patentDeposit->getLocationId()}") ?></dd>
			<dt>Environment:</dt>
			<dd><?php echo $patentDeposit->getFormattedEnvironment() ?></dd>

			<dt>Habitat:</dt>
			<dd><?php echo $patentDeposit->getFormattedHabitat() ?></dd>
			
			<dt>Class:</dt>
			<dd><?php echo $patentDepositClass ?></dd>

			<dt>Genus:</dt>
			<dd><span class="species_name"><?php echo $patentDepositGenus ?></span></dd>

			<dt>Species:</dt>
			<dd>
				<?php if ( $patentDepositSpecies !== sfConfig::get('app_unknown_species_name') ): ?>
				<span class="species_name"><?php echo $patentDepositSpecies ?></span>
				<?php else: ?>
				<?php echo $patentDepositSpecies ?>
				<?php endif; ?>
			</dd>

			<dt>Authority:</dt>
			<dd><?php echo $patentDeposit->getAuthority() ?></dd>
			
			<dt>Collectors:</dt>
			<dd><?php echo $nbCollectors ?></dd>
			
			<dt>Is epitype:</dt>
			<dd><?php echo $patentDeposit->getFormattedIsEpitype() ?></dd>

			<dt>Is axenic:</dt>
			<dd><?php echo $patentDeposit->getFormattedIsAxenic() ?></dd>

			<dt>Culture media:</dt>
			<dd><?php echo $nbCultureMedia ?></dd>
			
			<dt>Maintenance status:</dt>
			<dd>
			<?php
				$isCryopreserved = false;
				$firstMaintenanceStatus = true;
				foreach ($patentDeposit->getMaintenanceStatus() as $status ) {
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
									
			<?php if ( $patentDeposit->getMaintenanceStatus() === sfConfig::get('app_maintenance_status_cryopreserved') ): ?>
			<dt>Cryopreservation:</dt>
			<dd><?php echo $patentDeposit->getCryopreservationMethod() ?></dd>
			<?php endif; ?>
			
			<dt>Isolators:</dt>
			<dd><?php echo $nbIsolators ?>	</dd>
			
			<dt>Has DNA:</dt>
			<dd><?php echo $patentDeposit->getFormattedHasDna() ?></dd>
			
			<?php if ( $patentDeposit->getIdentifier()->getName() ): ?>
			<dt>Identifier:</dt>
			<dd><?php echo $patentDeposit->getIdentifier() ?></dd>
			<?php endif; ?>
			
			<dt>Gen sequence:</dt>
			<dd><?php echo $patentDeposit->getGenSequence() ?></dd>
			
			<dt>Relatives:</dt>
			<dd><?php echo $nbRelatives ?></dd>
			
			<dt>Transfer interval:</dt>
			<dd><?php echo $patentDeposit->getFormattedTransferInterval() ?></dd>
			
			<dt>Observation:</dt>
			<dd><?php echo $patentDeposit->getFormattedObservation() ?></dd>
			
			<dt>Viability test:</dt>
			<dd><?php echo $patentDeposit->getFormattedViabilityTest() ?></dd>
			
			<dt>Citations:</dt>
			<dd><?php echo $patentDeposit->getFormattedCitations() ?></dd>
			
			<dt>Remarks:</dt>
			<dd><?php echo $patentDeposit->getRemarks() ?></dd>
			
			<dt>BP1 document:</dt>
			<dd>
				<?php if ( $url = $patentDeposit->getBp1DocumentUrl() ): ?>
				<?php echo link_to($patentDeposit->getBp1Document(), $url) ?>
				<?php else: ?>
				<?php echo sfConfig::get('app_no_data_message') ?>
				<?php endif; ?>
			</dd>
			
			<dt>BP4 document:</dt>
			<dd>
				<?php if ( $url = $patentDeposit->getBp4DocumentUrl() ): ?>
				<?php echo link_to($patentDeposit->getBp4Document(), $url) ?>
				<?php else: ?>
				<?php echo sfConfig::get('app_no_data_message') ?>
				<?php endif; ?>
			</dd>
		</dl>
	</div>
	
	<div class="clear"></div>
</div>
