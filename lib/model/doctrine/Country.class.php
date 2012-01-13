<?php
/**
 * Country
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class Country extends BaseCountry {
	
	public function getNbLocations() {
		return Doctrine_Query::create()
			->from('Location l')
			->where('l.country_id = ?', $this->getId())
			->count();
	}
	
	public function getNbRegions() {
		return Doctrine_Query::create()
			->from('Region r')
			->where('r.country_id = ?', $this->getId())
			->count();
	}
	
}
