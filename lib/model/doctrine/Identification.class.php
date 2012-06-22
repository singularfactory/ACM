<?php
/**
 * Model class
 *
 * acm : Algae Culture Management (https://github.com/singularfactory/ACM)
 * Copyright 2012, Singular Factory <info@singularfactory.com>
 *
 * This file is part of ACM
 *
 * ACM is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ACM is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ACM.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright     Copyright 2012, Singular Factory <info@singularfactory.com>
 * @package       ACM.Lib.Model
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */


/**
 * Identification
 *
 * @package ACM.Lib.Model
 * @since 1.0
 */
class Identification extends BaseIdentification {
	public function getCode() {
		return sprintf('BEA ID%s_%s',
			str_pad($this->getYearlyCount(), 2, '0', STR_PAD_LEFT),
			date('y', strtotime($this->getIdentificationDate()))
		);
	}

	public function getIdentificationDate() {
		if ( $date = $this->_get('identification_date') ) {
			return $this->formatDate($date);
		}
		else {
			return sfConfig::get('app_no_data_message');
		}
	}

	public function getFormattedPetitioner() {
		$petitioner = $this->getPetitioner();
		if (!$petitioner) {
			return sfConfig::get('app_no_data_message');
		}
		return sprintf('%s %s', $petitioner->getName(), $petitioner->getSurname());
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
