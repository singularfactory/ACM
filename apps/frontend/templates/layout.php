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
			<h1 id="header_title">Banco Español de Algas</h1>
				
			<div id="header_shortcuts">
				<span>inventiaplus</span> |
				<span><a href="#">About me</a></span> |
				<span><a href="#">Sign out</a></span>
			</div>
				
			<div id="header_menu">
				<ul id="header_menu_tabs">
					<?php $currentRoute = sfContext::getInstance()->getRouting()->getCurrentRouteName(); ?>
					<li><a href="<?php echo url_for('sample') ?>" <?php if ( preg_match('/^sample\/?/', $currentRoute) ) echo 'class="header_menu_current_tab"'?>>Samples</a></li>
					<li><a href="<?php echo url_for('ecosystem') ?>" <?php if ( preg_match('/^ecosystem\/?/', $currentRoute) ) echo 'class="header_menu_current_tab"'?>>Ecosystems</a></li>
					<li class="header_menu_right_tab"><a id="header_menu_last_tab" href="<?php echo url_for('search') ?>" <?php if ( preg_match('/^search\/?/', $currentRoute) ) echo 'class="header_menu_current_tab"'?>>Search</a></li>
					<li class="header_menu_right_tab"><a href="<?php echo url_for('user') ?>" <?php if ( preg_match('/^people\/?/', $currentRoute) ) echo 'class="header_menu_current_tab"'?>>People</a></li>
					<li class="header_menu_right_tab"><a href="<?php echo url_for('settings') ?>" <?php if ( preg_match('/^settings\/?/', $currentRoute) ) echo 'class="header_menu_current_tab"'?>>Settings</a></li>
				</ul>
			</div>
		</div>

		<div id="content">
			<div id="content_title">
					<?php if ( has_slot('content_title') ) include_slot('content_title') ?>
				</div>
			<?php echo $sf_content ?>	
		</div>

		<div id="footer"></div>
	</body>
</html>