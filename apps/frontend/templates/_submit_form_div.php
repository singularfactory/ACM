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
<?php if (isset($form) && isset($module)): ?>

	<?php if (!isset($add)) $add = true ?>
	<?php if (!isset($progressBar)) $progressBar = false ?>
	<?php if (!isset($title)) $title = strtolower(sfInflector::humanize($module)) ?>
	<?php $route = "@$module" ?>

	<div class="submit">
		<?php if ( $form->getObject()->isNew() ): ?>
			<input type="submit" value="Create this <?php echo $title ?>">

			<?php if ( $add ): ?><input type="submit" name="_save_and_add" value="Create and add"><?php endif ?>

		<?php else: ?>
			<?php $route = sprintf('@%s_show?id=%d', $module, $form->getObject()->getId()) ?>
			<input type="submit" value="Save changes">
		<?php endif; ?>

		or <?php echo link_to('cancel', $route, array('class' => 'cancel_form_link')) ?>

		<?php if ( $progressBar ) echo progress_bar(); ?>
	</div>

<?php endif ?>
