<?php

/**
 * region actions.
 *
 * @package    bna_green_house
 * @subpackage region
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class regionActions extends sfActions {
	/**
	 * Find all islands that belong to a Region
	 *
	 * @param sfWebRequest $request 
	 * @return JSOB object
	 * @author Eliezer Talon
	 * @version 2011-04-20
	 */
	public function executeFindIslands(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$results = Doctrine_Core::getTable('Island')->getIslands($request->getParameter('region'));
			$islands = array();
			foreach ($results as $island) {
				$islands[] = array('id' => $island->getId(), 'name' => $island->getName());
			}
			$this->getResponse()->setContent(json_encode($islands));
		}
		return sfView::NONE;
	}
	
}
