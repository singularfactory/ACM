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
		<?php foreach ($strains as $strain):?>
			<table width="100%">
			<tr>
				<th width="25%" style="text-align:right;">BEA Number</th>
				<td style="text-align:left;"><?php echo $strain->getFullCode();?></td>
			</tr>
			<tr>
				<th width="25%" style="text-align:right;">Genus</th>
				<td style="text-align:left;"><?php echo $strain->getGenus();?></td>
			</tr>
			<tr>
				<th width="25%" style="text-align:right;">Species</th>
				<td style="text-align:left;"><?php echo $strain->getSpecies();?></td>
			</tr>
			<tr>
				<th width="25%" style="text-align:right;">Class</th>
				<td style="text-align:left;"><?php echo $strain->getTaxonomicClass();?></td>
			</tr>
			<tr>
				<th width="25%" style="text-align:right;">Public</th>
				<td style="text-align:left;"><?php echo $strain->getIsPublic();?></td>
			</tr>
			<tr>
				<th width="25%" style="text-align:right;">Internal Code</th>
				<td style="text-align:left;"><?php echo $strain->getInternalCode();?></td>
			</tr>
			<tr>
				<th width="25%" style="text-align:right;">Remarks</th>
				<td style="text-align:left;"><?php echo $strain->getRemarks();?></td>
			</tr>
			</table>
			<hr/>
		<?php endforeach; ?>
	</body>
</html>
