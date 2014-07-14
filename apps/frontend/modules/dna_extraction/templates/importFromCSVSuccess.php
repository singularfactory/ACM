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
<span>Import DNA</span>
<?php include_partial('global/back_header_action', array('module' => 'dna_extraction')) ?>
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
<form action="<?php echo url_for('@dna_import') ?>" method="POST" enctype="multipart/form-data">
	<?php echo $form->renderHiddenFields() ?>

	<div class="strain-import-help">
            <?php if(isset($results) && $results!=null) :?>
                <?php if(!$error ):?>
                    <h3 class="strain-import-help-header">DNA information uploaded</h3>
                    <ol class="strain-import-help-guide">
                            <?php foreach ($results as $dnaExtraction): ?>
                            <li><?php echo link_to($dnaExtraction->getCode(), '@dna_extraction_show?id='.$dnaExtraction->getId()) ?></li>
                            <?php endforeach;?>
                    </ol>
                <?php else:?>
                    <h3 class="strain-import-help-header">Errors</h3>
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
			<li>Extraction_date format MM/DD/YYYY</li>
		</ul>
		<h3 class="strain-import-help-header">Minimum columns allowed</h3>
		<ul class="strain-import-help-guide">
			<li>MOL_CODE</li>
			<li>Extraction_date</li>
			<li>Extraction Method</li>
			<li>DNA Concentration</li>
			<li>260_280</li>
			<li>260_230</li>
			<li>Preservation</li>
			<li>Sequence</li>	
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
		<input type="submit" value="Upload"> or <?php echo link_to('cancel', '@dna_extraction', array('class' => 'cancel_form_link')) ?>
	</div>

	<div class="clear"></div>
</form>
