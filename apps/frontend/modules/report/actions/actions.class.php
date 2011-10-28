<?php

/**
* report actions.
*
* @package    bna_green_house
* @subpackage report
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class reportActions extends sfActions {
	
	/**
	* Executes configure action
	*
	* @param sfRequest $request A request object
	*/
	public function executeConfigure(sfWebRequest $request) {
		if ( !($subject = $request->getParameter('subject')) ) {
			$subject = 'location';
		}
		
		if ( $request->isXmlHttpRequest() ) {
			return $this->renderPartial("{$subject}_form", array('form' => new ReportForm()));
		}
		
		$this->form = new ReportForm();
		$this->form->setDefault('subject', $subject);
		$this->subject = $subject;
	}
	
	/**
	 * Find the countries that matches a search term
	 *
	 * @param sfWebRequest $request 
	 * @return JSON object with country ID and name
	 * @author Eliezer Talon
	 * @version 2011-10-28
	 */
	public function executeFindCountries(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$countries = CountryTable::getInstance()->createQuery('c')
				->where('c.name LIKE ?', '%'.$request->getParameter('country').'%')->execute();
			
			$matches = array();
			foreach ( $countries as $match ) {
				$matches[] = array(
					'id' => $match->getId(),
					'label' => $match->getName(),	// This attribute must be named label due to the jQuery Autocomplete plugin
				);
			}
			$this->getResponse()->setContent(json_encode($matches));
		}
		return sfView::NONE;
	}
	
	/**
	 * Find the regions that matches a search term
	 *
	 * @param sfWebRequest $request 
	 * @return JSON object with region ID and name
	 * @author Eliezer Talon
	 * @version 2011-10-28
	 */
	public function executeFindRegions(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$regions = RegionTable::getInstance()->createQuery('r')
				->where('r.name LIKE ?', '%'.$request->getParameter('region').'%')->execute();
			
			$matches = array();
			foreach ( $regions as $match ) {
				$matches[] = array(
					'id' => $match->getId(),
					'label' => $match->getName(),	// This attribute must be named label due to the jQuery Autocomplete plugin
				);
			}
			$this->getResponse()->setContent(json_encode($matches));
		}
		return sfView::NONE;
	}
	
	/**
	 * Find the islands that matches a search term
	 *
	 * @param sfWebRequest $request 
	 * @return JSON object with island ID and code
	 * @author Eliezer Talon
	 * @version 2011-10-28
	 */
	public function executeFindIslands(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$islands = IslandTable::getInstance()->createQuery('i')
				->where('i.name LIKE ?', '%'.$request->getParameter('island').'%')->execute();
			
			$matches = array();
			foreach ( $islands as $match ) {
				$matches[] = array(
					'id' => $match->getId(),
					'label' => $match->getName(),	// This attribute must be named label due to the jQuery Autocomplete plugin
				);
			}
			$this->getResponse()->setContent(json_encode($matches));
		}
		return sfView::NONE;
	}
	
	/**
	* Executes generate action
	*
	* @param sfRequest $request A request object
	*/
	public function executeGenerate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		
		// Clean useless form values
		$taintedValues = $request->getPostParameters();
		if ( array_key_exists('location_country_search', $taintedValues) ) {
			unset($taintedValues['location_country_search']);
		}
		if ( array_key_exists('location_region_search', $taintedValues) ) {
			unset($taintedValues['location_region_search']);
		}
		if ( array_key_exists('location_island_search', $taintedValues) ) {
			unset($taintedValues['location_island_search']);
		}
		
		// Validate form
		$this->form = new ReportForm();
		$this->form->bind($taintedValues);
		$this->subject = $request->getParameter('subject');
	
		if ( !$this->form->isValid() ) {
			$this->getUser()->setFlash('notice', 'The report cannot be generated with the information you have provided. Make sure everything is OK.');		
			$this->setTemplate('configure');
		}
		else {
			$this->results = array();
			switch ( $request->getParameter('subject') ) {
				case 'sample':
					
					break;
				
				case 'strain':
					
					break;
				
				case 'dna_extraction':
					
					break;
				
				case 'location':
				default:
					
					break;
			}
		}
	}
	
}
