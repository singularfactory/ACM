<?php

/**
 * Pcr
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Pcr extends BasePcr {
	
	public function getNbGel() {
		return Doctrine_Query::create()
			->from('PcrGel gel')
			->where('gel.pcr_id = ?', $this->getId())
			->count();
	}
	
	public function getConcentration() {
		if ( $concentration = $this->_get('concentration') ) {
			return $concentration;
		}
		
		return '0.0';
	}
	
	public function getFormattedConcentration() {
		return $this->getConcentration().' '.sfConfig::get('app_concentration_unit');
	}
	
	public function get260280Ratio() {
		if ( $ratio = $this->_get('260_280_ratio') ) {
			return $ratio;
		}
		return '0.0';
	}
	
	public function get260230Ratio() {
		if ( $ratio = $this->_get('260_230_ratio') ) {
			return $ratio;
		}
		return '0.0';
	}
	
	public function getFormattedCanBeSequenced() {
		if ( $this->_get('can_be_sequenced') == 0 ) {
			return 'no';
		}
		else {
			return 'yes';
		}
	}	
}
