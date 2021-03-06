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

<?php if ( $form->getObject()->isNew() ): ?>
<?php echo $form->renderFormTag(url_for('@pcr_create?dna_extraction='.$sf_request->getParameter('dna_extraction'))) ?>
<?php else: ?>
<?php echo $form->renderFormTag(url_for('@pcr_update?id='.$form->getObject()->getId().'&dna_extraction='.$form->getObject()->getDnaExtractionId())) ?>
<?php endif ?>
	<?php echo $form->renderHiddenFields() ?>

	<div id="left_side_form">
		<div id="dna_polymerase">
			<?php echo $form['dna_polymerase_id']->renderLabel() ?>
			<?php echo $form['dna_polymerase_id']->renderError() ?>
			<?php echo $form['dna_polymerase_id']->renderHelp() ?>
			<?php echo $form['dna_polymerase_id'] ?>
		</div>

		<div id="forward_dna_primer">
			<?php echo $form['forward_dna_primer_id']->renderLabel() ?>
			<?php echo $form['forward_dna_primer_id']->renderError() ?>
			<?php echo $form['forward_dna_primer_id']->renderHelp() ?>
			<?php echo $form['forward_dna_primer_id'] ?>
		</div>

		<div id="reverse_dna_primer">
			<?php echo $form['reverse_dna_primer_id']->renderLabel() ?>
			<?php echo $form['reverse_dna_primer_id']->renderError() ?>
			<?php echo $form['reverse_dna_primer_id']->renderHelp() ?>
			<?php echo $form['reverse_dna_primer_id'] ?>
		</div>

		<div id="pcr_program_id">
			<?php echo $form['pcr_program_id']->renderLabel() ?>
			<?php echo $form['pcr_program_id']->renderError() ?>
			<?php echo $form['pcr_program_id']->renderHelp() ?>
			<?php echo $form['pcr_program_id'] ?>
		</div>

		<div id="concentration">
			<?php echo $form['concentration']->renderLabel() ?>
			<?php echo $form['concentration']->renderError() ?>
			<?php echo $form['concentration']->renderHelp() ?>
			<?php echo $form['concentration'] ?>
		</div>

		<div id="ratio_260_280">
			<?php echo $form['260_280_ratio']->renderLabel() ?>
			<?php echo $form['260_280_ratio']->renderError() ?>
			<?php echo $form['260_280_ratio']->renderHelp() ?>
			<?php echo $form['260_280_ratio'] ?>
		</div>

		<div id="ratio_260_230">
			<?php echo $form['260_230_ratio']->renderLabel() ?>
			<?php echo $form['260_230_ratio']->renderError() ?>
			<?php echo $form['260_230_ratio']->renderHelp() ?>
			<?php echo $form['260_230_ratio'] ?>
		</div>
	</div>

	<div id="right_side_form">
		<div id="can_be_sequenced" class="checkbox">
			<?php echo $form['can_be_sequenced']->renderLabel() ?>
			<?php echo $form['can_be_sequenced'] ?>
			<?php echo $form['can_be_sequenced']->renderHelp() ?>
		</div>

		<div id="pcr_gel_handler">
			<?php if ( !$form->getObject()->isNew() && isset($form['Gel']) ): ?>
			<div class="model_text_input_list">
				<?php echo $form['Gel']->renderLabel('Actual gel results') ?>
				<?php $i = 0 ?>
				<ul>
					<?php foreach ($form['Gel'] as $widget): ?>
					<?php $gel = $widget->getValue() ?>
					<li>
						<input type="hidden" name="pcr[Gel][<?php echo $i ?>][is_valid]" value="<?php echo $gel['is_valid'] ?>" id="pcr_Gel_<?php echo $i ?>_is_valid" />
						<input type="hidden" name="pcr[Gel][<?php echo $i ?>][number]" value="<?php echo $gel['number'] ?>" id="pcr_Gel_<?php echo $i ?>_number" />
						<input type="hidden" name="pcr[Gel][<?php echo $i ?>][band]" value="<?php echo $gel['band'] ?>" id="pcr_Gel_<?php echo $i ?>_band" />
						<input type="hidden" name="pcr[Gel][<?php echo $i ?>][id]" value="<?php echo $gel['id'] ?>" id="pcr_Gel_<?php echo $i ?>_id" />
						<div class="model_text_input_value">
							<span><strong>#<?php echo $gel['number'] ?></strong>:&nbsp;</span>
							<span><?php echo $gel['band'] ?>&nbsp;<?php echo sfConfig::get('app_pcr_gel_band_unit') ?></span>
							<?php echo ($gel['is_valid'])?'<span class="gel_is_valid">&#x2713;':'' ?></span>
							<div class="model_text_input_value_checkbox">
								<input type="checkbox" name="pcr[Gel][<?php echo $i ?>][delete_object]" id="pcr_Gel_<?php echo $i ?>_delete_object" />
								delete
							</div>
						</div>
					</li>
					<?php $i++ ?>
					<?php endforeach; ?>
				</ul>
				<div class="clear"></div>
			</div>
			<?php endif ?>

			<div id="model_text_inputs">
				<?php echo $form['new_Gel']->renderLabel() ?>
				<?php echo $form['new_Gel']->renderError() ?>

				<div class="model_text_input_gel">
					<div class="model_text_input_number">
						# <?php echo $form['new_Gel'][0]['number']->render() ?>
					</div>

					<div class="model_text_input_band">
						<?php echo $form['new_Gel'][0]['band']->renderLabel() ?>
						<?php echo $form['new_Gel'][0]['band']->render() ?>
					</div>

					<div class="model_text_input_is_valid">
						<?php echo $form['new_Gel'][0]['is_valid']->renderLabel() ?>
						<?php echo $form['new_Gel'][0]['is_valid']->render() ?>
					</div>
				</div>
			</div>

			<div class="text_inputs_add_relation">
				<?php echo $form['new_Gel']['_']->render() ?>
			</div>
		</div>

		<div id="remarks">
			<?php echo $form['remarks']->renderLabel() ?>
			<?php echo $form['remarks'] ?>
		</div>
	</div>

	<div class="submit">
		<?php if ( $form->getObject()->isNew() ): ?>
			<?php $route = '@dna_extraction_show?id='.$sf_request->getParameter('dna_extraction') ?>
			<input type="submit" value="Create this PCR">
			<input type="submit" name="_save_and_add" value="Create and add">
		<?php else: ?>
			<?php $route = '@pcr_show?id='.$form->getObject()->getId() ?>
			<input type="submit" value="Save changes">
		<?php endif; ?>
		or <?php echo link_to('cancel', $route, array('class' => 'cancel_form_link')) ?>
	</div>
</form>
