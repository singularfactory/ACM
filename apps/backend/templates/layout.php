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
					<p><?php echo link_to('About me', "/profile/{$user->getId()}") ?></p>
					<p><?php echo link_to('Sign out', '@logout') ?></p>
				</div>
			</div>
				
			<div id="header_menu">
				<ul id="header_menu_tabs">
					<?php $route = sfContext::getInstance()->getRouting()->getCurrentRouteName() ?>

					<li>
						<?php echo link_to('Sampling', '@radiation', (preg_match('/^((radiation|habitat|environment)_?|homepage)/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					<li>
						<?php echo link_to('Locations', '@country', (preg_match('/^(country|region|island)_?/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					<li>
						<?php echo link_to('Cryopreservation', '@cryopreservation_method', (preg_match('/^(cryopreservation_method)_?/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					<li>
						<?php echo link_to('Taxonomy', '@taxonomic_class', (preg_match('/^(taxonomic_class|genus|species|authority)_?/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					<li>
						<?php echo link_to('DNA Lab', '@extraction_kit', (preg_match('/^(extraction_kit|dna_polymerase|dna_primer)_?/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					<li>
						<?php echo link_to('People', '@sf_guard_user', (preg_match('/^(sf_guard_user|collector|isolator|depositor|identifier)_?/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
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
			<?php if ( preg_match('/^(radiation|habitat|environment)_?/', $route) ): ?>
			<div id="subsections_header">
				<?php include_partial('global/sampling_sections', array('route' => $route)) ?>
			</div>
			<?php endif; ?>
			
			<?php if ( preg_match('/^(country|region|island)_?/', $route) ): ?>
			<div id="subsections_header">
				<?php include_partial('global/location_sections', array('route' => $route)) ?>
			</div>
			<?php endif; ?>
			
			<?php if ( preg_match('/^(taxonomic_class|genus|species|authority)_?/', $route) ): ?>
			<div id="subsections_header">
				<?php include_partial('global/taxonomy_sections', array('route' => $route)) ?>
			</div>
			<?php endif; ?>
			
			<?php if ( preg_match('/^(extraction_kit|dna_polymerase|dna_primer)_?/', $route) ): ?>
			<div id="subsections_header">
				<?php include_partial('global/dna_lab_sections', array('route' => $route)) ?>
			</div>
			<?php endif; ?>

			<?php if ( preg_match('/^(sf_guard_user|collector|isolator|depositor|identifier)_?/', $route) ): ?>
			<div id="subsections_header">
				<?php include_partial('global/people_sections', array('route' => $route)) ?>
			</div>
			<?php endif; ?>
			
			<?php echo $sf_content ?>	
		</div>

		<div id="footer"></div>
	</body>
</html>