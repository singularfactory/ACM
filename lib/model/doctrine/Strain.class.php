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
 * Strain
 *
 * @package ACM.Lib.Model
 * @since 1.0
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

	public function getNbProperties() {
		return StrainPropertiesTable::getInstance()->createQuery('c')->where('c.strain_id = ?', $this->getId())->count();
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

	public function getNbPotentialUsages() {
		$query = StrainTaxonomyTable::getInstance()->createQuery('s')
			->distinct()
			->where('s.taxonomic_class_id = ?', $this->getTaxonomicClassId())
			->andWhere('s.genus_id = ?', $this->getGenusId());

		$species = $this->getSpeciesId();
		if ($species != null) {
			$query = $query->andWhere('s.species_id = ?', $this->getSpeciesId());
		} else {
			$query = $query->andWhere('s.species_id IS NULL');
		}
		return $query->count();
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
		$aliquots = $this->getPublicAliquots();
		$code = $this->_get('code');

		$descendants = Doctrine_Query::create()->from('Strain s')->where('s.code = ?', $code)->execute();
		foreach ($descendants as $descendant) {
			$aliquots += $descendant->getAliquots();
		}

		if ($aliquots > 0) {
			return true;
		}
		return false;
	}

	public function publicHasDna() {
		if ( $this->getPublicAliquots() > 0 ) {
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
		if ($this->hasDna()) {
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

	public function getFormattedCultureMedium() {
		if ( $cm = $this->getCultureMedium()->getName() ) {
			return $cm;
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

	public function getFormattedSupervisorWithInitials() {
		if ( !$this->getSupervisorId() ) {
			return sfConfig::get('app_no_data_message');
		}

		return $this->getSupervisor()->getFullNameWithInitials();
	}

	public function getSupervisorInitials() {
		if ( !$this->getSupervisorId() ) {
			return '';
		}

		return $this->getSupervisor()->getInitials();
	}

	public function getFormattedTemperature() {
		if ( ($temperature = $this->_get('temperature')) > 0 ) {
			return $temperature.' '.sfConfig::get('app_temperature_unit');
		}
		else {
			return sfConfig::get('app_no_data_message');
		}
	}

	public function getFormattedPhotoperiod() {
		if ( ($photoperiod = $this->_get('photoperiod')) > 0 ) {
			return $photoperiod;
		}
		else {
			return sfConfig::get('app_no_data_message');
		}
	}

	public function getFormattedIrradiation() {
		if ( ($irradiation = $this->_get('irradiation')) > 0 ) {
			return $irradiation;
		}
		else {
			return sfConfig::get('app_no_data_message');
		}
	}

	public function getFormattedTaxonomicOrder() {
		if ( $name = $this->getTaxonomicOrder()->getName() ) {
			return $name;
		}
		return sfConfig::get('app_no_data_message');
	}

	public function getFormattedKingdom() {
		if ( $name = $this->getKingdom()->getName() ) {
			return $name;
		}
		return sfConfig::get('app_no_data_message');
	}

	public function getFormattedSubkingdom() {
		if ( $name = $this->getSubkingdom()->getName() ) {
			return $name;
		}
		return sfConfig::get('app_no_data_message');
	}

	public function getFormattedPhylum() {
		if ( $name = $this->getPhylum()->getName() ) {
			return $name;
		}
		return sfConfig::get('app_no_data_message');
	}

	public function getFormattedFamily() {
		if ( $name = $this->getTaxonomicOrder()->getName() ) {
			return $name;
		}
		return sfConfig::get('app_no_data_message');
	}

	public function getSequencedGenes() {
		$sequences = DnaSequenceTable::getInstance()->createQuery('seq')
			->select('seq.id, seq.gen')
			->leftJoin("seq.Pcr pcr")
			->leftJoin("pcr.DnaExtraction dna")
			->leftJoin("dna.Strain s")
			->where("s.id = ?", $this->getId())
			->andWhere("seq.worked = ?", 1)
			->execute();

		$genes = array();
		foreach ($sequences as $sequence) {
			$genes[] = $sequence->gen;
		}
		return $genes;
	}

	public function getPhylogeneticTreeThumbnail() {
		$file = sfConfig::get('app_pictures_dir')
			.sfConfig::get('app_strain_pictures_dir').
			sfConfig::get('app_thumbnails_dir').
			'/'.$this->getPhylogeneticTree();
		return preg_replace('/\.[\-\w]+$/', sfConfig::get('app_thumbnail_extension'), $file);
	}

	public function getPhylogeneticTreePath() {
		return sfConfig::get('app_pictures_dir').sfConfig::get('app_strain_pictures_dir').'/'.$this->getPhylogeneticTree();
	}

	public function getNbCryopreservations() {
		return CryopreservationTable::getInstance()->createQuery('c')
			->where('c.strain_id = ?', $this->getId())
			->count();
	}

	public function isCryopreserved() {
		return $this->getNbCryopreservations() > 0;
	}

	public function getFormattedMaintenanceStatusList() {
		$statuses = array();
		foreach ($this->getMaintenanceStatus() as $status) {
			$statuses[] = $status;
		}
		if ($this->isCryopreserved()) {
			$statuses[] = 'Cryopreserved';
		}
		return implode(', ', $statuses);
	}

	public function getInternalCode() {
		$name = $this->getSupervisorInitials().substr($this->getTaxonomicClass(),0 ,3).$this->getTransferInterval();
		if ( $name ) {
			return $name;
		}
		return sfConfig::get('app_no_data_message');
	}

	public function getPotentialUsages() {
		$query = StrainTaxonomyTable::getInstance()->createQuery('s')
			->where('s.taxonomic_class_id = ?', $this->getTaxonomicClassId())
			->where('s.genus_id = ?', $this->getGenusId());

		$species = $this->getSpeciesId();
		if ($species != null) {
			$query = $query->andWhere('s.species_id = ?', $this->getSpeciesId());
		} else {
			$query = $query->andWhere('s.species_id IS NULL');
		}

		$taxonomy = $query->fetchOne();
		if ($taxonomy) {
			return $taxonomy->getPotentialUsages();
		} else {
			return array();
		}
	}
}
