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
<?php slot('main_header', 'Edit this purchase order') ?>

<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@purchase_order') ?>
	<?php echo $form->renderHiddenFields() ?>

	<div id="left_side_form">
		<div id="code">
			<?php echo $form['code']->renderLabel() ?>
			<?php echo $form['code']->renderError() ?>
			<?php echo $form['code']->renderHelp() ?>
			<?php echo $form['code'] ?>
		</div>

		<div id="customer">
			<?php echo $form['customer']->renderLabel() ?>
			<?php echo $form['customer']->renderError() ?>
			<?php echo $form['customer']->renderHelp() ?>
			<?php echo $form['customer'] ?>
		</div>

		<div id="status">
			<?php echo $form['status']->renderLabel() ?>
			<?php echo $form['status']->renderError() ?>
			<?php echo $form['status']->renderHelp() ?>
			<?php echo $form['status'] ?>
		</div>

		<div id="delivery_code">
			<?php echo $form['delivery_code']->renderLabel() ?>
			<?php echo $form['delivery_code']->renderError() ?>
			<?php echo $form['delivery_code']->renderHelp() ?>
			<?php echo $form['delivery_code'] ?>
		</div>

		<div id="remarks">
			<?php echo $form['remarks']->renderLabel() ?>
			<?php echo $form['remarks'] ?>
		</div>
	</div>

	<div id="right_side_help">
		<strong>Order status</strong>
		<p><strong>Pending</strong> means that the purchase order has been received but no action has been taken in order to process it.</p>
		<p><strong>Processing</strong> means that the purchase order it's being processed and optionally one or more of the purchase items are being processed as well.</p>
		<p><strong>Ready</strong> means that every item has been processed and the purchase order is ready to be delivered, but has not been sent yet.</p>
		<p><strong>Sent</strong> means that the purchase order has been sent to the customer. Changing to this status also updates the public web.</p>
		<p><strong>Canceled</strong> means that the purchase order has been canceled and will not be sent to the customer. Changing to this status also updates the public web.</p>
		<p><strong>Refunded</strong> means that the purchase order has been refunded to the customer. Changing to this status also updates the public web.</p>
	</div>

	<?php include_partial('global/submit_form_div', array('form' => $form, 'module' => 'purchase_order', 'add' => false)) ?>
</form>
