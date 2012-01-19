<?php

require_once dirname(__FILE__).'/../lib/glossary_termGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/glossary_termGeneratorHelper.class.php';

/**
 * glossary_term actions.
 *
 * @package    bna_green_house
 * @subpackage glossary_term
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class glossary_termActions extends autoGlossary_termActions {
	public function executeDelete(sfWebRequest $request) {
		parent::executeDeleteIfNotUsed($request);
	}
	
	protected function executeBatchDelete(sfWebRequest $request) {
		parent::executeBatchDeleteIfNotUsed($request);
	}
}
