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
	
	protected $xmlErrors = false;
	
	protected function createEmptyXml() {
		// Clear previous XML errors
		$this->xmlErrors = false;
		
		// Load the XML document template
		libxml_use_internal_errors(true);
		$xml = simplexml_load_string($this->getPartial('xml_empty'));
		
		// Retrieve the messages in case of error
		if ( !$xml ) {
			$errors = libxml_get_errors();
			$separator = (count($errors)) ? '' : '';
			
			foreach( $errors as $error ) {
				$this->xmlErrors .= $error->message.$separator;
			}
			$this->xmlErrors = str_replace("\n", '', $this->xmlErrors);
		}
		
		return $xml;
	}
	
	public function executeIndex(sfWebRequest $request) {
		if ( !$this->validateRequestMethod($request, sfRequest::GET) ) {
			return $this->requestExitStatus(self::InvalidRequestMethod, 'This resource only admits GET requests');
		}
		
		if ( !$this->validateToken($request->getParameter('token')) ) {
			return $this->requestExitStatus(self::InvalidToken);
		}
		
		// Create an empty XML document
		$xml = $this->createEmptyXml();
		if ( $this->xmlErrors ) {
			return $this->requestExitStatus(self::ServerError, "The XML document could not be created ({$this->xmlErrors})");
		}
		
		return $this->requestExitStatus(self::RequestSuccess, $xml->asXML());
	}

}
