<?php

/**
 * country actions.
 *
 * @package    bna_green_house
 * @subpackage country
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class countryActions extends sfActions {
	/**
	 * Find all regions that belong to a Country
	 *
	 * @param sfWebRequest $request 
	 * @return JSON object
	 * @author Eliezer Talon
	 * @version 2011-04-20
	 */
	public function executeFindRegions(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$results = Doctrine_Core::getTable('Region')->getRegions($request->getParameter('country'));
			$regions = array();
			foreach ($results as $region) {
				$regions[] = array('id' => $region->getId(), 'name' => $region->getName());
			}
			$this->getResponse()->setContent(json_encode($regions));
		}
		return sfView::NONE;
	}
}
