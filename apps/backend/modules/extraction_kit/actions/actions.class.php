<?php

require_once dirname(__FILE__).'/../lib/extraction_kitGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/extraction_kitGeneratorHelper.class.php';

/**
 * extraction_kit actions.
 *
 * @package    bna_green_house
 * @subpackage extraction_kit
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class extraction_kitActions extends autoExtraction_kitActions {
	public function executeDelete(sfWebRequest $request) {
		parent::executeDeleteIfNotUsed($request);
	}
	
	protected function executeBatchDelete(sfWebRequest $request) {
		parent::executeBatchDeleteIfNotUsed($request);
	}
}
