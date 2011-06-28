<?php

/**
 * Strain
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Strain extends BaseStrain {
	public function getNumber() {
		$code = str_pad($this->getId(), 4, '0', STR_PAD_LEFT);
		
		$axenicCode = '';
		if ( ! $this->getIsAxenic() ) {
			$axenicCode = 'B';
		}
		
		return 'BEA'.$code.$axenicCode;
	}
			
	public function getNbGrowthMediums() {
		return count($this->getGrowthMediums());
	}
	
	public function getNbRelatives() {
		return Doctrine_Query::create()
			->from('StrainRelative sr')
			->where('sr.strain_id = ?', $this->getId())
			->count();
	}
	
	public function getNbPictures() {
		return Doctrine_Query::create()
			->from('StrainPicture sp')
			->where('sp.strain_id = ?', $this->getId())
			->count();
	}
	
	public function hasDna() {
		if ( count($this->getDna()) > 0 ) {
			return true;
		}
		return false;
	}
	
	public function getFormattedIsEpitype() {
		if ( $this->getIsEpitype() ) {
			return 'yes';
		}
		return 'no';
	}
	
	public function getFormattedIsAxenic() {
		if ( $this->getIsAxenic() ) {
			return 'yes';
		}
		return 'no';
	}
	
	public function getFormattedHasDna() {
		if ( $this->hasDna() ) {
			return 'yes';
		}
		return 'no';
	}
	
	public function getFormattedIsPublic() {
		if ( $this->getIsPublic() ) {
			return 'yes';
		}
		return 'no';
	}
	
	public function getFormattedCitations() {
		if ( $citations = $this->getCitations() ) {
			return $citations;
		}
		else {
			return sfConfig::get('app_no_data_message');
		}
	}
	
	public function getFormattedTransferInterval() {
		if ( $transferInterval = $this->getTransferInterval() ) {
			return $transferInterval;
		}
		else {
			return sfConfig::get('app_no_data_message');
		}
	}
	
	public function getFormattedObservation() {
		if ( $observation = $this->getObservation() ) {
			return $observation;
		}
		else {
			return sfConfig::get('app_no_data_message');
		}
	}
	
}
