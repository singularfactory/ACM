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
<div id="report_dna_extraction_group_by">
	<?php echo $form['dna_extraction_group_by']->renderLabel() ?>
	<?php echo $form['dna_extraction_group_by']->renderError() ?>
	<?php echo $form['dna_extraction_group_by']->renderHelp() ?>
	<?php echo $form['dna_extraction_group_by'] ?>
</div>

<div id="report_dna_extraction_extraction_kit" class="report_inline_where">
	<?php echo $form['dna_extraction_extraction_kit']->renderLabel() ?>
	<?php echo $form['dna_extraction_extraction_kit']->renderError() ?>
	<?php echo $form['dna_extraction_extraction_kit']->renderHelp() ?>
	<?php echo $form['dna_extraction_extraction_kit'] ?>
</div>

<div id="report_dna_extraction_aliquots" class="report_inline_where">
	<?php echo $form['dna_extraction_aliquots']->renderLabel() ?>
	<?php echo $form['dna_extraction_aliquots']->renderError() ?>
	<?php echo $form['dna_extraction_aliquots']->renderHelp() ?>
	<?php echo $form['dna_extraction_aliquots'] ?>
</div>

<div id="report_dna_extraction_concentration" class="report_inline_where">
	<?php echo $form['dna_extraction_concentration']->renderLabel() ?>
	<?php echo $form['dna_extraction_concentration']->renderError() ?>
	<?php echo $form['dna_extraction_concentration']->renderHelp() ?>
	<?php echo $form['dna_extraction_concentration'] ?>
</div>

<div class="clear"></div>

<div id="report_dna_extraction_260_280_ratio" class="report_inline_where">
	<?php echo $form['dna_extraction_260_280_ratio']->renderLabel() ?>
	<?php echo $form['dna_extraction_260_280_ratio']->renderError() ?>
	<?php echo $form['dna_extraction_260_280_ratio']->renderHelp() ?>
	<?php echo $form['dna_extraction_260_280_ratio'] ?>
</div>

<div id="report_dna_extraction_260_230_ratio" class="report_inline_where">
	<?php echo $form['dna_extraction_260_230_ratio']->renderLabel() ?>
	<?php echo $form['dna_extraction_260_230_ratio']->renderError() ?>
	<?php echo $form['dna_extraction_260_230_ratio']->renderHelp() ?>
	<?php echo $form['dna_extraction_260_230_ratio'] ?>
</div>
