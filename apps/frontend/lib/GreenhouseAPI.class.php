<?php
/**
 * acm : Algae Culture Management (https://github.com/singularfactory/ACM)
 * Copyright 2012, Singular Factory <info@singularfactory.com>
 *
 * This file is part of ACM
 *
 * ACM is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ACM is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ACM.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright     Copyright 2012, Singular Factory <info@singularfactory.com>
 * @package       ACM.Frontend
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */
?>
<?php

/**
 * GreenhouseAPI actions class.
 *
 * @package ACM.Frontend
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
	const HttpInvalidBeaCode = 400;
	const HttpServerError = 500;

	// Error codes
	const RequestSuccess = 0;
	const InvalidRequestMethod = 1;
	const InvalidToken = 2;
	const InvalidTimestamp = 3;
	const InvalidJSON = 4;
	const ServerError = 5;
	const InvalidBeaCode = 6;

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
			case self::InvalidBeaCode:
				$message = 'Invalid BEA code';
				$exitStatus = self::HttpInvalidBeaCode;
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

	protected function validateBeaCode($code = '') {
		if ( preg_match('/^([Bb][Ee][Aa])?\s*(\d+)\s*[bB]?$/', $code, $matches) ) {
			return $matches[2];
		}
		return false;
	}

}
