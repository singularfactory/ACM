<?php

/**
* MyActions actions class.
*
* @package    bna_green_house
* @subpackage frontend
* @author     Eliezer Talon <elitalon@inventiaplus.com>
*/
class MyActions extends sfActions {

	/**
	 * paginationOptions
	 *
	 * @var array
	 */
	protected $paginationOptions = array(
		'sort_direction' => 'asc',
		'sort_column' => 'name',
		'init' => true,
	);
	
	
	/**
	 * buildPagination
	 *
	 * @param sfWebRequest $request Request made from page
	 * @param string $table Name of the table to paginate
	 * @param array $options Options to configure the pagination
	 * @return sfDoctrinePager
	 * @author Eliezer Talon
	 */
	protected function buildPagination(sfWebRequest $request, $table, array $options = array()) {
		// Merge default options with requested options
		foreach ($options as $key => $value) {
			if ( $value !== null && !empty($value) ) {
				$this->paginationOptions[$key] = $value;
			}
		}
		
		// Initiate a pager
		$pager = new sfDoctrinePager($table, sfConfig::get('app_max_list_items'));
		
		// Set sort direction
		if ( $request->getParameter('sort_direction') ) {
			$this->sortDirection = $request->getParameter('sort_direction');
		}
		else {
			$this->sortDirection = $this->paginationOptions['sort_direction'];
		}
		
		// Set sort columns
		if ( $sort_column = $request->getParameter('sort_column') ) {
			if ( preg_match('/^\w+\.\w+$/', $sort) ) {
				list($relatedTable, $relatedColumn) = explode('.', $sort);
				$pager->setQuery(Doctrine::getTable($table)->createQuery('t')->leftJoin("t.$relatedTable r")->orderBy("r.$relatedColumn ".$this->sortDirection).$filter);
			}
			else {
				$pager->setQuery(Doctrine::getTable($table)->createQuery('t')->orderBy("t.$sort_column ".$this->sortDirection));
			}
		}
		else {
			$pager->setQuery(Doctrine::getTable($table)->createQuery('t')->orderBy("t.{$this->paginationOptions['sort_column']} ".$this->sortDirection));
		}
		
		$pager->setPage($request->getParameter('page', 1));
		
		if ( $this->paginationOptions['init'] ) {
			$pager->init();
		}
		
		return $pager;
	}
	
}
