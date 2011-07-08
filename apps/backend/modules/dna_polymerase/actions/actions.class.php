<?php

require_once dirname(__FILE__).'/../lib/dna_polymeraseGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/dna_polymeraseGeneratorHelper.class.php';

/**
 * dna_polymerase actions.
 *
 * @package    bna_green_house
 * @subpackage dna_polymerase
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dna_polymeraseActions extends autoDna_polymeraseActions {
	public function executeDelete(sfWebRequest $request) {
		parent::executeDeleteIfNotUsed($request);
	}
	
	protected function executeBatchDelete(sfWebRequest $request) {
		parent::executeBatchDeleteIfNotUsed($request);
	}
}
