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
<?php use_helper('BarCode'); ?>
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
		<link rel="stylesheet" type="text/css" media="screen" href="/css/labels.css" />
	</head>
	<body>
		<table>
			<tbody>
				<?php $columns = 0 ?>
				<?php $barcode = getBarCode($label->getId()) ?>
				<?php $code = $label->getStrain()->getFullCode() ?>
				<?php $date = $label->getExtractionDate() ?>
				<?php $concentration = $label->getFormattedConcentration() ?>
				<?php $ratio280 = $label->getFormatted260280Ratio() ?>
				<?php $ratio230 = $label->getFormatted260230Ratio() ?>
				<?php for ($i = 0; $i < $copies; $i++): ?>
					<?php if ( $columns == 0 ): ?>
						<tr class="label_items">
					<?php endif ?>

					<td class="label_item">
						<?php echo $barcode ?>
						<p class="label_item_code"><?php echo $date ?></p>
						<p class="label_item_code"><?php echo $code ?></p>
						<p class="label_item_class"><?php echo $concentration ?></p>
						<p class="label_item_class">
							<strong>260:280</strong>=<?php echo $ratio280 ?>&nbsp; / &nbsp;<strong>260:230</strong>=<?php echo $ratio230 ?>
						</p>
					</td>
						
					<?php $columns++ ?>
					<?php if ( $columns == 4): ?>
						</tr>
						<?php $columns = 0 ?>
					<?php endif ?>
				<?php endfor ?>
			</tbody>
		</table>
	</body>
</html>
