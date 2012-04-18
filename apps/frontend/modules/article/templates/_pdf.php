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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="title" content="Algae culture management | Banco Español de Algas" />
	<meta name="description" content="Algae culture management of Banco Español de Algas" />
	<meta name="keywords" content="bea, banco, español, algas, marine, biotechnology, spanish, banl, algae" />
	<meta name="language" content="en" />
	<meta name="robots" content="index, follow" />
	<title>Algae culture management | Banco Español de Algas</title>
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" type="text/css" media="screen" href="/css/main.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="/css/articles.css" />
</head>
<body>
	<div id="container">
		<div id="sidebar">
			<div id="logo" class="sidebar-section"><?php echo image_tag('logo_text.png', array('alt' => 'Banco Español de Algas')) ?></div>
			<div id="taxonomy" class="sidebar-section">
				<ul>
					<li><strong>Reino:</strong>&nbsp;<?php echo $strain->getKingdom() ?></li>
					<li><strong>Subreino:</strong>&nbsp;<?php echo $strain->getSubkingdom() ?></li>
					<li><strong>Phylum:</strong>&nbsp;<?php echo $strain->getPhylum() ?></li>
					<li><strong>Clase:</strong>&nbsp;<?php echo $strain->getTaxonomicClass() ?></li>
					<li><strong>Orden:</strong>&nbsp;<?php echo $strain->getTaxonomicOrder() ?></li>
				</ul>
			</div>
			<div id="environmental-conditions" class="sidebar-section">
				<ul>
					<li><strong>Medio de cultivo:</strong>&nbsp;<?php echo $strain->getKingdom() ?></li>
					<li><strong>Irradiación:</strong>&nbsp;<?php echo $strain->getIrradiation() ?>&nbsp;&micro;moles fotones s<sup>-1</sup>&nbsp;m<sup>-2</sup></li>
					<li><strong>Temperatura:</strong>&nbsp;<?php echo $strain->getTemperature() ?>&nbsp;<?php echo sfConfig::get('app_temperature_unit') ?></li>
					<li><strong>Fotoperiodo:</strong>&nbsp;<?php echo $strain->getPhotoperiod() ?>&nbsp;(L:O)</li>
				</ul>
			</div>
			<?php $sample = $strain->getSample() ?>
			<?php $location = $sample->getLocation() ?>
			<div id="culture-conditions" class="sidebar-section">
				<ul>
					<li><strong>Latitud:</strong>&nbsp;<?php echo $sample->getLatitude() ?></li>
					<li><strong>Longitud:</strong>&nbsp;<?php echo $sample->getLongitude() ?></li>
					<li><strong>Hábitat:</strong>&nbsp;<?php echo $strain->getHabitatDescription() ?></li>
					<li><strong>Localidad:</strong>&nbsp;<?php echo $sample->getLocation() ?></li>
					<li><strong>País:</strong>&nbsp;<?php echo $location->getCountry() ?></li>
					<li><strong>Distribución mundial:</strong>&nbsp;<?php echo $strain->getDistribution() ?></li>
				</ul>
			</div>
			<div id="location-picture" class="sidebar-section">
				<?php echo image_tag($locationPicture, array('alt' => 'Location picture')) ?>
			</div>
		</div>

		<div id="body">
			<div id="title" class="body-section">
				<span class="species_name"><?php echo $strain->getGenus() ?>&nbsp;<?php echo $strain->getSpecies() ?></span>&nbsp;<?php echo $strain->getAuthority() ?>
				<span class="bea_code"><?php echo $strain->getFullCode() ?></span>
			</div>
			<div id="strain-picture" class="body-section">
				<?php echo image_tag($strainPicture, array('alt' => 'Strain picture')) ?>
			</div>
			<div id="content" class="body-section">

				<div id="content-left-column">
					<div id="description" class="content-section">
						<h3>Descripción</h3>
						<p><?php echo $strain->getArticleDescription() ?></p>
					</div>
					<div id="location-map" class="content-section">
						<?php echo image_tag($googleMapUrl, array('alt' => 'Location map')) ?>
					</div>
				</div>
				<div id="content-right-column">
					<div id="molecular-taxonomy" class="content-section">
						<ul>
							<li><strong>Taxonomía molecular:</strong></li>
							<li><strong>ADN genómico:</strong>&nbsp;<?php echo $strain->getPublicDnaAmount() ? 'disponible en el banco de ADN' : 'no disponible' ?></li>
							<li><strong>Genes secuenciados:</strong>&nbsp;<?php echo implode(', ', $strain->getSequencedGenes()->getRawValue()) ?></li>
							<li><strong>Árbol filogenético:</strong></li>
						</ul>
					</div>
					<div id="phylogenetic-tree" class="content-section">
						<?php echo image_tag($strain->getPhylogeneticTreePath(), array('alt' => 'Phylogenetic tree picture')) ?>
					</div>
					<div id="phylogenetic-description" class="content-section">
						<p><?php echo $strain->getPhylogeneticDescription() ?></p>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</body>
</html>