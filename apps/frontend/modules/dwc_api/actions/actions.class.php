<?php

/**
* dwc_api actions.
*
* @package    bna_green_house
* @subpackage dwc_api
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class dwc_apiActions extends GreenhouseAPI {
	
	public function executeIndex(sfWebRequest $request) {
		if ( !$this->validateRequestMethod($request, sfRequest::GET) ) {
			return $this->requestExitStatus(self::InvalidRequestMethod, 'This resource only admits GET requests');
		}
		
		if ( !$this->validateToken($request->getParameter('token')) ) {
			return $this->requestExitStatus(self::InvalidToken);
		}
		
		return $this->requestExitStatus(self::RequestSuccess, 'Darwin Core');
	}

}
