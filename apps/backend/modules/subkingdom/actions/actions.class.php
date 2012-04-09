<?php

require_once dirname(__FILE__).'/../lib/subkingdomGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/subkingdomGeneratorHelper.class.php';

/**
 * subkingdom actions.
 *
 * @package    bna_green_house
 * @subpackage subkingdom
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class subkingdomActions extends autoSubkingdomActions {
	public function executeDelete(sfWebRequest $request) {
		parent::executeDeleteIfNotUsed($request);
	}
	
	protected function executeBatchDelete(sfWebRequest $request) {
		parent::executeBatchDeleteIfNotUsed($request);
	}
}
