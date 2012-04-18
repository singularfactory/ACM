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
<?php slot('error_message') ?>
	<?php if ( $form->hasGlobalErrors() ): ?>
		<span>
			Unknown error. Contact administrators
		</span>
	<?php elseif ( $form->hasErrors() ): ?>
		<span>
			Invalid username and/or password
		</span>
	<?php endif; ?>
<?php end_slot() ?>

<form action="<?php echo url_for('@login') ?>" method="post">
	<?php echo $form->renderHiddenFields() ?>
	<div id="username" class="input">
		<?php echo $form['username']->renderLabel() ?>
		<?php echo $form['username']; ?>
	</div>
	<div id="password" class="input">
		<?php echo $form['password']->renderLabel() ?>
		<?php echo $form['password']; ?>
	</div>
	<div class="submit">
		<input type="submit" value="Sign in">
	</div>

</form>