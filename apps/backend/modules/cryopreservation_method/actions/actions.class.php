<?php

require_once dirname(__FILE__).'/../lib/cryopreservation_methodGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/cryopreservation_methodGeneratorHelper.class.php';

/**
 * cryopreservation_method actions.
 *
 * @package    bna_green_house
 * @subpackage cryopreservation_method
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cryopreservation_methodActions extends autoCryopreservation_methodActions {
	public function executeDelete(sfWebRequest $request) {
		parent::executeDeleteIfNotUsed($request);
	}
	
	protected function executeBatchDelete(sfWebRequest $request) {
		parent::executeBatchDeleteIfNotUsed($request);
	}
}
