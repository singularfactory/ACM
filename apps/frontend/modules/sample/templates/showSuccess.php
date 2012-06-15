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
<?php use_helper('Date', 'GMap', 'Gps') ?>

<?php slot('main_header') ?>
<span>Sample <?php echo $sample->getCode() ?></span>
<?php include_partial('global/back_header_action', array('module' => 'sample')) ?>
<?php include_partial('global/label_header_action', array('message' => 'Create label', 'route' => '@sample_create_label?id='.$sample->getId())) ?>
<?php include_partial('global/edit_header_action', array('module' => 'sample', 'id' => $sample->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'sample', 'id' => $sample->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_google_map">
		<?php include_map($googleMap, array('width' => '400px', 'height' => '400px')); ?>
		<?php include_partial('global/gmap_legend', array('name' => 'sample')) ?>
	</div>

	<div id="object_data_list">
		<dl>
			<dt>Notebook code:</dt>
			<dd><?php echo $sample->getNotebookCode() ?></dd>
			<dt>Location:</dt>
			<dd><?php echo link_to($sample->getLocation()->getName(), "@location_show?id={$sample->getLocation()->getId()}") ?></dd>
			<dt>Location details:</dt>
			<dd><?php echo $sample->getLocationDetails() ?></dd>
			<dt>Environment:</dt>
			<dd><?php echo $sample->getFormattedEnvironment() ?></dd>
			<dt>Is extremophile:</dt>
			<dd><?php echo $sample->getFormattedIsExtremophile() ?></dd>
			<dt>Habitat:</dt>
			<dd><?php echo $sample->getFormattedHabitat() ?></dd>
			<dt>Ph:</dt>
			<dd><?php echo $sample->getFormattedPh() ?></dd>
			<dt>Conductivity:</dt>
			<dd><?php echo $sample->getFormattedConductivity() ?></dd>
			<dt>Temperature:</dt>
			<dd><?php echo $sample->getFormattedTemperature() ?></dd>
			<dt>Salinity:</dt>
			<dd><?php echo $sample->getFormattedSalinity() ?></dd>
			<dt>Altitude:</dt>
			<dd><?php echo $sample->getFormattedAltitude() ?></dd>
			<dt>Radiation:</dt>
			<dd><?php echo $sample->getRadiation()->getName() ?></dd>
			<dt>Strains:</dt>
			<dd>
				<?php echo $nbStrains = $sample->getNbStrains() ?>
				<?php if ( $nbStrains > 0 ): ?>
					<a href="#sample_strains_list" title="List of strains who come from this sample" class="page_jump">see below</a>
				<?php endif; ?>
			</dd>
			<dt>Collectors:</dt>
			<dd>
				<?php echo $nbCollectors = $sample->getNbCollectors() ?>
				<?php if ( $nbCollectors > 0 ): ?>
					<a href="#sample_collectors_list" title="List of collectors who gather this sample" class="page_jump">see below</a>
				<?php endif; ?>
			</dd>
			<dt>Collection date:</dt>
			<dd><?php echo $sample->getFormattedCollectionDate() ?></dd>
			<dt>GPS coordinates:</dt>
			<dd>
				<?php
					$gpsCoordinates = $sample->getFormattedGPSCoordinates();

					if ( $gpsCoordinates === sfConfig::get('app_no_data_message') ) {
						echo convert_to_dms($googleMap->coordinates['latitude']).', '.convert_to_dms($googleMap->coordinates['longitude']).'&nbsp;<span class="field_warning">(estimated from available information)</span>';
					}
					else {
						echo $gpsCoordinates;
					}
				?>
			</dd>
			<dt>Isolations:</dt>
			<dd>
				<?php echo $nbIsolations = $sample->getNbIsolations() ?>
				<?php if ( $nbIsolations > 0 ): ?>
					<a href="#sample_isolations_list" title="List of isolations applied to this sample" class="page_jump">see below</a>
				<?php endif; ?>
			</dd>
			<dt>Remarks:</dt>
			<dd><?php echo $sample->getRemarks() ?></dd>
		</dl>
	</div>

	<?php if ( $sample->getNbFieldPictures() > 0 ): ?>
	<div class="object_related_model_long_list">
		<h2>Field pictures</h2>
		<?php $i = 1 ?>
		<?php foreach ($sample->getFieldPictures() as $picture): ?>
		<?php if ( $picture->getFilename() === null ) continue ?>
		<div class="thumbnail">
			<div class="thumbnail_image">
				<a href="<?php echo $picture->getFilenameWithPath() ?>" rel="thumbnail_link" title="Picture <?php echo $i ?>" class="cboxElement">
					<img src="<?php echo $picture->getThumbnail() ?>" alt="Picture <?php echo $i ?>" />
				</a>
			</div>
		</div>
		<?php $i++ ?>
		<?php endforeach; ?>
	</div>
	<?php endif ?>

	<?php if ( $sample->getNbDetailedPictures() > 0 ): ?>
	<div class="object_related_model_long_list">
		<h2>Detailed pictures</h2>
		<?php $i = 1 ?>
		<?php foreach ($sample->getDetailedPictures() as $picture): ?>
		<?php if ( $picture->getFilename() === null ) continue ?>
		<div class="thumbnail">
			<div class="thumbnail_image">
				<a href="<?php echo $picture->getFilenameWithPath() ?>" rel="thumbnail_link" title="Picture <?php echo $i ?>" class="cboxElement">
					<img src="<?php echo $picture->getThumbnail() ?>" alt="Picture <?php echo $i ?>" />
				</a>
			</div>
		</div>
		<?php $i++ ?>
		<?php endforeach; ?>
	</div>
	<?php endif ?>

	<?php if ( $sample->getNbMicroscopicPictures() > 0 ): ?>
	<div class="object_related_model_long_list">
		<h2>Microscopic pictures</h2>
		<?php $i = 1 ?>
		<?php foreach ($sample->getMicroscopicPictures() as $picture): ?>
		<?php if ( $picture->getFilename() === null ) continue ?>
		<div class="thumbnail">
			<div class="thumbnail_image">
				<a href="<?php echo $picture->getFilenameWithPath() ?>" rel="thumbnail_link" title="Picture <?php echo $i ?>" class="cboxElement">
					<img src="<?php echo $picture->getThumbnail() ?>" alt="Picture <?php echo $i ?>" />
				</a>
			</div>
		</div>
		<?php $i++ ?>
		<?php endforeach; ?>
	</div>
	<?php endif ?>

	<?php if ( $nbStrains > 0): ?>
	<div id="sample_strains_list" class="object_related_model_long_list">
		<h2>Strains</h2>
		<table>
			<tr>
				<th class="code">Code</th>
				<th>Class</th>
				<th>Genus</th>
				<th>Species</th>
			</tr>
			<?php foreach ($sample->getStrains() as $strain ): ?>
			<?php $url = '@strain_show?id='.$strain->getId() ?>
			<tr>
				<td><?php echo link_to($strain->getFullCode(), $url) ?></td>
				<td><?php echo link_to($strain->getTaxonomicClass(), $url) ?></td>
				<td><span class="species_name"><?php echo link_to($strain->getGenus(), $url) ?></span></td>
				<td><span class="species_name"><?php echo link_to($strain->getSpecies(), $url) ?></span></td>
			</tr>
		<?php endforeach ?>
		</table>
	</div>
	<?php endif ?>

	<?php if ( $nbCollectors > 0): ?>
	<div id="sample_collectors_list" class="object_related_model_long_list">
		<h2>Collectors</h2>
		<table>
			<tr>
				<th>Name</th>
				<th class="object_count_long">Total samples</th>
			</tr>
			<?php foreach ($sample->getCollectors() as $collector ): ?>
			<tr>
				<td><?php echo $collector->getName() ?> <?php echo $collector->getSurname() ?></td>
				<td class="object_count_long"><?php echo $collector->getNbSamples() ?></span></td>
			</tr>
		<?php endforeach ?>
		</table>
	</div>
	<?php endif ?>

	<?php if ( $nbIsolations > 0): ?>
	<div id="sample_isolations_list" class="object_related_model_long_list">
		<h2>Isolations</h2>
		<table>
			<tr>
				<th class="date reception_date">Reception date</th>
				<th class="date delivery_date">Delivery date</th>
				<th class="purification_method">Purification method</th>
				<th class="purification_details">Purification details</th>
			</tr>
			<?php foreach ($sample->getIsolations() as $isolation ): ?>
			<?php $url = '@isolation_show?id='.$isolation->getId() ?>
			<tr>
				<td class="date reception_date"><?php echo link_to($isolation->getReceptionDate(), $url) ?></td>
				<td class="date delivery_date"><?php echo link_to($isolation->getDeliveryDate(), $url) ?></td>
				<td class="purification_method"></td>
				<td class="purification_details"></td>
			</tr>
		<?php endforeach ?>
		</table>
	</div>
	<?php endif ?>

	<div class="clear"></div>
</div>

<?php include_map_javascript($googleMap); ?>
