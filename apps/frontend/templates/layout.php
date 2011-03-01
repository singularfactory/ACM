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
				<span><?php echo link_to('Sign out', '@logout') ?></span>
			</div>
				
			<div id="header_menu">
				<ul id="header_menu_tabs">
					<?php $currentRoute = sfContext::getInstance()->getRouting()->getCurrentRouteName() ?>
					
					<li>
						<?php
						if ( !preg_match('/^(sample(\/_)?|homepage)/', $currentRoute) )
							echo link_to('Samples', '@sample');
						else
							echo link_to('Samples', '@sample', array('class' => 'header_menu_current_tab'));
						?>
					</li>
					
					<li>
						<?php
						if ( !preg_match('/^ecosystem(\/_)?/', $currentRoute) )
							echo link_to('Ecosystems', '@ecosystem');
						else
							echo link_to('Ecosystems', '@ecosystem', array('class' => 'header_menu_current_tab'));
						?>
					</li>
					
					<li class="header_menu_right_tab">
						<?php
						if ( !preg_match('/^search(\/_)?/', $currentRoute) )
							echo link_to('Search', '@homepage');
						else
							echo link_to('Search', '@homepage', array('class' => 'header_menu_current_tab'));
						?>
					</li>
					
					<li class="header_menu_right_tab">
						<?php
						if ( !preg_match('/^people(\/_)?/', $currentRoute) )
							echo link_to('People', '@homepage');
						else
							echo link_to('People', '@homepage', array('class' => 'header_menu_current_tab'));
						?>
					</li>
					
					<li class="header_menu_right_tab">
						<?php
						if ( !preg_match('/^settings\/?/', $currentRoute) )
							echo link_to('Settings', '@settings');
						else
							echo link_to('Settings', '@settings', array('class' => 'header_menu_current_tab'));
						?>
					</li>					
				</ul>
			</div>
		</div>

		<div id="content">
			<?php if( preg_match('/^settings\/?/', $currentRoute) ): ?>
			<div id="settings_menu">
				<?php echo link_to('Countries and regions', '/settings/country') ?> |
				<?php echo link_to('Provinces and islands', '/settings/province') ?> |
				<?php echo link_to('Habitats', '/settings/habitat') ?> |
				<?php echo link_to('Environments', '/settings/environment') ?>
			</div>
			<?php endif; ?>
			
			<div id="content_title">
				<?php if ( has_slot('content_title') ) include_slot('content_title') ?>
			</div>
			<?php echo $sf_content ?>	
		</div>

		<div id="footer"></div>
	</body>
</html>