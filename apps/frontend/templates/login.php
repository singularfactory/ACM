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
		<?php include_http_metas() ?>
		<?php include_metas() ?>
		<?php include_title() ?>
		<link rel="shortcut icon" href="/favicon.ico" />
		<?php include_stylesheets() ?>
		<?php include_javascripts() ?>
	</head>
	<body>
		<noscript>
			<div class="javascript_disabled_notification">
				<div class="inner">
					<h1>You need to change a setting in your web browser</h1>
					<p>This application requires a browser feature called <strong>JavaScript</strong>. All modern browsers support JavaScript. You probably just need to change a setting in order to turn it on.</p>
					<p>Please see: <a href="http://www.google.com/support/bin/answer.py?answer=23852">How to enable JavaScript in your browser</a>.</p>
					<p>If you use ad-blocking software, it may require you to allow JavaScript from basecamphq.com.</p>
					<p>Once you've enabled JavaScript you can <a href="">try loading this page again</a>.</p>
					<p>Thank you.</p>
				</div>
			</div>
		</noscript>

		<div id="container">
			<div id="error_message">
				<?php include_slot('error_message') ?> &nbsp;
			</div>
			<div id="logo">
				<?php echo link_to(
					image_tag('logo_text.png', array('alt' => 'Banco Español de Algas')),
					'http://bea.marinebiotechnology.org/')
				?>
			</div>
			<div id="signin_form">
				<?php echo $sf_content ?>
			</div>
		</div>
	</body>
</html>