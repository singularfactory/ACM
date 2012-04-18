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
<?php
	$searchCriteria = null;
	$pageNumber = null;
	$url = $module;

	if ( $text = $sf_user->getAttribute('search.criteria') ) {
		$searchCriteria = "?criteria=$text";
		$url = "{$module}_search";
	}

	if ( $page = $sf_user->getAttribute("$module.index_page") ) {
		$pageNumber = "page=$page";
		if ( !$searchCriteria ) {
			$pageNumber = "?$pageNumber";
			$url = "{$module}_pagination";
		}
		else {
			$pageNumber = "&$pageNumber";
			$url = "{$module}_search_pagination";
		}
	}

?>

<div id="main_header_action_create_from_template" class="main_header_action">
	<?php echo link_to('Duplicate', "@{$module}_create_from_template?id=$id") ?>
</div>