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
	
	public function getFullCode() {
		$code = str_pad($this->_get('code'), 4, '0', STR_PAD_LEFT);
		
		$axenicCode = '';
		if ( ! $this->getIsAxenic() ) {
			$axenicCode = 'B';
		}
		
		$cloneCode = '';
		if ( $cloneNumber = $this->getCloneNumber() ) {
			$cloneCode = "/$cloneNumber";
		}
		
		return "BEA$code$cloneCode$axenicCode";
	}
	
	public function getTaxonomicName() {
		return sprintf('%s %s %s', $this->getTaxonomicClass(), $this->getGenus(), $this->getSpecies());
	}
	
	public function getGenusAndSpecies() {
		return sprintf('%s %s', $this->getGenus(), $this->getSpecies());
	}
	
	public function getFormattedSampleCode() {
		if ( $this->getSample() ) {
			return $this->getSample()->getCode();
		}
		return sfConfig::get('app_no_data_message');
	}
			
	public function getNbCultureMedia() {
		return count($this->getCultureMedia());
	}
	
	public function getNbContainers() {
		return count($this->getContainers());
	}
	
	public function getNbDnaExtractions() {
		return Doctrine_Query::create()
			->from('DnaExtraction dna')
			->where('dna.strain_id = ?', $this->getId())
			->count();
	}
	
	public function getNbRelatives() {
		return Doctrine_Query::create()
			->from('StrainRelative sr')
			->where('sr.strain_id = ?', $this->getId())
			->count();
	}
	
	public function getNbAxenityTests() {
		return Doctrine_Query::create()
			->from('AxenityTest t')
			->where('t.strain_id = ?', $this->getId())
			->count();
	}
	
	public function getNbProjects() {
		return Doctrine_Query::create()
			->from('Project p')
			->where('p.strain_id = ?', $this->getId())
			->count();
	}
	
	public function getNbIsolations() {
		return Doctrine_Query::create()
			->from('Isolation i')
			->where('i.strain_id = ?', $this->getId())
			->count();
	}
	
	public function getNbPictures() {
		return Doctrine_Query::create()
			->from('StrainPicture sp')
			->where('sp.strain_id = ?', $this->getId())
			->count();
	}
	
	public function hasDna() {
		if ( count($this->getDnaExtractions()) > 0 ) {
			return true;
		}
		return false;
	}
	
	public function publicHasDna() {
		if ( count(DnaExtractionTable::getInstance()->findByIsPublicAndStrainId(1, $this->getId())) > 0 ) {
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
	
	public function getFormattedDeceased() {
		if ( $this->getDeceased() ) {
			return 'yes';
		}
		return 'no';
	}
	
	public function getFormattedInGCatalog() {
		if ( $this->getInGCatalog() ) {
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
	
	public function getPublicAliquots() {
		$aliquots = 0;
		foreach ($this->getDnaExtractions() as $dnaExtraction) {
			if ( $dnaExtraction->getIsPublic() ) {
				$aliquots += $dnaExtraction->getAliquots();
			}
			
		}
		
		return $aliquots;
	}
	
	public function getAliquots() {
		$aliquots = 0;
		foreach ($this->getDnaExtractions() as $dnaExtraction) {
			$aliquots += $dnaExtraction->getAliquots();
		}
		
		return $aliquots;
	}
	
	public function getDnaAmount() {
		return $this->getAliquots();
	}
	
	public function getPublicDnaAmount() {
		return $this->getPublicAliquots();
	}
	
	public function getFormattedIsolationDate() {
		return $this->formatDate($this->_get('isolation_date'));
	}
	
	public function getFormattedContainer() {
		if ( $container = $this->getContainer()->getName() ) {
			return $container;
		}
		return sfConfig::get('app_no_data_message');
	}
	
	public function getNbIsolators() {
		return count($this->getIsolators());
	}
	
	public function getFormattedIsolators() {
		$isolators = '';
		foreach ( $this->getIsolators() as $isolator ) {
			$name = $isolator->getName();
			$surname = $isolator->getSurname();
			$isolators .= "$name $surname, ";
		}
		
		if ( empty($isolators) ) {
			return sfConfig::get('app_no_data_message');
		}
		else {
			return preg_replace('/, $/', '', $isolators);
		}
	}
	
	public function getFormattedSupervisor() {
		if ( !$this->getSupervisorId() ) {
			return sfConfig::get('app_no_data_message');
		}
		
		return $this->getSupervisor();
	}
}
