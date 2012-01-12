<?php

require_once dirname(__FILE__).'/../lib/location_categoryGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/location_categoryGeneratorHelper.class.php';

/**
 * location_category actions.
 *
 * @package    bna_green_house
 * @subpackage location_category
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class location_categoryActions extends autoLocation_categoryActions {
	public function executeDelete(sfWebRequest $request) {
		parent::executeDeleteIfNotUsed($request);
	}
	
	protected function executeBatchDelete(sfWebRequest $request) {
		parent::executeBatchDeleteIfNotUsed($request);
	}
}
