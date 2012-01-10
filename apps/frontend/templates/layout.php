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
						if ( !preg_match('/^(sample(\/_)?)/', $currentRoute) )
							echo link_to('Samples', '@sample');
						else
							echo link_to('Samples', '@sample', array('class' => 'header_menu_current_tab'));
						?>
					</li>
					
					<li>
						<?php
						if ( !preg_match('/^(strain(\/_)?|homepage)/', $currentRoute) )
							echo link_to('Strains', '@strain');
						else
							echo link_to('Strains', '@strain', array('class' => 'header_menu_current_tab'));
						?>
					</li>
					
					<li>
						<?php
						if ( !preg_match('/^(culture_medium(\/_)?)/', $currentRoute) )
							echo link_to('Culture media', '@culture_medium');
						else
							echo link_to('Culture media', '@culture_medium', array('class' => 'header_menu_current_tab'));
						?>
					</li>
					
					<li>
						<?php
						if ( !preg_match('/^((dna_extraction|pcr|dna)(\/_)?)/', $currentRoute) )
							echo link_to('DNA Lab', '@dna_extraction');
						else
							echo link_to('DNA Lab', '@dna_extraction', array('class' => 'header_menu_current_tab'));
						?>
					</li>
					
					<li id="header_menu_separator_tab">
						<?php
						if ( !preg_match('/^((project)(\/_)?)/', $currentRoute) )
							echo link_to('Projects', '@project');
						else
							echo link_to('Projects', '@project', array('class' => 'header_menu_current_tab'));
						?>
					</li>
					
					<li>
						<?php
						if ( !preg_match('/^((patent_deposit)(\/_)?)/', $currentRoute) )
							echo link_to('Patent deposits', '@patent_deposit');
						else
							echo link_to('Patent deposits', '@patent_deposit', array('class' => 'header_menu_current_tab'));
						?>
					</li>
					
					<li>
						<?php
						if ( !preg_match('/^((maintenance_deposit)(\/_)?)/', $currentRoute) )
							echo link_to('Maintenance deposits', '@maintenance_deposit');
						else
							echo link_to('Maintenance deposits', '@maintenance_deposit', array('class' => 'header_menu_current_tab'));
						?>
					</li>
					
					<li>
						<?php
						if ( !preg_match('/^((isolation)(\/_)?)/', $currentRoute) )
							echo link_to('Isolations', '@isolation');
						else
							echo link_to('Isolations', '@isolation', array('class' => 'header_menu_current_tab'));
						?>
					</li>
					
					<li class="header_menu_right_tab">
						<?php echo link_to('Settings', '/admin') ?>
					</li>
					
					<li class="header_menu_right_tab">
						<?php 
						if ( !preg_match('/^((label)(\/_)?)/', $currentRoute) )
							echo link_to('Labels', '@label');
						else
							echo link_to('Labels', '@label', array('class' => 'header_menu_current_tab'));
						?>	
					</li>
					
					<li class="header_menu_right_tab">
						<?php 
						if ( !preg_match('/^((report)(\/_)?)/', $currentRoute) )
							echo link_to('Reports', '@report');
						else
							echo link_to('Reports', '@report', array('class' => 'header_menu_current_tab'));
						?>	
					</li>
					
					<li class="header_menu_right_tab">
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
					
					<li class="header_menu_right_tab">
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