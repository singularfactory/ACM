<?php

/**
* MyActions actions class.
*
* @package    bna_green_house
* @subpackage frontend
* @author     Eliezer Talon <elitalon@inventiaplus.com>
*/
class MyActions extends sfActions {
	
	protected function buildPagination(sfWebRequest $request, $table, $defaultColumn = 'name') {
		// Initiate a pager
		$pager = new sfDoctrinePager($table, sfConfig::get('app_max_list_items'));
		
		// Set sorting direction
		$this->sortType = 'asc';
		if ( $request->getParameter('sort_type') ) {
			$this->sortType = $request->getParameter('sort_type');
		}
		
		// Set sorting fields
		if ( $sort = $request->getParameter('sort') ) {
			if ( preg_match('/^\w+\.\w+$/', $sort) ) {
				list($relatedTable, $relatedColumn) = explode('.', $sort);
				$pager->setQuery(Doctrine::getTable($table)->createQuery('t')->leftJoin("t.$relatedTable r")->orderBy("r.$relatedColumn ".$this->sortType));
			}
			else {
				$pager->setQuery(Doctrine::getTable($table)->createQuery('t')->orderBy("t.$sort ".$this->sortType));
			}
		}
		else {
			$pager->setQuery(Doctrine::getTable($table)->createQuery('t')->orderBy("t.$defaultColumn ".$this->sortType));
		}
		
		$pager->setPage($request->getParameter('page', 1));
		$pager->init();
		return $pager;
	}
	
}
