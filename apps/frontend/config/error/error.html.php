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
		<meta name="keywords" content="algae, bna, bea, banco, nacional, algas, español, marine, biotechnology, strains, culture" />
		<meta name="language" content="en" />
		<meta name="robots" content="index, follow" />
		<title>Algae culture management | Banco Español de Algas</title>
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="stylesheet" type="text/css" media="screen" href="/css/main.css" />
		<script type="text/javascript" src="/js/jquery.js"></script>
		<script type="text/javascript" src="/js/main.js"></script>
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

		<div id="header">
			<img id="header_image" alt="Banco Español de Algas" src="/images/logo.png" />
			<h1 id="header_title">Algae culture management</h1>
			<h2 id="header_subtitle">Banco Español de Algas</h2>
			<div id="header_shortcuts"></div>
			<div id="header_menu"></div>
		</div>

		<div id="main">
			<div id="main_content">
				<div id="main_header" style="display: none"></div>
				<div id="main_view">
					<div class="http_error">
						<div id="http_error_text">
							<h2>Oops! An error occurred</h2>
							<p>Don't freak out. Everything is going to be OK</p>
							<p class="navigation">Try to <a href="#" id="go_back_link">go back</a>.</p>
						</div>
						<div id="http_error_image">
							<img alt="Error 505" src="/images/http_error.png" width="290" height="308" />
						</div>
					</div>
				</div>
			</div>
			<div id="main_actions"></div>
		</div>

		<div id="footer"></div>
	</body>
</html>