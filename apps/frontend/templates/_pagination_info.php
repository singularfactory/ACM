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
if (in_array($model, array('location', 'sample', 'strain', 'dna_extraction', 'patent_deposit', 'maintenance_deposit', 'culture_medium', 'cryopreservation', 'external_strain', 'project', 'identification'))) {
	$url = "@module_pagination?module=$model&";
} else {
	$url = "@{$model}_pagination?";
	if ($text = $sf_user->getAttribute('search.criteria')) {
		$url = "@{$model}_search_pagination?";
	}
}
?>

<?php $url_parameters = array() ?>

<?php if (isset($sort_column) & !empty($sort_column)): ?>
<?php $url_parameters['sort_column'] = $sort_column ?>
<?php endif ?>

<?php if (isset($sort_direction) & !empty($sort_direction)): ?>
<?php $url_parameters['sort_direction'] = ($sort_direction === 'asc') ? 'desc' : 'asc' ?>
<?php endif ?>

<?php if ($text = $sf_user->getAttribute('search.criteria')): ?>
<?php $url_parameters['criteria'] = urlencode($text) ?>
<?php endif ?>

<?php foreach ($url_parameters as $parameter => $value): ?>
<?php $url .= "$parameter=$value&" ?>
<?php endforeach ?>

<?php $url .= "page=" ?>

<div id="pagination">
	<?php echo count($pager) ?> items - showing page <?php echo $pager->getPage() ?> of <?php echo $pager->getLastPage() ?>

	<span id="pagination_links">
		<?php echo link_to(image_tag('first.png', array('alt' => 'First page', 'title' => 'First page')), $url.$pager->getFirstPage(), array('class' => 'button')) ?>
		<?php echo link_to(image_tag('previous.png', array('alt' => 'Previous page', 'title' => 'Previous page')), $url.$pager->getPreviousPage(), array('class' => 'button')) ?>

		<?php foreach ($pager->getLinks() as $page): ?>
		<?php echo ($page == $pager->getPage()) ? $page : link_to($page, $url.$page) ?>
		<?php endforeach ?>

		<?php echo link_to(image_tag('next.png', array('alt' => 'Next page', 'title' => 'Next page')), $url.$pager->getNextPage(), array('class' => 'button')) ?>
		<?php echo link_to(image_tag('last.png', array('alt' => 'Last page', 'title' => 'Last page')), $url.$pager->getLastPage(), array('class' => 'button')) ?>
	</span>

	<?php if (!isset($warning)) $warning = true ?>
	<span id="pagination_cancelation">
		<?php echo link_to(
			'Show all records',
			empty($url_parameters['criteria']) ? "@module_full_index?module=$model" : "@module_full_index_search?module=$model&criteria=".$url_parameters['criteria'],
			array('confirm' => ($warning == true)?'Displaying all results may take some time depending on the number of results. Do you want to continue?':false)) ?>
	</span>
</div>
