<?php

/**
* MaintenanceDeposit
* 
* This class has been auto-generated by the Doctrine ORM Framework
* 
* @package    bna_green_house
* @subpackage model
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
*/
class MaintenanceDeposit extends BaseMaintenanceDeposit {
	
	public function getCode() {
		return $this->getDepositorCode();
	}
	
	public function getNbCultureMedia() {
		return MaintenanceDepositCultureMediaTable::getInstance()->createQuery('cm')
			->where('cm.maintenance_deposit_id = ?', $this->getId())
			->count();
	}
	
	public function getNbCollectors() {
		return MaintenanceDepositCollectorsTable::getInstance()->createQuery('c')
			->where('c.maintenance_deposit_id = ?', $this->getId())
			->count();
	}
	
	public function getNbIsolators() {
		return MaintenanceDepositIsolatorsTable::getInstance()->createQuery('i')
			->where('i.maintenance_deposit_id = ?', $this->getId())
			->count();
	}
	
	public function getNbRelatives() {
		return MaintenanceDepositRelativeTable::getInstance()->createQuery('r')
			->where('r.maintenance_deposit_id = ?', $this->getId())
			->count();
	}
		
	public function hasDna() {
		if ( $this->_get('has_dna') ) {
			return true;
		}
		return false;
	}
	
	public function isAxenic() {
		if ( $this->_get('is_axenic') ) {
			return true;
		}
		return false;
	}
	
	public function getFormattedEnvironment() {
		if ( $this->getEnvironment()->exists() ) {
			return $this->getEnvironment()->getName();
		}
		return sfConfig::get('app_no_data_message');
	}
	
	public function getFormattedHabitat() {
		if ( $this->getHabitat()->exists() ) {
			return $this->getHabitat()->getName();
		}
		return sfConfig::get('app_no_data_message');
	}
	
	public function getFormattedHasDna() {
		if ( $this->hasDna() ) {
			return 'yes';
		}
		return 'no';
	}
	
	public function getFormattedIsEpitype() {
		if ( $this->getIsEpitype() ) {
			return 'yes';
		}
		return 'no';
	}
	
	public function getFormattedIsAxenic() {
		if ( $this->isAxenic() ) {
			return 'yes';
		}
		return 'no';
	}
	
	public function getFormattedCitations() {
		if ( $citations = $this->_get('citations') ) {
			return $citations;
		}
		return sfConfig::get('app_no_data_message');
	}
	
	public function getFormattedViabilityTest() {
		if ( $test = $this->_get('viability_test') ) {
			return $test;
		}
		return sfConfig::get('app_no_data_message');
	}
	
	public function getFormattedTransferInterval() {
		if ( $transferInterval = $this->_get('transfer_interval') ) {
			return "$transferInterval weeks";
		}
		return sfConfig::get('app_no_data_message');
	}
	
	public function getFormattedObservation() {
		if ( $observation = $this->_get('observation') ) {
			return $observation;
		}
		return sfConfig::get('app_no_data_message');
	}
	
	public function getDepositionDate() {
		if ( $date = $this->_get('deposition_date') ) {
			return $this->formatDate($date);
		}
		else {
			return sfConfig::get('app_no_data_message');
		}
	}
	
	public function getIsolationDate() {
		if ( $date = $this->_get('isolation_date') ) {
			return $this->formatDate($date);
		}
		else {
			return sfConfig::get('app_no_data_message');
		}
	}
	
	public function getCollectionDate() {
		if ( $date = $this->_get('collection_date') ) {
			return $this->formatDate($date);
		}
		else {
			return sfConfig::get('app_no_data_message');
		}
	}
	
	public function getMf1DocumentUrl() {
		$path = sfConfig::get('app_documents_dir').sfConfig::get('app_maintenance_deposit_dir');
		$filename = $this->getMf1Document();
		
		if ( empty($filename) ) {
			return null;
		}
		else {
			return "$path/$filename";
		}
	}
	
}
