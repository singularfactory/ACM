<?php

/**
 * default actions.
 *
 * @package    bna_green_house
 * @subpackage strain
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class defaultActions extends MyActions {

	/**
	 * Error page for page not found (404) error
	 */
	public function executeError404() { }
	
	/**
	 * Module disabled
	 *
	 */
	public function executeDisabled() { }

}