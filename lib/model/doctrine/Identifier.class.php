<?php

/**
 * Identifier
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Identifier extends BaseIdentifier {
	public function __toString() {
		return $this->getName().' '.$this->getSurname();
	}
	
	public function getNbStrains() {
		return Doctrine_Query::create()
			->from('Strain s')
			->where('s.identifier_id = ?', $this->getId())
			->count();
	}
	
	public function getNbPatentDeposits() {
		return Doctrine_Query::create()
			->from('PatentDeposit s')
			->where('s.identifier_id = ?', $this->getId())
			->count();
	}
	
	public function getNbMaintenanceDeposits() {
		return Doctrine_Query::create()
			->from('MaintenanceDeposit s')
			->where('s.identifier_id = ?', $this->getId())
			->count();
	}
	
}
