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
<span>Identification request for sample <?php echo $identification->getSample()->getCode() ?></span>
<?php include_partial('global/back_header_action', array('module' => 'identification')) ?>
<?php include_partial('global/label_header_action', array('message' => 'Create label', 'route' => '@identification_create_label?id='.$identification->getId())) ?>
<?php include_partial('global/edit_header_action', array('module' => 'identification', 'id' => $identification->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'identification', 'id' => $identification->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<?php if ( $filename = $identification->getSamplePicture() ): ?>
	<div id="object_related_models">
		<div class="object_related_model_list">
			<h2>Sample picture</h2>
			<div class="thumbnail">
				<div class="thumbnail_image">
					<a href="<?php echo get_picture_with_path($filename, 'identification') ?>" rel="thumbnail_link" title="Sample picture" class="cboxElement">
						<img src="<?php echo get_thumbnail($filename, 'identification') ?>" alt="Sample picture" />
					</a>
				</div>
			</div>
		</div>
	</div>
	<?php endif ?>

	<div id="object_data_list">
		<dl class="identification">
			<dt>Date:</dt>
			<dd><?php echo $identification->getIdentificationDate() ?></dd>

			<dt>Petitioner:</dt>
			<dd><?php echo $identification->getFormattedPetitioner() ?></dd>

			<dt>Sample:</dt>
			<dd><?php echo $identification->getSample()->getCode() ?></dd>

			<dt>Request document:</dt>
			<dd>
				<?php if ( $url = $identification->getRequestDocumentUrl() ): ?>
				<?php echo link_to($identification->getRequestDocument(), $url) ?>
				<?php else: ?>
				<?php echo sfConfig::get('app_no_data_message') ?>
				<?php endif; ?>
			</dd>

			<dt>Report document:</dt>
			<dd>
				<?php if ( $url = $identification->getReportDocumentUrl() ): ?>
				<?php echo link_to($identificationidentification->getReportDocument(), $url) ?>
				<?php else: ?>
				<?php echo sfConfig::get('app_no_data_message') ?>
				<?php endif; ?>
			</dd>

			<dt>Microscopy identification:</dt>
			<dd><?php echo $identification->getMicroscopyIdentification() ?></dd>

			<dt>Molecular identification:</dt>
			<dd><?php echo $identification->getMolecularIdentification() ?></dd>

			<dt>Remarks:</dt>
			<dd><?php echo $identification->getRemarks() ?></dd>
		</dl>
	</div>

	<div class="clear"></div>
</div>
