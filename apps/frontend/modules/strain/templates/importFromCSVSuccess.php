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
<span>Import strains</span>
<?php include_partial('global/back_header_action', array('module' => 'strain')) ?>
<?php end_slot() ?>

<form action="<?php echo url_for('@strain_import') ?>" method="POST" enctype="multipart/form-data">
	<?php echo $form->renderHiddenFields() ?>

	<div class="strain-import-help">
		<h3 class="strain-import-help-header">CSV file requirements</h3>
		<ul class="strain-import-help-guide">
			<li>Each line MUST have 26 columns but empty columns are allowed if their value is unknown.</li>
			<li>Each column MUST be separated using a semicolon (;) and wrapped in double quotes (").</li>
			<li>A column may have multiple values separated by a comma (,).</li>
			<li><strong>Important:</strong>&nbsp;Lines with related data not previously created in ACM will be ignored, e.g. you cannot establish a relationship with a kingdom if it's not present in ACM database.</li>
		</ul>

		<h3 class="strain-import-help-header">Allowed column values</h3>
		<ol class="strain-import-help-guide">
			<li>Strain code</li>
			<li>Sample code</li>
			<li>Kingdom</li>
			<li>Subkingdom</li>
			<li>Phylum</li>
			<li>Taxonomic class</li>
			<li>Taxonomic order</li>
			<li>Family</li>
			<li>Genus</li>
			<li>Species</li>
			<li>Authority</li>
			<li>Is epitype? (0 or 1) </li>
			<li>Isolators (list)</li>
			<li>Isolation date (YYYY-MM-DD)</li>
			<li>Identifier</li>
			<li>Depositor</li>
			<li>Maintenance statuses (list)</li>
			<li>Best culture medium</li>
			<li>Available culture media (list)</li>
			<li>Best container</li>
			<li>Available containers (list)</li>
			<li>Transfer interval</li>
			<li>Supervisor</li>
			<li>Temperature (without the unit)</li>
			<li>Photoperiod (without the unit)</li>
			<li>Irradiation (without the unit)</li>
		</ol>
	</div>

	<div class="strain-import-form">
		<div id="filename">
			<?php echo $form['filename']->renderLabel() ?>
			<?php echo $form['filename']->renderError() ?>
			<?php echo $form['filename']->renderHelp() ?>
			<?php echo $form['filename'] ?>
		</div>
		<input type="submit" value="Upload"> or <?php echo link_to('cancel', '@strain', array('class' => 'cancel_form_link')) ?>
	</div>

	<div class="clear"></div>
</form>
