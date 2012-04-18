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
<?php use_helper('Text') ?>

<?php slot('main_header') ?>
<span>Glossary</span>
  <?php include_partial('global/search_box_header_action', array('route' => '@glossary_search?criteria=')) ?>
<?php end_slot() ?>

<?php if ( $pager->count() ): ?>
<table id="glossary_list">
  <tbody>
    <tr>
      <?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
      <th><?php echo link_to('Term', '@glossary?sort_column=term&sort_direction='.$sortDirection) ?></th>
      <th><?php echo link_to('Synonyms', '@glossary?sort_column=synonyms&sort_direction='.$sortDirection) ?></th>
    </tr>

    <?php foreach ($pager->getResults() as $glossary_term): ?>
    <tr>
      <td class="glossary_term"><?php echo $glossary_term->getTerm() ?></td>
      <td class="glossary_synonyms"><?php echo truncate_text($glossary_term->getSynonyms(), 140) ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
  <?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'glossary', 'sort_direction' => $sortDirection, 'sort_column' => $sortColumn)) ?>
<?php endif ?>

<?php else: ?>
  <p>There are no terms to show.</p>
<?php endif; ?>