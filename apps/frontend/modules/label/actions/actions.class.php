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
		if ( !($productType = $request->getParameter('product_type')) ) {
			$productType = 'strain';
		}
		
		if ( $request->isXmlHttpRequest() ) {
			return $this->renderPartial("{$product_type}_form", array('form' => new LabelForm()));
		}
		
		$this->form = new LabelForm();
		$this->productType = $productType;
		$this->productCode = '';
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
					
					// Strain attributes
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
		
		// Clean useless form values
		$taintedValues = $request->getPostParameters();
		unset($taintedValues['product_id_search']);
		if ( isset($taintedValues['all_products']) ) {
			$taintedValues['product_id'] = 0;
		}
		
		// Validate form
		$this->form = new LabelForm();
		$this->form->bind($taintedValues);
		$this->productType = $request->getParameter('product_type');
		$this->productId = $request->getParameter('product_id');
		$this->productCode = $request->getParameter('product_id_search');
	
		if ( !$this->form->isValid() ) {
			$this->getUser()->setFlash('notice', 'The labels cannot be created with the information you have provided. Make sure everything is OK.');		
			$this->setTemplate('configure');
		}
		else {
			// Get common parameters
			$this->allProducts = ($request->getParameter('all_products')) ? true : false;
			$this->supervisor = $request->getParameter('supervisor');
			
			// Get results
			$this->labels = array();
			switch ( $this->productType ) {
				case 'strain':
					$this->transferInterval = $request->getParameter('transfer_interval');
					$this->cultureMedium = CultureMediumTable::getInstance()->find($request->getParameter('culture_medium_id'));
					
					if ( $this->allProducts ) {
						$this->labels = StrainTable::getInstance()->findAll();
					}
					else {
						$this->labels = StrainTable::getInstance()->find($this->productId);
					}
					break;
			}
			
			$this->createPdf($this->productType, $this->labels);
		}
	}
	
	/**
	 * Creates a PDF using wkhtmltopdf
	 *
	 * @param string $productType Type of product to create labels for
	 * @param Doctrine_Record | Doctrine Collection $labels Object or collection of objects that
	 * contains the information to create the labels
	 * 
	 * @return boolean False if something goes wrong. Otherwise the execution stops here
	 * 
	 * @author Eliezer Talon
	 * @version 2011-10-26
	 * @throws sfStopException
	*/
	protected function createPdf($productType = 'strain', $labels) {
		// Create empty PDF with default configuration
		$this->setLayout(false);
		$this->renderPartial('create_pdf');
		
		return sfView::NONE;
	  // Close and send PDF document	  
	  throw new sfStopException();
	}
	
}
