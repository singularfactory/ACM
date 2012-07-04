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
<div id="name">
	<?php echo $form['name']->renderLabel() ?>
	<?php echo $form['name'] ?>
</div>
<div id="country">
	<?php echo $form['country_id']->renderLabel() ?>
	<?php echo $form['country_id'] ?>
	<a href="<?php echo url_for('@country_find_regions?country=') ?>" class="country_regions_url"></a>
</div>
<div id="region">
	<?php echo $form['region_id']->renderLabel() ?>
	<?php echo $form['region_id'] ?>
	<a href="<?php echo url_for('@region_find_islands?region=') ?>" class="region_islands_url"></a>
</div>
<div id="island">
	<?php echo $form['island_id']->renderLabel() ?>
	<?php echo $form['island_id'] ?>
</div>
<div id="category">
	<?php echo $form['category_id']->renderLabel() ?>
	<?php echo $form['category_id'] ?>
</div>
<div id="group_by">
	<?php echo $form['group_by']->renderLabel() ?>
	<?php echo $form['group_by'] ?>
</div>
