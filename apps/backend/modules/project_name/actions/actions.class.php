<?php

require_once dirname(__FILE__).'/../lib/project_nameGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/project_nameGeneratorHelper.class.php';

/**
 * project_name actions.
 *
 * @package    bna_green_house
 * @subpackage project_name
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class project_nameActions extends autoProject_nameActions {
	public function executeDelete(sfWebRequest $request) {
		parent::executeDeleteIfNotUsed($request);
	}
	
	protected function executeBatchDelete(sfWebRequest $request) {
		parent::executeBatchDeleteIfNotUsed($request);
	}
}
