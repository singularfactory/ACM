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

<?php echo form_tag_for($form, '@identification') ?>
	<?php echo $form->renderHiddenFields() ?>

	<div id="left_side_form">

		<div id="sample_id">
			<?php echo $form['sample_id']->renderLabel() ?>
			<?php echo $form['sample_id']->renderError() ?>
			<?php echo $form['sample_id']->renderHelp() ?>
			<input type="text" value="<?php echo ($form->isNew() || !$form->getObject()->getSample()->exists())?'Type a sample code...':$form->getObject()->getSample()->getCode(); ?>" id="identification_sample_search" />
			<a href="<?php echo url_for('@identification_find_samples?term=') ?>" class="identification_sample_numbers_url"></a>
		</div>

		<div id="identification_date" class="date_field">
			<?php echo $form['identification_date']->renderLabel() ?>
			<?php echo $form['identification_date']->renderError() ?>
			<?php echo $form['identification_date']->renderHelp() ?>
			<?php echo $form['identification_date'] ?>
		</div>

		<div id="identification_petitioner">
			<?php echo $form['petitioner']->renderLabel() ?>
			<?php echo $form['petitioner']->renderError() ?>
			<?php echo $form['petitioner']->renderHelp() ?>
			<?php echo $form['petitioner'] ?>
		</div>

		<div id="microscopy_identification">
			<?php echo $form['microscopy_identification']->renderLabel() ?>
			<?php echo $form['microscopy_identification']->renderError() ?>
			<?php echo $form['microscopy_identification']->renderHelp() ?>
			<?php echo $form['microscopy_identification'] ?>
		</div>

		<div id="molecular_identification">
			<?php echo $form['molecular_identification']->renderLabel() ?>
			<?php echo $form['molecular_identification']->renderError() ?>
			<?php echo $form['molecular_identification']->renderHelp() ?>
			<?php echo $form['molecular_identification'] ?>
		</div>
	</div>

	<div id="right_side_form">
		<div id="request_document">
			<?php echo $form['request_document']->renderLabel() ?>
			<?php echo $form['request_document']->renderError() ?>
			<?php echo $form['request_document']->renderHelp() ?>
			<?php echo $form['request_document'] ?>
		</div>

		<div id="report_document">
			<?php echo $form['report_document']->renderLabel() ?>
			<?php echo $form['report_document']->renderError() ?>
			<?php echo $form['report_document']->renderHelp() ?>
			<?php echo $form['report_document'] ?>
		</div>

		<div id="remarks">
			<?php echo $form['remarks']->renderLabel() ?>
			<?php echo $form['remarks'] ?>
		</div>

		<?php if ( $filename = $form['sample_picture']->getValue() ): ?>
		<div id="sample_picture" class="model_picture_list">
			<?php echo $form['sample_picture']->renderLabel('Actual sample picture') ?>
			<div class="thumbnail identification_thumbnail">
				<div class="thumbnail_image">
					<a href="<?php echo get_picture_with_path($filename, 'identification') ?>" rel="thumbnail_link" title="Sample picture" class="cboxElement">
						<img src="<?php echo get_thumbnail($filename, 'identification') ?>" alt="Sample picture" />
					</a>
				</div>
			</div>

			<div class="clear"></div>
		</div>
		<?php endif ?>

		<div id="model_pictures">
			<?php echo $form['sample_picture']->renderLabel() ?>
			<?php echo $form['sample_picture']->renderHelp() ?>
			<div class="model_picture_filename">
				<?php echo $form['sample_picture']->render() ?>
			</div>
		</div>

	</div>

	<?php include_partial('global/submit_form_div', array('form' => $form, 'module' => 'identification')) ?>
</form>
