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