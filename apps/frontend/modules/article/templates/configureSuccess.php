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
<?php use_helper('Thumbnail', 'GMap') ?>
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php slot('main_header') ?>
<span class="species_name"><?php echo $strain->getGenus() ?>&nbsp;<?php echo $strain->getSpecies() ?></span>&nbsp;<?php echo $strain->getAuthority() ?>
<span class="bea_code"><?php echo $strain->getFullCode() ?></span>
<?php end_slot() ?>

<form action="<?php echo url_for('@article_create') ?>" method="POST">
	<?php echo $form->renderHiddenFields() ?>

	<div id="left_side_form">
		<div class="article_content_section">
			<h3>Taxonomy</h3>
			<dl>
				<dt>Kingdom</dt>
				<dd><?php echo $strain->getFormattedKingdom() ?></dd>
				<dt>Subkingdom</dt>
				<dd><?php echo $strain->getFormattedSubkingdom() ?></dd>
				<dt>Phylum</dt>
				<dd><?php echo $strain->getFormattedPhylum() ?></dd>
				<dt>Class</dt>
				<dd><?php echo $strain->getTaxonomicClass() ?></dd>
				<dt>Order</dt>
				<dd><?php echo $strain->getFormattedTaxonomicOrder() ?></dd>
				<dt>Family</dt>
				<dd><?php echo $strain->getFormattedFamily() ?></dd>
			</dl>
		</div>

		<div class="article_content_section">
			<h3>Environmental conditions</h3>
			<dl>
				<dt>Latitude</dt>
				<dd><?php echo $strain->getSample()->getLatitude() ?></dd>
				<dt>Longitude</dt>
				<dd><?php echo $strain->getSample()->getLongitude() ?></dd>
				<dt>Habitat</dt>
				<dd><?php echo $strain->getHabitatDescription() ?></dd>
				<dt>Location</dt>
				<dd><?php echo $strain->getSample()->getLocation() ?>, <?php echo $strain->getSample()->getLocation()->getRegion() ?></dd>
				<dt>Country</dt>
				<dd><?php echo $strain->getSample()->getLocation()->getCountry() ?></dd>
				<dt>Worldwide distribution</dt>
				<dd><?php echo $strain->getDistribution() ?></dd>
			</dl>
		</div>

		<div class="article_content_section">
			<h3>Culture conditions</h3>
			<dl>
				<dt>Culture medium</dt>
				<dd>
					<?php echo $form['culture_media_list']->renderLabel() ?>
					<?php echo $form['culture_media_list']->renderError() ?>
					<?php echo $form['culture_media_list']->renderHelp() ?>
					<?php echo $form['culture_media_list'] ?>
				</dd>
				<dt>Irradiation</dt>
				<dd><?php echo $strain->getIrradiation() ?></dd>
				<dt>Temperature</dt>
				<dd><?php echo $strain->getTemperature() ?>&nbsp;<?php echo sfConfig::get('app_temperature_unit') ?></dd>
				<dt>Photoperiod</dt>
				<dd><?php echo $strain->getPhotoperiod() ?></dd>
			</dl>
		</div>

		<?php $sample = $strain->getSample() ?>
		<?php $location = $strain->getSample()->getLocation() ?>
		<?php if ( $location->getNbPictures() > 0 || $sample->hasPictures() ): ?>
			<div class="article_content_section">
				<h3>Location pictures</h3>
				<?php echo $form['location_picture']->renderError() ?>
				<?php echo $form['location_picture']->renderHelp() ?>

				<?php foreach ($location->getPictures() as $picture): ?>
				<?php if ( $picture->getFilename() === null ) continue ?>
				<div class="thumbnail">
					<input type="radio" name="location_picture" value="<?php echo $picture->getId() ?>" class="location_picture"/>
					<div class="thumbnail_image">
						<a href="<?php echo $picture->getFilenameWithPath() ?>" rel="thumbnail_link" class="cboxElement">
							<img src="<?php echo $picture->getThumbnail() ?>" />
						</a>
					</div>
				</div>
				<?php endforeach; ?>

				<?php foreach ($sample->getFieldPictures() as $picture): ?>
				<?php if ( $picture->getFilename() === null ) continue ?>
				<div class="thumbnail">
					<input type="radio" name="location_picture" value="<?php echo $picture->getId() ?>" class="field_picture"/>
					<div class="thumbnail_image">
						<a href="<?php echo $picture->getFilenameWithPath() ?>" rel="thumbnail_link" class="cboxElement">
							<img src="<?php echo $picture->getThumbnail() ?>" />
						</a>
					</div>
				</div>
				<?php endforeach; ?>

				<?php foreach ($sample->getDetailedPictures() as $picture): ?>
				<?php if ( $picture->getFilename() === null ) continue ?>
				<div class="thumbnail">
					<input type="radio" name="location_picture" value="<?php echo $picture->getId() ?>" class="detailed_picture"/>
					<div class="thumbnail_image">
						<a href="<?php echo $picture->getFilenameWithPath() ?>" rel="thumbnail_link" class="cboxElement">
							<img src="<?php echo $picture->getThumbnail() ?>" />
						</a>
					</div>
				</div>
				<?php endforeach; ?>

				<div class="clear"></div>
			</div>
		<?php endif ?>
	</div>

	<div id="right_side_form">
		<?php if ( $strain->getNbPictures() > 0 ): ?>
		<div class="article_content_section">
			<h3>Strain picture</h3>
			<?php echo $form['location_picture']->renderError() ?>
			<?php echo $form['strain_picture']->renderHelp() ?>
			<?php foreach ($strain->getPictures() as $picture): ?>
			<?php if ( $picture->getFilename() === null ) continue ?>
			<div class="thumbnail">
				<input type="radio" name="strain_picture" value="<?php echo $picture->getId() ?>" class="strain_picture" />
				<div class="thumbnail_image">
					<a href="<?php echo $picture->getFilenameWithPath() ?>" rel="thumbnail_link" class="cboxElement">
						<img src="<?php echo $picture->getThumbnail() ?>" />
					</a>
				</div>
			</div>
			<?php endforeach; ?>
			<div class="clear"></div>
		</div>
		<?php endif ?>

		<div class="article_content_section">
			<h3>Description</h3>
			<p><?php echo $strain->getArticleDescription() ?></p>
		</div>

		<div class="article_content_section">
			<h3>Map</h3>
			<div id="object_google_map">
				<?php include_map($googleMap) ?>
			</div>
		</div>

		<div class="article_content_section">
			<h3>Molecular taxonomy</h3>
			<dl>
				<dt>Genomic DNA</dt>
				<dd><?php echo $strain->getPublicDnaAmount() ? 'disponible en el banco de ADN' : 'no disponible' ?></dd>
				<dt>Sequenced genes</dt>
				<dd><?php echo implode(', ', $strain->getSequencedGenes()->getRawValue()) ?></dd>
			</dl>
		</div>

		<div id="phylogenetic_information" class="article_content_section">
			<h3>Phylogenetic tree</h3>
			<?php if ( $strain->getPhylogeneticDescription() ): ?>
			<p><?php echo $strain->getPhylogeneticDescription() ?></p>
			<?php endif ?>
			<div class="thumbnail">
				<div class="thumbnail_image">
					<a href="<?php echo $strain->getPhylogeneticTreePath() ?>" rel="thumbnail_link" class="cboxElement">
						<img src="<?php echo $strain->getPhylogeneticTreeThumbnail() ?>" />
					</a>
				</div>
			</div>
		</div>

	</div>

	<div class="submit"><input type="submit" value="Download article" /></div>
</form>
<?php include_map_javascript($googleMap) ?>