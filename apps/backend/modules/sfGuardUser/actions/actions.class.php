<?php

require_once(sfConfig::get('sf_plugins_dir').'/sfDoctrineGuardPlugin/modules/sfGuardUser/lib/sfGuardUserGeneratorConfiguration.class.php');
require_once(sfConfig::get('sf_plugins_dir').'/sfDoctrineGuardPlugin/modules/sfGuardUser/lib/sfGuardUserGeneratorHelper.class.php');

/**
 * sfGuardUser actions.
 *
 * @package    bna_green_house
 * @subpackage sfGuardUser
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardUserActions extends autoSfGuardUserActions {
	public function executeDelete(sfWebRequest $request) {
		parent::executeDeleteIfNotUsed($request);
	}
	
	protected function executeBatchDelete(sfWebRequest $request) {
		parent::executeBatchDeleteIfNotUsed($request);
	}
}
