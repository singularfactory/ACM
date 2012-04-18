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
<?php slot('main_header', 'Edit this purchase item') ?>

<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@purchase_item') ?>
	<?php echo $form->renderHiddenFields() ?>

	<div id="left_side_form">
		<div id="status">
			<?php echo $form['status']->renderLabel() ?>
			<?php echo $form['status']->renderError() ?>
			<?php echo $form['status']->renderHelp() ?>
			<?php echo $form['status'] ?>
		</div>

		<div id="supervisor_id">
			<?php echo $form['supervisor_id']->renderLabel() ?>
			<?php echo $form['supervisor_id']->renderError() ?>
			<?php echo $form['supervisor_id']->renderHelp() ?>
			<?php echo $form['supervisor_id'] ?>
		</div>

		<div id="remarks">
			<?php echo $form['remarks']->renderLabel() ?>
			<?php echo $form['remarks'] ?>
		</div>
	</div>

	<div id="right_side_help">
		<strong>Order status</strong>
		<p><strong>Pending</strong> means that no action has been taken in order to process this item.</p>
		<p><strong>Processing</strong> means that this item it's being processed.</p>
		<p><strong>Ready</strong> means that this item has been processed.</p>
	</div>

	<div class="submit">
		<input type="submit" value="Save changes">
		or <?php echo link_to('cancel', '@purchase_order_show?id='.$form->getObject()->getPurchaseOrderId(), array('class' => 'cancel_form_link')) ?>
	</div>
</form>
