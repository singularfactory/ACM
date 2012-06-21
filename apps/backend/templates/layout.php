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
 * @package       ACM.Backend
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
					<li class="header_menu_item">
						<?php echo link_to('Locations', '@country', (preg_match('/^(country|region|island|location_category)_?/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					<li class="header_menu_item">
						<?php echo link_to('Sampling', '@radiation', (preg_match('/^(radiation|habitat|environment|purification_method)_?|homepage/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					<li class="header_menu_item">
						<?php echo link_to('Strains maintenance', '@maintenance_status', (preg_match('/^(maintenance_status|cryopreservation_method|container)_?/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					<li class="header_menu_item">
						<?php echo link_to(
							'Taxonomy',
							'@taxonomic_class',
							(preg_match('/^(kingdom|subkingdom|phylum|taxonomic_order|family|taxonomic_class|genus|species|authority)_?/', $route))?array('class' => 'header_menu_current_tab'):'')
						?>
					</li>
					<li class="header_menu_item">
						<?php echo link_to('DNA Lab', '@extraction_kit', (preg_match('/^(extraction_kit|dna_polymerase|dna_primer|pcr_program)_?/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					<li class="header_menu_item">
						<?php echo link_to('Projects', '@project_name', (preg_match('/^(project_name)_?/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					<li class="header_menu_item">
						<?php echo link_to('Glossary', '@glossary_term', (preg_match('/^(glossary_term)_?/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					<li class="header_menu_item">
						<?php echo link_to('Potential usages', '@usage_area', (preg_match('/^(usage_area|usage_target)_?/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					<li class="header_menu_item">
						<?php echo link_to('People', '@sf_guard_user', (preg_match('/^(sf_guard_user|collector|isolator|depositor|identifier)_?/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					<li class="header_menu_item">
						<?php echo link_to('Roles', '@sf_guard_group', (preg_match('/^sf_guard_group_?/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>
					<li class="header_menu_item">
						<?php echo link_to('Permissions', '@sf_guard_permission', (preg_match('/^sf_guard_permission_?/', $route))?array('class' => 'header_menu_current_tab'):'') ?>
					</li>

					<li class="header_menu_item header_menu_right_tab header_menu_tools">
						<?php echo link_to('Back to application', '/') ?>
					</li>
				</ul>
			</div>
		</div>

		<div id="main">
			<?php if ( preg_match('/^(radiation|habitat|environment|purification_method)_?|homepage/', $route) ): ?>
			<div id="subsections_header">
				<?php include_partial('global/sampling_sections', array('route' => $route)) ?>
			</div>
			<?php endif; ?>

			<?php if ( preg_match('/^(country|region|island|location_category)_?/', $route) ): ?>
			<div id="subsections_header">
				<?php include_partial('global/location_sections', array('route' => $route)) ?>
			</div>
			<?php endif; ?>

			<?php if ( preg_match('/^(maintenance_status|cryopreservation_method|container)_?/', $route) ): ?>
			<div id="subsections_header">
				<?php include_partial('global/maintenance_sections', array('route' => $route)) ?>
			</div>
			<?php endif; ?>

			<?php if ( preg_match('/^(kingdom|subkingdom|phylum|taxonomic_order|family|taxonomic_class|genus|species|authority)_?/', $route) ): ?>
			<div id="subsections_header">
				<?php include_partial('global/taxonomy_sections', array('route' => $route)) ?>
			</div>
			<?php endif; ?>

			<?php if ( preg_match('/^(project_name)_?/', $route) && false ): ?>
			<div id="subsections_header">
				<?php include_partial('global/project_sections', array('route' => $route)) ?>
			</div>
			<?php endif; ?>

			<?php if ( preg_match('/^(glossary_term)_?/', $route) && false ): ?>
			<div id="subsections_header">
				<?php include_partial('global/glossary_term_sections', array('route' => $route)) ?>
			</div>
			<?php endif; ?>

			<?php if ( preg_match('/^(extraction_kit|dna_polymerase|dna_primer|pcr_program)_?/', $route) ): ?>
			<div id="subsections_header">
				<?php include_partial('global/dna_lab_sections', array('route' => $route)) ?>
			</div>
			<?php endif; ?>

			<?php if ( preg_match('/^(sf_guard_user|collector|isolator|depositor|identifier|petitioner)_?/', $route) ): ?>
			<div id="subsections_header">
				<?php include_partial('global/people_sections', array('route' => $route)) ?>
			</div>
			<?php endif; ?>

			<?php if ( preg_match('/^(usage_area|usage_target)_?/', $route) ): ?>
			<div id="subsections_header">
				<?php include_partial('global/strain_usage_sections', array('route' => $route)) ?>
			</div>
			<?php endif; ?>

			<?php echo $sf_content ?>
		</div>

		<div id="footer"></div>
	</body>
</html>
