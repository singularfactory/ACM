<?php
/**
 * DnaExtraction class
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
 * DnaExtraction
 *
 * @package ACM.Lib.Model
 * @since 1.0
 */
class DnaExtraction extends BaseDnaExtraction {
	public function getCode() {
		return $this->getStrain()->getFullCode()."DNA";
	}

	public function getNbPcr() {
		if ($this->getPcr()) {
			return count($this->getPcr());
		}

		return Doctrine_Query::create()
			->from('PCR pcr')
			->where('pcr.dna_extraction_id = ?', $this->getId())
			->count();
	}

	public function getFormattedConcentration() {
		if ( ($concentration = $this->_get('concentration')) > 0 ) {
			return $concentration.' '.sfConfig::get('app_concentration_unit');
		}
		else {
			return sfConfig::get('app_no_data_message');
		}
	}

	public function getAliquots() {
		if ($aliquots = $this->_get('aliquots')) {
			return $aliquots;
		}
		return 0;
	}

	public function getFormatted260280Ratio() {
		if ( $ratio = $this->_get('260_280_ratio') ) {
			return $ratio;
		}
		return sfConfig::get('app_no_data_message');
	}

	public function getFormatted260230Ratio() {
		if ( $ratio = $this->_get('260_230_ratio') ) {
			return $ratio;
		}
		return sfConfig::get('app_no_data_message');
	}
        
	public function getFormattedPreservation() {
		if ( $preservation = $this->_get('preservation') ) {
			return $preservation;
		}
		return sfConfig::get('app_no_data_message');
	}

	public function getFormattedIsPublic() {
		if ( $this->_get('is_public') == 0 ) {
			return 'no';
		} else {
			return 'yes';
		}
	}

	public function getFormattedAliquots() {
		if ( ($aliquots = $this->_get('aliquots')) > 0 ) {
			return "yes ($aliquots)";
		} else {
			return sfConfig::get('app_no_data_message');
		}
	}

	public function getFormattedGenbankLink() {
		if ( $link = $this->_get('genbank_link') ) {
			return $link;
		}
		return sfConfig::get('app_no_data_message');
	}

	public function aliquotsAreEditable() {
		return DnaExtractionTable::getInstance()->createQuery('e')
			->leftJoin('e.Pcr pcr')
			->where('pcr.dna_extraction_id = ?', $this->getId())
			->andWhere('pcr.can_be_sequenced = ?', 1)
			->count() > 0;
	}

	public function hasDnaSequence() {
		$result = DnaExtractionTable::getInstance()->createQuery('d')
			->select('count(s.id) as dna_sequence_count')
			->leftJoin('d.Pcr p')
			->leftJoin('p.Sequence s')
			->where('d.id = ?', $this->getId())
			->fetchOne();

		return $result->dna_sequence_count > 0;
	}

	public function getFormattedHasDnaSequence() {
		return $this->hasDnaSequence() ? 'yes' : 'no';
	}

	public function getFormattedArrivalDate() {
		if ($arrivalDate = $this->_get('arrival_date')) {
			return $this->formatFriendlyDate($arrivalDate, false);
		}

		return sfConfig::get('app_no_data_message');
	}

	public function getFormattedExtractionDate() {
		if ( $extractionDate = $this->_get('extraction_date') ) {
			return $this->formatFriendlyDate($extractionDate, false);
		}

		return sfConfig::get('app_no_data_message');
	}

	public function canBePublished() {
		return DnaExtractionTable::getInstance()->createQuery('e')
			->leftJoin('e.Pcr pcr')
			->where('pcr.dna_extraction_id = ?', $this->getId())
			->andWhere('pcr.can_be_sequenced = ?', 1)
			->count() > 0;
	}
        
        public function getGenes() {
		if ($genes = $this->_get('genes')) {
			return $genes;
		}
		return "-";
	}
}
