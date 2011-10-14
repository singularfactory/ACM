<?php

/**
 * CultureMedium
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class CultureMedium extends BaseCultureMedium {
	
	public function getCode() {
		$code = str_pad($this->getId(), 4, '0', STR_PAD_LEFT);
		
		return "BEA$code-cm";
	}
	
	public function getNbStrains() {
		return Doctrine_Query::create()
			->from('StrainCultureMedia s')
			->where('s.culture_medium_id = ?', $this->getId())
			->count();
	}
	
	public function getNbPatentDeposits() {
		return Doctrine_Query::create()
			->from('PatentDepositCultureMedia s')
			->where('s.culture_medium_id = ?', $this->getId())
			->count();
	}
	
	public function getNbMaintenanceDeposits() {
		return Doctrine_Query::create()
			->from('MaintenanceDepositCultureMedia s')
			->where('s.culture_medium_id = ?', $this->getId())
			->count();
	}
	
	public function getFormattedLink() {
		if ( $link = $this->_get('link') ) {
			return $link;
		}
		
		return sfConfig::get('app_no_data_message');
	}
	
	public function getFormattedIsPublic() {
		if ( $this->getIsPublic() ) {
			return 'yes';
		}
		return 'no';
	}
	
	public function getLink() {
		$link = $this->_get('link');
		
		if ( !empty($link) && !preg_match('/^https?:\/\//', $link) ) {
			return "http://$link";
		}
		
		return $link;
	}
	
	public function getDescriptionUrl() {
		$path = sfConfig::get('app_documents_dir').sfConfig::get('app_culture_media_dir');
		$filename = $this->getDescription();
		
		if ( empty($filename) ) {
			return null;
		}
		else {
			return "$path/$filename";
		}
	}
	
}
