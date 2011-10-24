<?php

/**
* label actions.
*
* @package    bna_green_house
* @subpackage label
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class labelActions extends myActions {
	
	/**
	* Executes configure action
	*
	* @param sfRequest $request A request object
	*/
	public function executeConfigure(sfWebRequest $request) {
		$this->form = new LabelForm();
	}
	
	/**
	 * Find the products that matches a search term
	 *
	 * @param sfWebRequest $request 
	 * @return JSON object with sample id and code
	 * @author Eliezer Talon
	 * @version 2011-10-24
	 */
	public function executeFindProducts(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$table = sfInflector::camelize($request->getParameter('product')).'Table';
			$tableInstance = call_user_func(array($table, 'getInstance'));
			
			$matches = array();
			foreach ( $tableInstance->findByTerm($request->getParameter('term')) as $match ) {
				$matches[] = array(
					'id' => $match->getId(),
					'label' => $match->getCode(),	// This attribute must be named label due to the jQuery Autocomplete plugin
					'transfer_interval' => ($table == 'StrainTable') ? $match->getTransferInterval():null,
				);
			}
			$this->getResponse()->setContent(json_encode($matches));
		}
		return sfView::NONE;
	}
	
	/**
	* Executes create action
	*
	* @param sfRequest $request A request object
	*/
	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new LabelForm();
		
		// Process form
		$this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
		if ($form->isValid()) {
			
		}
		
		$this->form->setDefaults(array(
			'product' => $request->getParameter('product'),
			'transfer_interval' => $request->getParameter('transfer_interval'),
		));
		
		$this->setTemplate('configure');
	}
		
}
