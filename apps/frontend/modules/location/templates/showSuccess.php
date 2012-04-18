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
<?php use_helper('GMap', 'Gps') ?>

<?php slot('main_header') ?>
<span><?php echo $location->getName() ?></span>
<?php include_partial('global/back_header_action', array('module' => 'location')) ?>
<?php include_partial('global/edit_header_action', array('module' => 'location', 'id' => $location->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'location', 'id' => $location->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_google_map">
		<?php include_map($googleMap, array('width' => '400px', 'height' => '400px')); ?>
		<?php include_partial('global/gmap_legend', array('name' => 'location')) ?>
	</div>

	<div id="object_data_list">
		<dl>
			<dt>Country:</dt>
			<dd><?php echo $location->getCountry()->getName() ?></dd>
			<dt>Region:</dt>
			<dd><?php echo $location->getRegion()->getName() ?></dd>
			<dt>Island:</dt>
			<dd><?php echo $location->getIsland()->getName() ?></dd>
			<dt>Category:</dt>
			<dd><?php echo $location->getFormattedCategory() ?></dd>
			<dt>GPS coordinates:</dt>
			<dd>
			<?php
				$gpsCoordinates = $location->getFormattedGPSCoordinates();

				if ( $gpsCoordinates === sfConfig::get('app_no_data_message') ) {
					echo convert_to_dms($googleMap->coordinates['latitude']).', '.convert_to_dms($googleMap->coordinates['longitude']).'&nbsp;<span class="field_warning">(estimated from available information)</span>';
				}
				else {
					echo $gpsCoordinates;
				}
			?>
			</dd>
			<dt>Samples:</dt>
			<dd>
				<?php echo $nbSamples = $location->getNbSamples() ?>
				<?php if ( $nbSamples > 0 ): ?>
					<a href="#location_sample_list" title="List of samples linked to this location" class="page_jump">see below</a>
				<?php endif; ?>
			</dd>
			<dt>Remarks:</dt>
			<dd><?php echo $location->getRemarks() ?></dd>
		</dl>
	</div>

	<?php if ( $location->getNbPictures() > 0 ): ?>
	<div class="object_related_model_long_list">
		<h2>Pictures</h2>
		<?php $i = 1 ?>
		<?php foreach ($location->getPictures() as $picture): ?>
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

	<?php if ( $nbSamples > 0): ?>
	<div id="location_sample_list" class="object_related_model_long_list">
		<h2>Samples</h2>
		<table>
			<tr>
				<th>Number</th>
				<th>Collector</th>
				<th>Date</th>
			</tr>
			<?php foreach ($location->getSamples() as $sample ): ?>
			<?php $url = '@sample_show?id='.$sample->getId() ?>
				<tr>
					<td><?php echo link_to($sample->getCode(), $url) ?></td>
					<td><?php echo link_to($sample->getFormattedCollectors(), $url) ?></td>
					<td><?php echo link_to($sample->getCollectionDate(), $url) ?></td>
				</tr>
			<?php endforeach ?>
		</table>
	</div>
	<?php endif ?>

	<div class="clear"></div>
</div>

<?php include_map_javascript($googleMap); ?>