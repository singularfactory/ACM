<?php

/**
 * glossary actions.
 *
 * @package    bna_green_house
 * @subpackage glossary
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class glossaryActions extends MyActions {

  public function executeIndex(sfWebRequest $request) {
    // Initiate the pager with default parameters but delay pagination until search criteria has been added
    $this->pager = $this->buildPagination($request, 'GlossaryTerm', array('init' => false, 'sort_column' => 'term'));
    
    // Deal with search criteria
    if ( $text = $request->getParameter('criteria') ) {
      $query = $this->pager->getQuery()
        ->where("{$this->mainAlias()}.term LIKE ?", "%$text%")
        ->orWhere("{$this->mainAlias()}.synonyms LIKE ?", "%$text%");
            
      // Keep track of search terms for pagination
      $this->getUser()->setAttribute('search.criteria', $text);
    }
    else {
      $query = $this->pager->getQuery();
      $this->getUser()->setAttribute('search.criteria', null);
    }
    $this->pager->setQuery($query);
    $this->pager->init();
    
    // Keep track of the last page used in list
    $this->getUser()->setAttribute('glossary.index_page', $request->getParameter('page'));
    
    // Add a form to filter results
    $this->form = new GlossaryTermForm();
  }
  
}
