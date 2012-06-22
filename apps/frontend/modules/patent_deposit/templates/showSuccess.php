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
<?php use_helper('Date', 'Thumbnail') ?>

<?php slot('main_header') ?>
<span>
	<?php echo $patentDeposit->getCode() ?> - <?php echo $patentDepositClass = $patentDeposit->getTaxonomicClass() ?>
	<span class="species_name">
		<?php echo $patentDepositGenus = $patentDeposit->getGenus() ?>
		<?php echo $patentDepositSpecies = $patentDeposit->getSpecies() ?>
	</span>
</span>
<?php include_partial('global/back_header_action', array('module' => 'patent_deposit')) ?>
<?php include_partial('global/edit_header_action', array('module' => 'patent_deposit', 'id' => $patentDeposit->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'patent_deposit', 'id' => $patentDeposit->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_related_models">
		<?php $nbCryopreservations = $patentDeposit->getNbCryopreservations() ?>
		<?php if ($nbCryopreservations > 0): ?>
		<div class="object_related_model_list">
			<h2>Cryopreservations</h2>
			<table>
				<tr>
					<th class="date">Date</th>
					<th class="cryopreservation_method">Method</th>
					<th class="cryopreservation_replicate">1<sup>st</sup>&nbsp;replicate</th>
					<th class="cryopreservation_replicate">2<sup>nd</sup>&nbsp;replicate</th>
					<th class="cryopreservation_replicate">3<sup>rd</sup>&nbsp;replicate</th>
				</tr>
				<?php foreach ($patentDeposit->getCryopreservations() as $cryopreservation): ?>
					<?php $url = '@cryopreservation_show?id='.$cryopreservation->getId() ?>
					<tr>
						<td class="date"><?php echo link_to($cryopreservation->getCryopreservationDate(), $url) ?></td>
						<td class="cryopreservation_method"><?php echo link_to($cryopreservation->getCryopreservationMethod(), $url) ?></td>
						<td class="cryopreservation_replicate"><?php echo link_to($cryopreservation->getFirstReplicate(), $url) ?></td>
						<td class="cryopreservation_replicate"><?php echo link_to($cryopreservation->getSecondReplicate(), $url) ?></td>
						<td class="cryopreservation_replicate"><?php echo link_to($cryopreservation->getThirdReplicate(), $url) ?></td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>
		<?php endif ?>

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

		<?php if ($filename = $patentDeposit->getPicture()): ?>
		<div id="object_related_models">
			<div class="object_related_model_list">
				<h2>Picture</h2>
				<div class="thumbnail">
					<div class="thumbnail_image">
						<a href="<?php echo get_picture_with_path($filename, 'patent_deposit') ?>" rel="thumbnail_link" title="Picture" class="cboxElement">
							<img src="<?php echo get_thumbnail($filename, 'patent_deposit') ?>" alt="Picture" />
						</a>
					</div>
				</div>
			</div>
		</div>
		<?php endif ?>

	</div>

	<div id="object_data_list">
		<dl>
			<dt>Code:</dt>
			<dd><?php echo $patentDeposit->getCode() ?></dd>

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
			<dd><span class="species_name"><?php echo $patentDepositSpecies ?></span></dd>

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
			<dd><?php echo $patentDeposit->getFormattedMaintenanceStatusList() ?></dd>

			<dt>Isolators:</dt>
			<dd><?php echo $nbIsolators ?>	</dd>

			<dt>Has DNA:</dt>
			<dd><?php echo $patentDeposit->getFormattedHasDna() ?></dd>

			<?php if ( $patentDeposit->getIdentifier()->getName() ): ?>
			<dt>Identifier:</dt>
			<dd><?php echo $patentDeposit->getIdentifier() ?></dd>
			<?php endif; ?>

			<dt>Supervisor:</dt>
			<dd><?php echo $patentDeposit->getSupervisor() ?></dd>

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
