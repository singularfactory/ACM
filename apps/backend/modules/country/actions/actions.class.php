<?php

require_once dirname(__FILE__).'/../lib/countryGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/countryGeneratorHelper.class.php';

/**
 * country actions.
 *
 * @package    bna_green_house
 * @subpackage country
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class countryActions extends autoCountryActions {
	public function executeDelete(sfWebRequest $request) {
		parent::executeDeleteIfNotUsed($request);
	}
	
	protected function executeBatchDelete(sfWebRequest $request) {
		parent::executeBatchDeleteIfNotUsed($request);
	}
}
