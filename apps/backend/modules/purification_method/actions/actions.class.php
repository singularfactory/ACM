<?php

require_once dirname(__FILE__).'/../lib/purification_methodGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/purification_methodGeneratorHelper.class.php';

/**
 * purification_method actions.
 *
 * @package    bna_green_house
 * @subpackage purification_method
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class purification_methodActions extends autoPurification_methodActions {
	public function executeDelete(sfWebRequest $request) {
		parent::executeDeleteIfNotUsed($request);
	}
	
	protected function executeBatchDelete(sfWebRequest $request) {
		parent::executeBatchDeleteIfNotUsed($request);
	}
}
