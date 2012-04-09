<?php

require_once dirname(__FILE__).'/../lib/taxonomic_orderGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/taxonomic_orderGeneratorHelper.class.php';

/**
 * taxonomic_order actions.
 *
 * @package    bna_green_house
 * @subpackage taxonomic_order
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class taxonomic_orderActions extends autoTaxonomic_orderActions {
	public function executeDelete(sfWebRequest $request) {
		parent::executeDeleteIfNotUsed($request);
	}
	
	protected function executeBatchDelete(sfWebRequest $request) {
		parent::executeBatchDeleteIfNotUsed($request);
	}
}
