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

<?php slot('main_header') ?>
<span>Create labels for cryopreservation</span>
<?php include_partial('global/back_header_action', array('module' => 'cryopreservation')) ?>
<?php include_partial('global/back_to_parent_header_action', array('title' => 'Back to cryopreservation', 'module' => 'cryopreservation', 'id' => $cryopreservation->getId())) ?>
<?php end_slot() ?>

<form action="<?php echo url_for('@cryopreservation_create_label?id='.$cryopreservation->getId()) ?>" method="POST">
	<?php echo $form->renderHiddenFields() ?>
	<div id="left_side_form">
		<div id="copies">
			<?php echo $form['copies']->renderLabel() ?>
			<?php echo $form['copies'] ?>
		</div>
		
		<div id="replicate">
			<?php echo $form['replicate']->renderLabel() ?>
			<?php echo $form['replicate'] ?>
		</div>
	</div>
	
	<div id="right_side_form">
		<table id="dna_extraction_list">
			<thead>
				<tr>
					<th>Code</th>
					<th>First replicate</th>
					<th>Second replicate</th>
					<th>Third replicate</th>
					<th>Cryopreservation date</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="strain_code"><?php echo $cryopreservation->getCode() ?></td>
					<td class="replicate"><?php echo $cryopreservation->getFirstReplicate() ?></td>
					<td class="replicate"><?php echo $cryopreservation->getSecondReplicate() ?></td>
					<td class="replicate"><?php echo $cryopreservation->getThirdReplicate() ?></td>
					<td class="date cryopreservation_date"><?php echo $cryopreservation->getCryopreservationDate() ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="submit"><input type="submit" value="Create labels"></div>
</form>

