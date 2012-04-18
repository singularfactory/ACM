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
<?php if ( $modelToGroupBy || count($filters) ): ?>
<div id="report_results_conditions">
<?php if ( $modelToGroupBy ): ?>
	<?php $modelToGroupBy = preg_replace('/^is_/', '', $modelToGroupBy) ?>
	<?php $modelToGroupBy = preg_replace('/^(\d+)_(\d+)_ratio$/', '$1:$2 ratio', $modelToGroupBy) ?>
	<?php $modelToGroupBy = preg_replace('/^in_g_catalog$/', 'presence in G-catalog', $modelToGroupBy) ?>
	<?php $modelToGroupBy = str_replace('_', ' ', $modelToGroupBy) ?>

	<span>Results <strong>grouped by <?php echo $modelToGroupBy ?></strong>

	<?php if ( count($filters) ): ?>
		and limited to the following conditions:</span>
		<dl>
		<?php foreach ( $filters as $key => $value ): ?>
			<dt>
				<?php
				if ( $key == '260_280_ratio' || $key == '260_230_ratio' ) {
					echo preg_replace('/^(\d+)_(\d+)_ratio$/', '$1:$2 ratio', $key);
				}
				else {
					echo sfInflector::humanize(sfInflector::tableize($key));
				}
				?>:
			</dt>
			<dd><?php echo $value ?></dd>
		<?php endforeach ?>
		</dl>
	<?php else: ?>
		</span>
	<?php endif ?>
</div>

<?php else: ?>

	<?php if ( count($filters) ): ?>
		<span>Results limited to the following conditions:</span>
		<dl>
		<?php foreach ( $filters as $key => $value ): ?>
			<dt>
				<?php
				if ( $key == '260_280_ratio' || $key == '260_230_ratio' ) {
					echo preg_replace('/^(\d+)_(\d+)_ratio$/', '$1:$2 ratio', $key);
				}
				else {
					echo sfInflector::humanize(sfInflector::tableize($key));
				}
				?>:
			</dt>
			<dd><?php echo $value ?></dd>
		<?php endforeach ?>
		</dl>
	<?php endif ?>

<?php endif ?>
</div>
<?php endif ?>
