<?php

/**
 * Region
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    bna_green_house
 * @subpackage frontend
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class Region extends BaseRegion {
	public function getNbLocations() {
		return Doctrine_Query::create()
			->from('Location l')
			->where('l.region_id = ?', $this->getId())
			->count();
	}
	
	public function getNbIslands() {
		return Doctrine_Query::create()
			->from('Island i')
			->where('i.region_id = ?', $this->getId())
			->count();
	}
	
	public function __toString() {
	    return $this->getName();
	}
}
