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
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@profile') ?>
	<?php echo $form->renderHiddenFields() ?>
	<?php echo $form->renderGlobalErrors() ?>

	<div id="left_side_form">
		<div id="first_name">
			<?php echo $form['first_name']->renderLabel() ?>
			<?php echo $form['first_name']->renderHelp() ?>
		    <?php echo $form['first_name']->renderError() ?>
		    <?php echo $form['first_name'] ?>
		</div>

		<div id="last_name">
			<?php echo $form['last_name']->renderLabel() ?>
			<?php echo $form['last_name']->renderHelp() ?>
		    <?php echo $form['last_name']->renderError() ?>
			<?php echo $form['last_name'] ?>
		</div>

		<div id="email_address">
			<?php echo $form['email_address']->renderLabel() ?>
			<?php echo $form['email_address']->renderHelp() ?>
			<?php echo $form['email_address']->renderError() ?>
			<?php echo $form['email_address'] ?>
		</div>

		<div id="username">
			<?php echo $form['username']->renderLabel() ?>
			<?php echo $form['username']->renderHelp() ?>
			<?php echo $form['username']->renderError() ?>
			<?php echo $form['username'] ?>
		</div>

		<div id="password">
			<?php echo $form['password']->renderLabel() ?>
			<?php echo $form['password']->renderHelp() ?>
			<?php echo $form['password']->renderError() ?>
			<?php echo $form['password'] ?>
		</div>

		<div id="password_again">
			<?php echo $form['password_again']->renderHelp() ?>
			<?php echo $form['password_again']->renderError() ?>
			<?php echo $form['password_again'] ?>
		</div>

		<div id="notifications" class="checkbox checkbox_group">
			<p>Notify me when...</p>
			<?php echo $form['notify_new_order'] ?>
			<?php echo $form['notify_new_order']->renderLabel() ?>
			<br />
			<?php echo $form['notify_ready_order'] ?>
			<?php echo $form['notify_ready_order']->renderLabel() ?>
		</div>

		<div id="avatar">
			<?php echo $form['avatar']->renderLabel() ?>
			<?php echo $form['avatar']->renderHelp() ?>

			<?php if ( $filename = $form['avatar']->getValue() && false ): ?>
				<?php $avatar = sfConfig::get('app_pictures_dir').sfConfig::get('app_avatar_dir').'/'.$filename ?>
				<?php $size = sfConfig::get('app_max_avatar_size') ?>
				<div id="avatar_image">
					<img src="<?php echo $avatar ?>" alt="Picture of <?php echo $form['username']->getValue() ?>" width="<?php $size ?>" height="<?php $size ?>" />
				</div>
			<?php endif; ?>

			<?php echo $form['avatar']->renderError() ?>
			<?php echo $form['avatar'] ?>
		</div>
	</div>

	<div id="right_side_form">
		<?php echo $form['token']->renderLabel() ?>
		<p class="input_help input_long_help">
			Your authentication token is a special code that allows outside software and services to connect to your account with your permission. It works like a password so you should keep it safe just as you do with your username and password. If you think your token might have been compromised, you can generate a new one.
		</p>
		<p class="token_label">Token for iPad application</p>
		<p class="token_value">
			<span id="token_value_ipad"><?php echo $form->getObject()->getToken(); ?></span>
			<?php echo link_to('regenerate', '@profile_token_regeneration', array('id' => 'token_regeneration_link')) ?>
		</p>
	</div>

	<div class="submit">
		<input type="submit" value="Save changes">
		or <?php echo link_to('cancel', $sf_request->getReferer(), array('class' => 'cancel_form_link')) ?>
	</div>
</form>