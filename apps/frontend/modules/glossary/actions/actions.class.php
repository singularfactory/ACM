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

/**
 * glossary actions.
 *
 * @package ACM.Frontend
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
