<?php

require_once dirname(__FILE__).'/../lib/familyGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/familyGeneratorHelper.class.php';

/**
 * family actions.
 *
 * @package    bna_green_house
 * @subpackage family
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class familyActions extends autoFamilyActions {
	public function executeDelete(sfWebRequest $request) {
		parent::executeDeleteIfNotUsed($request);
	}
	
	protected function executeBatchDelete(sfWebRequest $request) {
		parent::executeBatchDeleteIfNotUsed($request);
	}
}
