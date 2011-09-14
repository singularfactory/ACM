<?php

require_once dirname(__FILE__).'/../lib/containerGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/containerGeneratorHelper.class.php';

/**
 * container actions.
 *
 * @package    bna_green_house
 * @subpackage container
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class containerActions extends autoContainerActions {
	public function executeDelete(sfWebRequest $request) {
		parent::executeDeleteIfNotUsed($request);
	}
	
	protected function executeBatchDelete(sfWebRequest $request) {
		parent::executeBatchDeleteIfNotUsed($request);
	}
}