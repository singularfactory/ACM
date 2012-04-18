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
<?php use_helper('Text') ?>

<?php slot('main_header') ?>
<span>"<?php echo truncate_text($notification->getMessage(), 30) ?>"</span>
<?php include_partial('global/back_header_action', array('module' => 'inbox')) ?>
<?php include_partial('global/delete_header_action', array('module' => 'inbox', 'id' => $notification->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_data_list">
		<dl>
			<dt>Received:</dt>
			<dd><?php echo $notification->getDate() ?></dd>
			<dt>Message:</dt>
			<dd><?php echo $notification->getMessage(ESC_RAW) ?></dd>
		</dl>
	</div>

	<div class="clear"></div>
</div>
