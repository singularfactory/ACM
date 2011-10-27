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
		$this->subject = $subject;
	}
	
	/**
	* Executes generate action
	*
	* @param sfRequest $request A request object
	*/
	public function executeGenerate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		
		// Validate form
		$this->form = new ReportForm();
		$this->form->bind($taintedValues);
		$this->subject = $request->getParameter('subject');
	
		if ( !$this->form->isValid() ) {
			$this->getUser()->setFlash('notice', 'The report cannot be generated with the information you have provided. Make sure everything is OK.');		
			$this->setTemplate('configure');
		}
		else {
			
		}
	}
	
}
