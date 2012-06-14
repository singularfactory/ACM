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
					<?php if ( $user->exists() && ($filename = $user->getAvatar()) ): ?>
						<?php $filename = sfConfig::get('app_pictures_dir').sfConfig::get('app_avatar_dir')."/$filename"; ?>
					<?php else: ?>
						<?php $filename = sfConfig::get('app_default_avatar') ?>
					<?php endif ?>
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
					<?php if ( $currentRoute === 'module_full_index' )
						$currentRoute = sfContext::getInstance()->getModuleName();
					?>

					<li class="header_menu_item">
						<?php
						if ( !preg_match('/^location(\/_)?/', $currentRoute) )
							echo link_to('Locations', '@location');
						else
							echo link_to('Locations', '@location', array('class' => 'header_menu_current_tab'));
						?>
					</li>

					<li class="header_menu_item">
						<?php
						if ( !preg_match('/^(sample(\/_)?)/', $currentRoute) )
							echo link_to('Samples', '@sample');
						else
							echo link_to('Samples', '@sample', array('class' => 'header_menu_current_tab'));
						?>
					</li>

					<li class="header_menu_item">
						<?php
						if ( !preg_match('/^(strain(\/_)?|homepage)/', $currentRoute) )
							echo link_to('Strains', '@strain');
						else
							echo link_to('Strains', '@strain', array('class' => 'header_menu_current_tab'));
						?>
					</li>

					<li class="header_menu_item">
						<?php
						if ( !preg_match('/^(culture_medium(\/_)?)/', $currentRoute) )
							echo link_to('Culture media', '@culture_medium');
						else
							echo link_to('Culture media', '@culture_medium', array('class' => 'header_menu_current_tab'));
						?>
					</li>

					<li class="header_menu_item">
						<?php
						if ( !preg_match('/^((dna_extraction|pcr|dna)(\/_)?)/', $currentRoute) )
							echo link_to('DNA Lab', '@dna_extraction');
						else
							echo link_to('DNA Lab', '@dna_extraction', array('class' => 'header_menu_current_tab'));
						?>
					</li>

					<li class="header_menu_item">
						<?php
						if ( !preg_match('/^((external_strain)(\/_)?)/', $currentRoute) )
							echo link_to('Research collection', '@external_strain');
						else
							echo link_to('Research collection', '@external_strain', array('class' => 'header_menu_current_tab'));
						?>
					</li>

					<li class="header_menu_item">
						<?php
						if ( !preg_match('/^((project|maintenance_deposit|patent_deposit|identification|cryopreservation|isolation)(\/_)?)/', $currentRoute) )
							echo link_to('Services', '@project');
						else
							echo link_to('Services', '@project', array('class' => 'header_menu_current_tab'));
						?>
						<ul id="header_menu_services">
							<li><?php echo link_to('Projects', '@project') ?></li>
							<li><?php echo link_to('Patent deposits', '@patent_deposit') ?></li>
							<li><?php echo link_to('Maintenance deposits', '@maintenance_deposit') ?></li>
							<li><?php echo link_to('Isolations', '@isolation') ?></li>
							<li><?php echo link_to('Cryopreservations', '@cryopreservation') ?></li>
							<li><?php echo link_to('Identifications', '@identification') ?></li>
						</ul>
					</li>

					<li class="header_menu_item header_menu_right_tab header_menu_tools">
						<?php echo link_to('Settings', '/admin') ?>
					</li>

					<li class="header_menu_item header_menu_right_tab header_menu_tools">
						<?php
						if ( !preg_match('/^((glossary)(\/_)?)/', $currentRoute) )
							echo link_to('Glossary', '@glossary');
						else
							echo link_to('Glossary', '@glossary', array('class' => 'header_menu_current_tab'));
						?>
					</li>

					<li class="header_menu_item header_menu_right_tab header_menu_tools">
						<?php
						if ( !preg_match('/^((report)(\/_)?)/', $currentRoute) )
							echo link_to('Reports', '@report');
						else
							echo link_to('Reports', '@report', array('class' => 'header_menu_current_tab'));
						?>
					</li>

					<li class="header_menu_item header_menu_right_tab header_menu_tools">
						<?php
						$unreadMessages = $user->getNbUnreadNotifications();
						if ( $unreadMessages ) {
							$unreadMessages = " ($unreadMessages)";
						}
						else {
							$unreadMessages = '';
						}
						if ( !preg_match('/^((inbox|notification)(\/_)?)/', $currentRoute) )
							echo link_to("Inbox$unreadMessages", '@inbox');
						else
							echo link_to("Inbox$unreadMessages", '@inbox', array('class' => 'header_menu_current_tab'));
						?>
					</li>

					<li class="header_menu_item header_menu_right_tab header_menu_tools">
						<?php
						$itemsCountCssClass = array();
						$newOrders = $user->getNbPendingPurchaseOrders();
						if ( $newOrders ) {
							$newOrders = " ($newOrders)";
							$itemsCountCssClass = array('class' => 'header_menu_tab_count');
						}
						else {
							$newOrders = '';
						}
						if ( !preg_match('/^((purchase_order|purchase_item)(\/_)?)/', $currentRoute) )
							echo link_to("Sales$newOrders", '@purchase_order', $itemsCountCssClass);
						else
							echo link_to("Sales$newOrders", '@purchase_order', array('class' => 'header_menu_current_tab'));
						?>
					</li>

					<li class="header_menu_item header_menu_right_tab header_menu_tools">
						<?php
						if ( !preg_match('/^((article)(\/_)?)/', $currentRoute) )
							echo link_to('Articles', '@article_new');
						else
							echo link_to('Articles', '@article_new', array('class' => 'header_menu_current_tab'));
						?>
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
