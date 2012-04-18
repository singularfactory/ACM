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
<div id="report_sample_group_by">
	<?php echo $form['sample_group_by']->renderLabel() ?>
	<?php echo $form['sample_group_by']->renderError() ?>
	<?php echo $form['sample_group_by']->renderHelp() ?>
	<?php echo $form['sample_group_by'] ?>
</div>

<div id="report_sample_environment" class="report_inline_where">
	<?php echo $form['sample_environment']->renderLabel() ?>
	<?php echo $form['sample_environment']->renderError() ?>
	<?php echo $form['sample_environment']->renderHelp() ?>
	<?php echo $form['sample_environment'] ?>
</div>

<div id="report_sample_habitat" class="report_inline_where">
	<?php echo $form['sample_habitat']->renderLabel() ?>
	<?php echo $form['sample_habitat']->renderError() ?>
	<?php echo $form['sample_habitat']->renderHelp() ?>
	<?php echo $form['sample_habitat'] ?>
</div>

<div id="report_sample_radiation" class="report_inline_where">
	<?php echo $form['sample_radiation']->renderLabel() ?>
	<?php echo $form['sample_radiation']->renderError() ?>
	<?php echo $form['sample_radiation']->renderHelp() ?>
	<?php echo $form['sample_radiation'] ?>
</div>

<div id="report_sample_extremophile" class="report_inline_where">
	<?php echo $form['sample_extremophile']->renderLabel() ?>
	<?php echo $form['sample_extremophile']->renderError() ?>
	<?php echo $form['sample_extremophile']->renderHelp() ?>
	<?php echo $form['sample_extremophile'] ?>
</div>

<div id="report_sample_location_details">
	<?php echo $form['sample_location_details']->renderLabel() ?>
	<?php echo $form['sample_location_details']->renderError() ?>
	<?php echo $form['sample_location_details']->renderHelp() ?>
	<?php echo $form['sample_location_details'] ?>
</div>
