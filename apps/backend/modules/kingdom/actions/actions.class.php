<?php

require_once dirname(__FILE__).'/../lib/kingdomGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/kingdomGeneratorHelper.class.php';

/**
 * kingdom actions.
 *
 * @package    bna_green_house
 * @subpackage kingdom
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class kingdomActions extends autoKingdomActions {
	public function executeDelete(sfWebRequest $request) {
		parent::executeDeleteIfNotUsed($request);
	}
	
	protected function executeBatchDelete(sfWebRequest $request) {
		parent::executeBatchDeleteIfNotUsed($request);
	}
}
