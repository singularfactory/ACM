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
<?php if ($sf_user->hasFlash('notice') || $sf_user->hasFlash('error')): ?>
    <div>
        <div id="flash_box">
            <div class="flash_close"></div>
            <div class="flash_inner">					
                <?php echo $sf_user->getFlash('notice') ?>
            </div>
        </div>
    </div>
<?php endif ?>
<form action="<?php echo url_for('@strain_import') ?>" method="POST" enctype="multipart/form-data">
	<?php echo $form->renderHiddenFields() ?>

	<div class="strain-import-help">
            <?php if(isset($results) && $results!=null) :?>
                <?php if(!$error ):?>
                    <h3 class="strain-import-help-header">Strains information uploaded</h3>
                    <ol class="strain-import-help-guide">
                            <?php foreach ($results as $strain): ?>
                            <li><?php echo link_to($strain->getFullCode(), '@strain_show?id='.$strain->getId()) ?></li>
                            <?php endforeach;?>
                    </ol>
                <?php else:?>
                    <h3 class="strain-import-help-header">Strains errors</h3>
                    <ol class="strain-import-help-guide">
                            <?php foreach ($results as $error): ?>
                            <li><?php echo $error ?></li>
                            <?php endforeach;?>
                    </ol>
                <?php endif?>
            <?php else:?>
		<h3 class="strain-import-help-header">CSV file requirements</h3>
		<ul class="strain-import-help-guide">
			<li>The first line must contain the headers.</li>
			<li>No matter the order of the columns or if you have a number greater than the minimum.</li>
			<li>Each column MUST be separated using a semicolon (;) and wrapped in double quotes (").</li>
			<li>A column may have multiple values separated by a (&).</li>
                        <li>STRAIN_CULTURE_CONTAINER field the first value in the list is selected as the Best container</li>
			<li><strong>Important:</strong>&nbsp;Lines with related data not previously created in ACM will be incorrect, fields: SAMPLE_CODE_ACM,STRAIN_CULTURE_MEDIUM_1,STRAIN_CULTURE_MEDIUM_2,SAMPLE_ISOLATOR,STRAIN_TAX_AUTHORITY,STRAIN_DEPOSITOR,STRAIN_SUPERVISOR </li>
		</ul>
		<h3 class="strain-import-help-header">Minimum columns allowed</h3>
		<ul class="strain-import-help-guide">
			<li>#BEA_CODE</li>
			<li>STRAIN_CLONE</li>
			<li>STRAIN_AXENICITY</li>
			<li>SAMPLE_CODE_ACM</li>
			<li>TAX_CURRENT_CLASS</li>
			<li>TAX_CURRENT_GENUS</li>
			<li>TAX_CURRENT_SPECIES</li>
			<li>STRAIN_TAX_AUTHORITY</li>
			<li>STRAIN_TYPE_STRAIN (0|1)</li>
			<li>SAMPLE_ISOLATOR (List)</li>
			<li>SAMPLE_ISOLATION_DATE ('MM/YYYY | DD/MM/YYYY | YYYY)</li>
			<li>STRAIN_DEPOSITOR</li>
			<li>STRAIN_REMARKS</li>
			<li>STRAIN_CULTURE_MEDIUM_1</li>
			<li>STRAIN_CULTURE_MEDIUM_2 (List)</li>
			<li>STRAIN_CULTURE_CONTAINER (List)</li>
			<li>STRAIN_TRANSFER_INTERVAL_1</li>
			<li>STRAIN_SUPERVISOR</li>
			<li>CRYO_AUTO_CALC (0|1)(List)</li>
			<li>STRAIN_PUBLIC (0|1)</li>
			<li>STRAIN_STATUS</li>
			<li>SAMPLE_OLD_CODE_SAMPLING</li>
			<li>STRAIN_NOTES_FOR_THE_WEB</li>
			<li>STRAIN_RELATIVES</li>
			<li>STRAIN_REFERENCES</li>
		</ul>
            <?php endif;?>
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
