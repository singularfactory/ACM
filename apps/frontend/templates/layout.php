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
		<div id="main">
			<div id="header">
				<div id="header_title_group">
					<h1 id="header_title">Banco Español de Algas</h1>
					<h2 id="header_subtitle">Green House</h2>
				</div>
				
				<div id="header_shortcuts">
					<span>Eliezer Talón</span> |
					<span><a href="#">About me</a></span> |
					<span><a href="#">Sign out</a></span>
				</div>
				
				<div id="header_menu">
					<ul id="header_menu_tabs">
						<li><a href="<?php echo url_for('sample') ?>" class="header_menu_current_tab">Samples</a></li>
						<li><a href="<?php echo url_for('ecosystem') ?>">Ecosystems</a></li>
						<li class="header_menu_right_tab"><a id="header_menu_last_tab" href="<?php echo url_for('search') ?>">Search</a></li>
						<li class="header_menu_right_tab"><a href="<?php echo url_for('user') ?>">People</a></li>
						<li class="header_menu_right_tab"><a href="<?php echo url_for('settings') ?>">Settings</a></li>
					</ul>
				</div>
			</div>

			<div id="content">
				<?php echo $sf_content ?>	
			</div>

			<div id="footer">
				
			</div>
		</div>
	</body>
</html>