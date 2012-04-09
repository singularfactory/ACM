<?php

require_once dirname(__FILE__).'/../lib/phylumGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/phylumGeneratorHelper.class.php';

/**
 * phylum actions.
 *
 * @package    bna_green_house
 * @subpackage phylum
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class phylumActions extends autoPhylumActions {
	public function executeDelete(sfWebRequest $request) {
		parent::executeDeleteIfNotUsed($request);
	}
	
	protected function executeBatchDelete(sfWebRequest $request) {
		parent::executeBatchDeleteIfNotUsed($request);
	}
}
