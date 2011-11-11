<?php

require_once dirname(__FILE__).'/../lib/maintenance_statusGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/maintenance_statusGeneratorHelper.class.php';

/**
* maintenance_status actions.
*
* @package    bna_green_house
* @subpackage maintenance_status
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class maintenance_statusActions extends autoMaintenance_statusActions {
	public function executeDelete(sfWebRequest $request) {
		parent::executeDeleteIfNotUsed($request);
	}

	protected function executeBatchDelete(sfWebRequest $request) {
		parent::executeBatchDeleteIfNotUsed($request);
	}
}
