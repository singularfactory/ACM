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
<?php if ($groupBy || count($filters)): ?>
<div id="filter-conditions">
	<span>Active filters:</span>
	<dl>
		<?php foreach ($filters as $key => $value): ?>
		<dt><?php echo sfInflector::humanize(sfInflector::tableize(preg_replace('/^(\d+)_(\d+)_ratio$/', '$1:$2 ratio', $key))) ?>:</dt>
		<dd><?php echo $value ?></dd>
		<?php endforeach ?>
		<?php if ($groupBy): ?>
		<?php $groupBy = preg_replace('/^is_/', '', $groupBy) ?>
		<?php $groupBy = preg_replace('/^(\d+)_(\d+)_ratio$/', '$1:$2 ratio', $groupBy) ?>
		<?php $groupBy = str_replace('_', ' ', $groupBy) ?>
		<dt>Grouped by:</dt>
		<dd><?php echo ucfirst($groupBy) ?></dd>
		<?php endif ?>
	</dl>
	<div class="filter-conditions-actions">
		<?php echo link_to('Clear results', $route, array('class' => 'clear-filter-conditions')) ?>
	</div>
</div>
<?php endif ?>
