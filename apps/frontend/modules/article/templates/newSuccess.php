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
<?php use_helper('Thumbnail') ?>
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php slot('main_header') ?>
<span>New article</span>
<?php end_slot() ?>

<form action="<?php echo url_for('@article_configure') ?>" method="POST">
	<?php echo $form->renderHiddenFields() ?>

	<div id="article_strain_id">
		<?php echo $form['strain_id']->renderLabel() ?>
		<?php echo $form['strain_id']->renderError() ?>
		<?php echo $form['strain_id']->renderHelp() ?>
		<input type="text" value="Type a strain code..." id="article_strain_search" />
		<a href="<?php echo url_for('@article_find_strains?term=') ?>" class="article_strain_numbers_url"></a>
	</div>

	<div class="submit">
		<input type="submit" value="Configure article" />
	</div>
</form>