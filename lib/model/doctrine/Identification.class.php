<?php

/**
 * Identification
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Identification extends BaseIdentification {
	public function getIdentificationDate() {
		if ( $date = $this->_get('identification_date') ) {
			return $this->formatDate($date);
		}
		else {
			return sfConfig::get('app_no_data_message');
		}
	}
	
	public function getFormattedPetitioner() {
		$petitioner = $this->_get('petitioner');
		if ( empty($petitioner) ) {
			return sfConfig::get('app_no_data_message');
		}
		return $petitioner;
	}
	
	public function getRequestDocumentUrl() {
		$path = sfConfig::get('app_documents_dir').sfConfig::get('app_identification_dir');
		$filename = $this->getRequestDocument();
		
		if ( empty($filename) ) {
			return null;
		}
		else {
			return "$path/$filename";
		}
	}
	
	public function getReportDocumentUrl() {
		$path = sfConfig::get('app_documents_dir').sfConfig::get('app_identification_dir');
		$filename = $this->getReportDocument();
		
		if ( empty($filename) ) {
			return null;
		}
		else {
			return "$path/$filename";
		}
	}

	public function getFormattedMicroscopyIdentification() {
		$value = $this->_get('microscopy_identification');
		if ( empty($value) ) {
			return sfConfig::get('app_no_data_message');
		}
		return $value;
	}

	public function getFormattedMolecularIdentification() {
		$value = $this->_get('molecular_identification');
		if ( empty($value) ) {
			return sfConfig::get('app_no_data_message');
		}
		return $value;
	}
}
