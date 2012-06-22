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
 * @since         1.2
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */
?>
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@potential_usage') ?>
	<?php echo $form->renderHiddenFields() ?>

	<div id="left_side_form">
		<div class="form-section">
			<h3>Taxonomic classification</h3>
			<div id="taxonomic_class">
				<?php echo $form['taxonomic_class_id']->renderLabel() ?>
				<?php echo $form['taxonomic_class_id']->renderError() ?>
				<?php echo $form['taxonomic_class_id']->renderHelp() ?>
				<?php echo $form['taxonomic_class_id'] ?>
			</div>
			<div id="genus">
				<?php echo $form['genus_id']->renderLabel() ?>
				<?php echo $form['genus_id']->renderError() ?>
				<?php echo $form['genus_id']->renderHelp() ?>
				<?php echo $form['genus_id'] ?>
			</div>
			<div id="species">
				<?php echo $form['species_id']->renderLabel() ?>
				<?php echo $form['species_id']->renderError() ?>
				<?php echo $form['species_id']->renderHelp() ?>
				<?php echo $form['species_id'] ?>
			</div>
		</div>
	</div>

	<div id="right_side_form">
		<div class="form-section">
			<h3>Usages</h3>
			<?php foreach($usageAreas as $area): ?>
			<div class="usage-area">
				<h4><?php echo $area->getName() ?></h4>
				<div class="usage-area-usages">
					<ul>
						<?php $i = 0 ?>
						<?php foreach($area->getUsageAreaUsageTargets() as $usage): ?>
						<?php $id = sprintf('strain_taxonomy_potential_usages_list_%d', $usage->getId()) ?>
						<li>
							<?php $checked = ($usage->isApplicableToTaxonomy($form->getObject()->getId())) ? 'checked="checked"' : '' ?>
							<input type="checkbox" name="strain_taxonomy[potential_usages_list][]" value="<?php echo $usage->getId() ?>" <?php echo $checked ?> id="<?php echo $id ?>" />
							<label for="<?php echo $id ?>"><?php echo $usage->getUsageTarget()->getName() ?></label>
						</li>
						<?php endforeach ?>
					</ul>
				</div>
			</div>
			<?php endforeach ?>
		</div>
	</div>

	<?php include_partial('global/submit_form_div', array('form' => $form, 'module' => 'potential_usage', 'add' => false)) ?>
</form>

