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
			<h3>Taxonomía</h3>
			<dl>
				<dt>Reino</dt>
				<dd><?php echo $strain->getFormattedKingdom() ?></dd>
				<dt>Subreino</dt>
				<dd><?php echo $strain->getFormattedSubkingdom() ?></dd>
				<dt>Phylum</dt>
				<dd><?php echo $strain->getFormattedPhylum() ?></dd>
				<dt>Clase</dt>
				<dd><?php echo $strain->getTaxonomicClass() ?></dd>
				<dt>Orden</dt>
				<dd><?php echo $strain->getFormattedTaxonomicOrder() ?></dd>
				<dt>Familia</dt>
				<dd><?php echo $strain->getFormattedFamily() ?></dd>
			</dl>
		</div>

		<div class="article_content_section">
			<h3>Condiciones ambientales</h3>
			<dl>
				<dt>Latitud</dt>
				<dd><?php echo $strain->getSample()->getLatitude() ?></dd>
				<dt>Longitud</dt>
				<dd><?php echo $strain->getSample()->getLongitude() ?></dd>
				<dt>Hábitat</dt>
				<dd>
					<?php echo $strain->getSample()->getHabitat() ?><?php if ($strain->getSample()->getLocationDetails()) echo ', '. lcfirst($strain->getSample()->getLocationDetails()) ?>
				</dd>
				<dt>Localidad</dt>
				<dd><?php echo $strain->getSample()->getLocation() ?>, <?php echo $strain->getSample()->getLocation()->getRegion() ?></dd>
				<dt>País</dt>
				<dd><?php echo $strain->getSample()->getLocation()->getCountry() ?></dd>
				<dt>Distribución mundial</dt>
				<dd><?php echo $strain->getDistribution() ?></dd>
			</dl>
		</div>

		<div class="article_content_section">
			<h3>Condiciones de cultivo</h3>
			<dl>
				<dt>Medio de cultivo</dt>
				<dd>
					<?php echo $form['culture_media_list']->renderLabel() ?>
					<?php echo $form['culture_media_list']->renderError() ?>
					<?php echo $form['culture_media_list']->renderHelp() ?>
					<?php echo $form['culture_media_list'] ?>
				</dd>
				<dt>Irradiación</dt>
				<dd><?php echo $strain->getIrradiation() ?></dd>
				<dt>Temperatura</dt>
				<dd><?php echo $strain->getTemperature() ?>&nbsp;<?php echo sfConfig::get('app_temperature_unit') ?></dd>
				<dt>Fotoperiodo</dt>
				<dd><?php echo $strain->getPhotoperiod() ?></dd>
			</dl>
		</div>

		<div class="article_content_section">
		</div>
		<div class="clear"></div>
	</div>

	<div id="right_side_form">
		<div class="strain_picture">

		</div>

		<div class="article_content_section">
			<h3>Descripción</h3>
			<p><?php echo $strain->getArticleDescription() ?></p>
		</div>

		<div class="article_content_section">
			<h3>Geolocalización</h3>
		</div>

		<div class="article_content_section">
			<h3>Taxonomía molecular</h3>
			<dl>
				<dt>ADN genómico</dt>
				<dd><?php echo $strain->getPublicDnaAmount() ? 'disponible en el banco de ADN' : 'no disponible' ?></dd>
				<dt>Genes secuenciados</dt>
				<dd><?php echo implode(', ', $strain->getSequencedGenes()->getRawValue()) ?></dd>
			</dl>
		</div>

		<div class="article_content_section">
			<h3>Árbol filogenético</h3>
		</div>

	</div>

	<div class="submit"><input type="submit" value="Download article" /></div>
</form>