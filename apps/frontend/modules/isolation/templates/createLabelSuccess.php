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
<span>Create labels for identification</span>
<?php include_partial('global/back_header_action', array('module' => 'isolation')) ?>
<?php include_partial('global/back_to_parent_header_action', array('title' => 'Back to isolation', 'module' => 'isolation', 'id' => $isolation->getId())) ?>
<?php end_slot() ?>

<form action="<?php echo url_for('@isolation_create_label?id='.$isolation->getId()) ?>" method="POST">
	<?php echo $form->renderHiddenFields() ?>
	<div id="left_side_form">
		<div id="copies">
			<?php echo $form['copies']->renderLabel() ?>
			<?php echo $form['copies'] ?>
		</div>
	</div>
	
	<div id="right_side_form">
		<table id="isolation_list">
			<thead>
				<tr>
					<th>Code</th>
					<th>Material</th>
					<th>Related code</th>
					<th>Reception date</th>
				</tr>
			</thead>
			<tbody>
				<?php $code = $isolation->getCode() ?>
				<?php $externalCode = $isolation->getExternalCode() ?>
				<?php $subject = $isolation->getIsolationSubject() ?>

				<?php if ($isolation->getSample()->exists()): ?>
					<?php $externalCode = $solation->getSample()->getCode() ?>
				<?php elseif ($isolation->getStrain()->exists()): ?>
					<?php $externalCode = $isolation->getStrain()->getFullCode() ?>
				<?php elseif ($isolation->getExternalStrain()->exists()): ?>
					<?php $subject = 'research_collection' ?>
					<?php $externalCode = $isolation->getExternalStrain()->getFullCode() ?>
				<?php endif ?>
				<tr>
					<td class="isolation_code"><?php echo $code ?></td>
					<td class="isolation_subject"><?php echo sfInflector::humanize($subject) ?></td>
					<td class="sample_code"><?php echo $externalCode ?></td>
					<td class="date reception_date"><?php echo $isolation->getReceptionDate() ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="submit"><input type="submit" value="Create labels"></div>
</form>

