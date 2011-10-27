<?php

/**
* GreenhouseAPI actions class.
*
* @package    bna_green_house
* @subpackage frontend
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version		2011-10-27
*/
class GreenhouseAPI extends MyActions {
	
	// HTTP status codes
	const HttpRequestSuccess = 200;
	const HttpInvalidRequestMethod = 405;
	const HttpInvalidToken = 401;
	const HttpInvalidTimestamp = 400;
	const HttpInvalidJSON = 400;
	const HttpServerError = 500;
	
	// Error codes
	const RequestSuccess = 0;
	const InvalidRequestMethod = 1;
	const InvalidToken = 2;
	const InvalidTimestamp = 3;
	const InvalidJSON = 4;
	const ServerError = 5;
	
	protected function requestExitStatus($error = self::RequestSuccess, $response = 0) {
		switch ( $error ) {
			case self::InvalidRequestMethod:
				$message = 'Invalid request method_exists';
				$exitStatus = self::HttpInvalidRequestMethod;
				break;
			case self::InvalidToken:
				$message = 'Invalid token';
				$exitStatus = self::HttpInvalidToken;
				break;
			case self::InvalidTimestamp:
				$message = 'Invalid timestamp';
				$exitStatus = self::HttpInvalidTimestamp;
				break;
			case self::InvalidJSON:
				$message = 'Invalid JSON';
				$exitStatus = self::HttpInvalidJSON;
				break;
			case self::ServerError:
				$message = 'Server error';
				$exitStatus = self::HttpServerError;
				break;
			default:
				$exitStatus = self::HttpRequestSuccess;
				break;
		}
		
		if ( $error != self::RequestSuccess ) {
			$response = sprintf('%s: %s', $message, $response);
		}
		
		$this->getResponse()->setStatusCode($exitStatus);
		$this->getResponse()->setContent($response);
		return sfView::NONE;
	}
	
	protected function validateToken($token = null) {
		return (sfGuardUserTable::getInstance()->findOneByToken($token) != false);
	}
	
	protected function validateTimestamp($timestamp = null) {
		return date('Y-m-d H:i:s', $timestamp);
	}
	
	protected function validateRequestMethod(sfWebRequest $request = null, $method) {
		return $request->isMethod($method);
	}
	
	protected function validateJson($data = '') {
		return json_decode($data, true);
	}
		
}
