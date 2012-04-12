<?php use_helper('Thumbnail') ?>
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
				<dd>
					<?php echo $strain->getSample()->getHabitat() ?><?php if ($strain->getSample()->getLocationDetails()) echo ', '. lcfirst($strain->getSample()->getLocationDetails()) ?>
				</dd>
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

		<div class="article_content_section">
		</div>
		<div class="clear"></div>
	</div>

	<div id="right_side_form">
		<?php if ( $strain->getNbPictures() > 0 ): ?>
		<div class="article_content_section">
			<h3>Strain picture</h3>
			<?php echo $form['strain_picture']->renderHelp() ?>
			<?php foreach ($strain->getPictures() as $picture): ?>
			<?php if ( $picture->getFilename() === null ) continue ?>
			<div class="thumbnail">
				<input type="radio" name="strain_picture" value="<?php echo $picture->getId() ?>" id="strain_picture" />
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