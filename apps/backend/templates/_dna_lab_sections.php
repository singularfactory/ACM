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
 * @package       ACM.Backend
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */
?>
<ul>
	<?php $routes = array('extraction_kit', 'dna_polymerase', 'dna_primer', 'pcr_program') ?>
	<?php $subsectionNames = array(
		$routes[0] => 'Extraction kits',
		$routes[1] => 'DNA polymerase',
		$routes[2] => 'DNA primers',
		$routes[3] => 'PCR programs',
	)?>

	<?php foreach ( $routes as $routeValue ): ?>
		<li>
		<?php if ( preg_match('/^'.$routeValue.'_?/', $route) ): ?>
			<?php echo $subsectionNames[$routeValue] ?>
		<?php else: ?>
			<?php echo link_to($subsectionNames[$routeValue], '@'.$routeValue) ?>
		<?php endif; ?>
		</li>

		<?php if ( $routeValue !== $routes[count($routes)-1]): ?>
		<span class="subsection_separator">|</span>
		<?php endif; ?>
	<?php endforeach; ?>
</ul>