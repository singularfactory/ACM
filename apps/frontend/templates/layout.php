<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php include_http_metas() ?>
		<?php include_metas() ?>
		<?php include_title() ?>
		<link rel="shortcut icon" href="/favicon.ico" />
		<?php include_stylesheets() ?>
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
				<?php $user = $sf_user->getGuardUser() ?>
				<div id="header_avatar">
					<?php
						$filename = $user->getAvatar();
						if ( empty($filename) ) {
							$filename = sfConfig::get('app_default_avatar');
						}
						else {
							$filename = sfConfig::get('app_pictures_dir').sfConfig::get('app_avatar_dir')."/$filename";
						}
					?>
					<?php echo image_tag($filename, array('id' => 'header_avatar', 'alt' => $user->getUsername())) ?>
				</div>
				
				<div id="header_user_information">
					<p id="header_username"><?php echo $user->getUsername(); ?></p>
					<p><?php echo link_to('About me', '@profile_shortcut?id='.$user->getId()) ?></p>
					<p><?php echo link_to('Sign out', '@logout') ?></p>
				</div>
			</div>
				
			<div id="header_menu">
				<ul id="header_menu_tabs">
					<?php $currentRoute = sfContext::getInstance()->getRouting()->getCurrentRouteName() ?>
					
					<li>
						<?php
						if ( !preg_match('/^location(\/_)?/', $currentRoute) )
							echo link_to('Locations', '@location');
						else
							echo link_to('Locations', '@location', array('class' => 'header_menu_current_tab'));
						?>
					</li>
					
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
						if ( !preg_match('/^(strain(\/_)?)/', $currentRoute) )
							echo link_to('Strains', '@strain');
						else
							echo link_to('Strains', '@strain', array('class' => 'header_menu_current_tab'));
						?>
					</li>
					
					<li>
						<?php
						if ( !preg_match('/^(growth_medium(\/_)?)/', $currentRoute) )
							echo link_to('Growth mediums', '@growth_medium');
						else
							echo link_to('Growth mediums', '@growth_medium', array('class' => 'header_menu_current_tab'));
						?>
					</li>
					
					<li>
						<?php
						if ( !preg_match('/^((dna_extraction|pcr)(\/_)?)/', $currentRoute) )
							echo link_to('DNA Lab', '@dna_extraction');
						else
							echo link_to('DNA Lab', '@dna_extraction', array('class' => 'header_menu_current_tab'));
						?>
					</li>
								
					<li class="header_menu_right_tab">
						<?php echo link_to('Settings', '/admin') ?>
					</li>					
				</ul>
			</div>
		</div>

		<div id="main">
			<div id="main_content">
				<div id="main_header">
					<?php if ( has_slot('main_header') ) include_slot('main_header') ?>
				</div>
				<div id="main_view">
					<?php echo $sf_content ?>
				</div>
			</div>
			<div id="main_actions"></div>
		</div>

		<div id="footer"></div>
		
		<?php if ( $sf_user->hasFlash('notice') || $sf_user->hasFlash('error') ): ?>
		<div id="flash">
			<div id="flash_box">
				<div class="flash_close"></div>
				<div class="flash_inner">
					<?php if ($sf_user->hasFlash('notice')): ?>
					<?php echo $sf_user->getFlash('notice') ?>
					<?php endif ?>

					<?php if ($sf_user->hasFlash('error')): ?>
					<?php echo $sf_user->getFlash('error') ?>
					<?php endif ?>
				</div>
			</div>
		</div>
		<?php endif ?>
		
		<?php include_javascripts() ?>
	</body>
</html>