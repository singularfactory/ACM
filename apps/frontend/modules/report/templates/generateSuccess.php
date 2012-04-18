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
<?php slot('main_header') ?>
<span>Report results for <?php echo ( $subject === 'dna_extraction' ) ? 'DNA extraction' : sfInflector::humanize($subject) ?></span>
<div id="main_header_action_back" class="main_header_action">
	<?php echo link_to('Create another report', "@report") ?>
</div>
<?php end_slot() ?>

<?php include_partial('report_conditions', array('modelToGroupBy' => $modelToGroupBy, 'filters' => $filters)) ?>

<?php if ( count($results) ): ?>
	<?php if ( in_array($subject, array('location', 'sample', 'strain', 'dna_extraction')) ): ?>
	<?php include_partial("{$subject}_table", array('results' => $results, 'modelToGroupBy' => $modelToGroupBy, 'filters' => $filters)) ?>
	<?php endif ?>
<?php else: ?>
	<p>There are no results to show.</p>
<?php endif; ?>