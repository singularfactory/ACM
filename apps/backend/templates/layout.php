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
		
		<div id="header">
			<?php echo image_tag('logo.png', array('id' => 'header_image', 'alt' => 'Banco Español de Algas')) ?>
			<h1 id="header_title">Algae culture management</h1>
			<h2 id="header_subtitle">Banco Español de Algas</h2>
				
			<div id="header_shortcuts">
				<span>inventiaplus</span> |
				<span><?php echo link_to('About me', array()) ?></span> |
				<span><?php echo link_to('Sign out', '@logout') ?></span>
			</div>
				
			<div id="header_menu">
				<ul id="header_menu_tabs">
					<?php $route = sfContext::getInstance()->getRouting()->getCurrentRouteName() ?>

					<li>
						<?php echo link_to('Radiations', '@radiation', (preg_match('/^(radiation_?|homepage)/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					<li>
						<?php echo link_to('Habitats', '@habitat', (preg_match('/^habitat_?/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					<li>
						<?php echo link_to('Environments', '@environment', (preg_match('/^environment_?/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					<li>
						<?php echo link_to('Collectors', '@collector', (preg_match('/^collector_?/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					<li>
						<?php echo link_to('Countries', '@country', (preg_match('/^country_?/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					<li>
						<?php echo link_to('Regions', '@region', (preg_match('/^region_?/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					<li>
						<?php echo link_to('Islands', '@island', (preg_match('/^island_?/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					<li>
						<?php echo link_to('People', '@sf_guard_user', (preg_match('/^sf_guard_user_?/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					<li>
						<?php echo link_to('Roles', '@sf_guard_group', (preg_match('/^sf_guard_group_?/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					<li>
						<?php echo link_to('Permissions', '@sf_guard_permission', (preg_match('/^sf_guard_permission_?/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					
					<li class="header_menu_right_tab">
						<?php echo link_to('Back to application', '/') ?>
					</li>					
				</ul>
			</div>
		</div>

		<div id="main">
			<?php echo $sf_content ?>	
		</div>

		<div id="footer"></div>
	</body>
</html>