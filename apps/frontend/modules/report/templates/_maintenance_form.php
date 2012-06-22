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
<div id="maintenance_strain" class="report_inline_where">
	<?php echo $form['maintenance_strain']->renderLabel() ?>
	<?php echo $form['maintenance_strain']->renderError() ?>
	<?php echo $form['maintenance_strain']->renderHelp() ?>
	<input type="text" value="" id="report_maintenance_strain_search" name="maintenance_strain_search" class="report_search_box" />
	<a href="<?php echo url_for('@report_find_strains?term=') ?>" class="report_maintenance_strain_numbers_url"></a>
	<input type="submit" value="Add Strain" id="add_strain">
</div>
<div id="maintenance_strain_report" class="report_inline_where">
	<?php echo $form['maintenance_strain_id']->renderLabel() ?>
	<?php echo $form['maintenance_strain_id']->renderError() ?>
	<?php echo $form['maintenance_strain_id']->renderHelp() ?>
	<?php echo $form['maintenance_strain_id'] ?>
	<input type="submit" value="Remove selected strains" id="remove_strain">
</div>