<?php
/**
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
 * @package       ACM.Frontend
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */

/**
 * MyActions actions class.
 *
 * @package ACM.Frontend
 * @subpackage frontend
 */
class MyActions extends sfActions {
	/**
	 * paginationOptions
	 *
	 * @var array
	 */
	protected $paginationOptions = array(
		'sort_direction' => 'asc',
		'sort_column' => 'name',
		'init' => true,
	);

	/**
	 * mainAlias
	 *
	 * @var string
	 */
	protected $mainAlias = 'sf_main_alias';

	/**
	 * relatedAlias
	 *
	 * @var string
	 */
	protected $relatedAlias = 'sf_related_alias';

	/**
	 * _processFilterConditions
	 *
	 * @param sfWebRequest $request
	 * @param $module
	 * @return array
	 */
	protected function _processFilterConditions(sfWebRequest $request, $module) {
		$this->groupBy = '';
		$this->filters = array();
		$filters = array();
		if ($request->isMethod(sfRequest::POST)) {
			$filters = $request->getPostParameters();
			$filters = $filters[$module];
			$this->getUser()->setAttribute("$module.index_filters", $filters);
		} elseif ($request->hasParameter('page') || $request->hasParameter('all')) {
			$filters = 	$this->getUser()->getAttribute("$module.index_filters");
		} else {
			$this->getUser()->setAttribute("$module.index_filters", null);
		}
		return $filters;
	}

	/**
	 * buildPagination
	 *
	 * @param sfWebRequest $request Request made from page
	 * @param string $table Name of the table to paginate
	 * @param array $options Options to configure the pagination
	 * @return sfDoctrinePager
	 */
	protected function buildPagination(sfWebRequest $request, $table, array $options = array()) {
		// Merge default options with requested options
		foreach ($options as $key => $value) {
			if ( $value !== null && (!empty($value) || is_bool($value)) ) {
				$this->paginationOptions[$key] = $value;
			}
		}

		// Initiate a pager
		$pager = new sfDoctrinePager($table, sfConfig::get('app_max_list_items'));

		// Set sort direction
		if ( $request->getParameter('sort_direction') ) {
			$this->sortDirection = $request->getParameter('sort_direction');
		}
		else {
			$this->sortDirection = $this->paginationOptions['sort_direction'];
		}

		// Set sort columns
		$query = Doctrine::getTable($table)->createQuery($this->mainAlias);
		if ( $sort_column = $request->getParameter('sort_column') ) {
			$this->sortColumn = $sort_column;

			if ( preg_match('/^(\w+\.(\w+\.)*)(\w+)$/', $sort_column, $matches) ) {
				$relations = preg_replace('/\.$/', '', $matches[1]);
				$relatedColumn = $matches[3];
				$pager->setQuery($query->leftJoin("{$this->mainAlias}.$relations {$this->relatedAlias}")->orderBy("{$this->relatedAlias}.$relatedColumn ".$this->sortDirection));
			}
			else {
				$pager->setQuery($query->orderBy("{$this->mainAlias}.$sort_column ".$this->sortDirection));
			}
		}
		else {
			$this->sortColumn = $this->paginationOptions['sort_column'];
			$pager->setQuery($query->orderBy("{$this->mainAlias}.{$this->paginationOptions['sort_column']} ".$this->sortDirection));
		}

		$pager->setPage($request->getParameter('page', 1));

		if ($this->paginationOptions['init']) {
			$pager->init();
		}

		// Set results limit
		if ($request->hasParameter('all')) {
			$pager->setMaxPerPage(Doctrine::getTable($table)->count());
			$this->allResults = true;
		} else {
			$this->allResults = false;
		}

		return $pager;
	}

	/**
	 * mainAlias
	 *
	 * @return string
	 */
	protected function mainAlias() {
		return $this->mainAlias;
	}

	/**
	 * relatedAlias
	 *
	 * @return string
	 */
	protected function relatedAlias() {
		return $this->relatedAlias;
	}

	/**
	 * Executes an application defined process prior to execution of this sfAction object.
	 */
	public function preExecute() {
		$action = $this->getActionName();
		if ($action !== 'index' && $action !== 'exportIndexAsCsv') {
			$module = $this->getModuleName();
			$this->getUser()->setAttribute("$module.index_filters", null);
		}
	}

	public function executeExportIndexAsCsv(sfWebRequest $request) {
		$module = $this->getModuleName();

		$filters = $this->getUser()->getAttribute("$module.index_filters");
		if ($module === 'potential_usage') {
			$filters = $this->getUser()->getAttribute("strain_taxonomy.index_filters");
		}

		$csv = new Excel();
		$table = sprintf('%sTable', sfInflector::camelize($module));
		if ($module === 'potential_usage') {
			$table = 'StrainTaxonomyTable';
		}
		$query = call_user_func(array($table, 'getInstance'));
		$query = $query->createQuery('m')->select("m.*")->where('1=1');

		switch ($module) {
		case 'location':
			$csv->setHeader(array('Name', 'Country', 'Region', 'Island', 'Samples', 'Strains'));
			foreach ($filters as $filter => $value) {
				if ($filter !== 'group_by' && !empty($value)) {
					if ($filter === 'name') {
						$query = $query->andWhere("m.$filter LIKE ?", "%$value%");
					} else {
						$query = $query->andWhere("m.$filter = ?", $value);
					}
				}
			}
			break;

		case 'sample':
			$csv->setHeader(array('Code', 'Location', 'Collectors', 'Date', 'Strains'));
			foreach ($filters as $filter => $value) {
				if ($filter !== 'group_by' && !empty($value)) {
					if ($filter === 'location_details') {
						$query = $query->andWhere("m.$filter LIKE ?", "%$value%");
					} elseif ($filter === 'id') {
						preg_match('/^(\d{1,4}).*$/', $value, $matches);
						$query = $query->andWhere("m.$filter = ?", $matches[1]);
					} else {
						$query = $query->andWhere("m.$filter = ?", $value);
					}
				}
			}
			break;

		case 'strain':
			$csv->setHeader(array('Code', 'Name', 'Sample', 'Has DNA', 'Is public?', 'Supervisor'));
			foreach ($filters as $filter => $value) {
				if ($filter !== 'group_by' && !empty($value)) {
					if ($filter === 'id') {
						preg_match('/^[Bb]?[Ee]?[Aa]?\s*(\d{1,4})\s*[bB]?.*$/', $value, $matches);
						$query = $query->andWhere("m.code = ?", $matches[1]);
					} elseif ($filter === 'maintenance_status_id' || $filter === 'culture_medium_id') {
						$intermediateModel = ($filter == 'culture_medium_id') ? 'CultureMedia' : 'MaintenanceStatus';
						$query = $query->andWhere("m.Strain$intermediateModel.$filter = ?", $value);
					} elseif (in_array($filter, array('is_epitype', 'is_axenic', 'deceased', 'is_public'))) {
						if ($value >= 0) {
							$query = $query->andWhere("m.$filter = ?", $value - 1);
						}
					} else {
						$query = $query->andWhere("m.$filter = ?", $value);
					}
				}
			}
			break;

		case 'dna_extraction':
			$csv->setHeader(array('Number', 'Class', 'Name', 'Extraction date', 'Extraction kit', 'Concentration', 'DNA bank', 'PCR', 'Has sequences?'));
			$query = $query
				->leftJoin("m.Strain s")
				->leftJoin("m.ExtractionKit c")
				->leftJoin("s.TaxonomicClass tc")
				->leftJoin("s.Genus g")
				->leftJoin("s.Species sp")
				->where('1=1');

			foreach ($filters as $filter => $value) {
				if ($filter !== 'group_by' && !empty($value)) {

					if ($filter === 'strain_id') {
						preg_match('/^\s*[Bb]?[Ee]?[Aa]?\s*(\d{1,4})\s*[bB]?\s*_?(\d*).*$/', $value, $matches);
						if (isset($matches[1])) {
							$id = ltrim($matches[1], '0');
							$query = $query->andWhere("m.$filter = ?", $id);
						}
					} else if ($filter === 'taxonomic_class_id' || $filter === 'genus_id') {
						$query = $query->andWhere("s.$filter = ?", $value);
					} else if ($filter === 'aliquots') {
						$query = $query->andWhere("s.$filter = ?", $value);
						if ($value == 1) {
							$query = $query->andWhere("(m.aliquots = 0 OR m.aliquots IS NULL)");
						} else {
							$query = $query->andWhere("m.aliquots > 0");
						}
					} else if ($filter === 'pcr') {
						switch ($value) {
						case 0:
						default:
							$query = $query->leftJoin("m.Pcr p");
							break;
						case 1:
							$query = $query->leftJoin("m.Pcr p")->andWhere('p.id IS NULL');
							break;
						case 2:
							$query = $query->innerJoin("m.Pcr p");
							break;
						}
					} else if ($filter === 'dna_sequence') {
						switch ($value) {
						case 0:
						default:
							$query = $query->leftJoin("p.Sequence seq");
							break;
						case 1:
							$query = $query->leftJoin("p.Sequence seq")->andWhere('seq.id IS NULL');
							break;
						case 2:
							$query = $query->innerJoin("p.Sequence seq");
							break;
						}
					}
					$query = $query->distinct();
				}
			}
			break;

		case 'patent_deposit':
		case 'maintenance_deposit':
			$csv->setHeader(array('Code', 'Depositor', 'Deposition date', 'Taxonomy'));
			foreach ($filters as $filter => $value) {
				if ($filter !== 'group_by' && !empty($value)) {
					if ($filter === 'id') {
						preg_match('/^[Bb]?[Ee]?[Aa]?\s*[dDMm]?\s*(\d{2})_(\d{2}).*$/', $value, $matches);
						if (array_key_exists(2, $matches)) {
							$query = $query->andWhere("m.deposition_date >= ?", sprintf('%s-01-01 00:00:00', $matches[2]));
							$query = $query->andWhere("m.deposition_date <= ?", sprintf('%s-12-31 00:00:00', $matches[2]));
						}
						if (array_key_exists(1, $matches)) {
							$query = $query->andWhere("m.yearly_count = ?", $matches[1]);
						}
					} elseif (in_array($filter, array('is_epitype', 'is_axenic'))) {
						if ($value >= 0) {
							$query = $query->andWhere("m.$filter = ?", $value - 1);
						}
					} else {
						$query = $query->andWhere("m.$filter = ?", $value);
					}
				}
			}
			break;

		case 'culture_medium':
			$csv->setHeader(array('Code', 'Name', 'Link', 'Is public?', 'Strains'));
			foreach ($filters as $filter => $value) {
				if ($filter !== 'group_by' && !empty($value)) {
					if ($filter === 'id') {
						preg_match('/^[Bb]?[Ee]?[Aa]?\s*(\d{1,4})\s*\-?\s*[cC]?\s*[mM]?\s*$/', $value, $matches);
						$query = $query->andWhere("m.id = ?", $matches[1]);
					} elseif (in_array($filter, array('is_public'))) {
						if ($value >= 0) {
							$query = $query->andWhere("m.$filter = ?", $value - 1);
						}
					} else {
						$query = $query->andWhere("m.$filter = ?", $value);
					}
				}
			}
			break;

		case 'cryopreservation':
			$csv->setHeader(array('Code', 'Subject', 'Class', 'Genus', 'Date', 'Method'));
			foreach ($filters as $filter => $value) {
				if ($filter !== 'group_by' && !empty($value)) {
					if ($filter === 'id') {
						preg_match('/^[Bb]?[Ee]?[Aa]?\s*(\d{1,4})\s*\-?\s*[cC]?\s*[mM]?\s*$/', $value, $matches);
						$query = $query->andWhere("m.id = ?", $matches[1]);
					} else {
						$query = $query->andWhere("m.$filter = ?", $value);
					}
				}
			}
			break;

		case 'external_strain':
			$csv->setHeader(array('Code', 'Name', 'Supervisor'));
			foreach ($filters as $filter => $value) {
				if ($filter !== 'group_by' && !empty($value)) {
					if ($filter === 'id') {
						preg_match('/^[Bb]?[Ee]?[Aa]?\s*[Rr]?\s*[Cc]?\s*(\d{1,4})\s*[Bb]?.*$/', $value, $matches);
						$query = $query->andWhere("m.code = ?", $matches[1]);
					} elseif ($filter === 'maintenance_status_id' || $filter === 'culture_medium_id') {
						$intermediateModel = ($filter == 'culture_medium_id') ? 'CultureMedia' : 'MaintenanceStatus';
						$query = $query->andWhere("m.ExternalStrain$intermediateModel.$filter = ?", $value);
					} elseif (in_array($filter, array('is_epitype', 'is_axenic'))) {
						if ($value >= 0) {
							$query = $query->andWhere("m.$filter = ?", $value - 1);
						}
					} else {
						$query = $query->andWhere("m.$filter = ?", $value);
					}
				}
			}
			break;

		case 'project':
			$csv->setHeader(array('Code', 'Subject', 'Project', 'Class', 'Genus', 'Inoculation date', 'Petitioner', 'Delivery date'));
			foreach ($filters as $filter => $value) {
				if ($filter !== 'group_by' && !empty($value)) {
					if ($filter === 'id') {
						preg_match('/^[Bb]?[Ee]?[Aa]?\s*(\d{1,4})\s*\-?\s*[cC]?\s*[mM]?\s*$/', $value, $matches);
						$query = $query->andWhere("m.id = ?", $matches[1]);
					} else {
						$query = $query->andWhere("m.$filter = ?", $value);
					}
				}
			}
			break;

		case 'identification':
			$csv->setHeader(array('Code', 'Date', 'Sample', 'Petitioner', 'Microscopy identification', 'Molecular identification'));
			foreach ($filters as $filter => $value) {
				if ($filter !== 'group_by' && !empty($value)) {
					if ($filter === 'id') {
						preg_match('/^[Bb]?[Ee]?[Aa]?\s*[iI]?[dD]?(\d{1,4})_?(\d{1,2})?.*$/', $value, $matches);
						if (isset($matches[2])) {
							$query = $query->andWhere("(m.yearly_count = ? AND m.identification_date BETWEEN ? AND ?)", array($matches[1], "{$matches[2]}-01-01", "{$matches[2]}-12-31"));
						} else {
							$query = $query->andWhere("m.yearly_count = ?", $matches[1]);
						}
					} elseif ($filter === 'sample_id') {
						preg_match('/^(\d{1,4}).*$/', $value, $matches);
						$query = $query->andWhere("m.sample_id = ?", $matches[1]);
					} else {
						$query = $query->andWhere("m.$filter = ?", $value);
					}
				}
			}
			break;

		case 'potential_usage':
			$csv->setHeader(array('Class', 'Genus', 'Species', 'Potential applications'));
			foreach ($filters as $filter => $value) {
				if ($filter !== 'group_by' && !empty($value)) {
					$query = $query->andWhere("m.$filter = ?", $value);
				}
			}
			break;

		case 'isolation':
			$csv->setHeader(array('Code', 'Material', 'Related code', 'Class', 'Name', 'Reception date', 'Delivery date'));
			foreach ($filters as $filter => $value) {
				if ($filter !== 'group_by' && !empty($value)) {
					if ($filter === 'id') {
						if (preg_match('/^[Bb]?[Ee]?[Aa]?\s*[Ii]?[Ss]?(\d{1,2})_?(\d{1,2})\s*$/', $value, $matches)) {
							$query = $query->andWhere("({$this->mainAlias()}.yearly_count = ? AND YEAR({$this->mainAlias()}.reception_date) = ?)", $matches[1], $matches[2]);
						}
					}

					if ($filter === 'related_code') {
						// Sample
						if (preg_match('/^(\d{1,4}).*$/', $value, $matches)) {
							$query = $query->orWhere("m.Sample.id = ?", $matches[1]);
						}

						// Strain
						if (preg_match('/^[Bb]?[Ee]?[Aa]?\s*[Ii]?[Ss]?(\d{1,2})_?(\d{1,2})\s*$/', $value, $matches)) {
							$query = $query->orWhere("m.Strain.code = ?", $matches[1]);
						}

						// Research collection
						if (preg_match('/^[Bb]?[Ee]?[Aa]?\s*[Rr]?\s*[Cc]?\s*(\d{1,4})\s*[Bb]?.*$/', $value, $matches)) {
							$query = $query->orWhere("m.ExternalStrain.id = ?", $matches[1]);
						}

						// External code
						$query = $query->orWhere("m.external_code = ?", $value);
					}

					if ($filter === 'isolation_subject') {
						$query = $query->andWhere("m.isolation_subject = ?", $value);
					}

					if (in_array($filter, array('taxonomic_class_id', 'genus_id', 'species_id'))) {
						$query = $query->andWhere("(m.Strain.$filter = ? OR m.ExternalStrain.$filter = ?)", array_fill(0, 2, $value));
					}
				}
			}
			break;

		}

		$data = array();
		foreach ($query->execute() as $row) {
			switch ($module) {
			case 'location':
				$data[] = array($row->getName(), $row->getCountry(), $row->getRegion(), $row->getIsland(), $row->getNbSamples(), $row->getNbStrains());
				break;

			case 'sample':
				$data[] = array($row->getCode(), $row->getLocationNameAndDetails(), $row->getFormattedCollectors(), $row->getFormattedCollectionDate(), $row->getNbStrains());
				break;

			case 'strain':
				$data[] = array(
					$row->getFullCode(),
					sprintf('%s %s %s', $row->getTaxonomicClass(), $row->getGenus(), $row->getSpecies() ? $row->getSpecies()->getName() : sfConfig::get('app_unknown_species_name')),
					$row->getFormattedSampleCode(), $row->getFormattedHasDna(), $row->getFormattedIsPublic(), $row->getFormattedSupervisorWithInitials(),
				);
				break;

			case 'dna_extraction':
				$strain = $row->getStrain();
				$data[] = array(
					$row->getCode(), $strain->getTaxonomicClass(),
					sprintf('%s %s', $strain->getGenus(), $strain->getSpecies() ? $strain->getSpecies()->getName() : sfConfig::get('app_unknown_species_name')),
					$row->getFormattedExtractionDate(), $row->getExtractionKit()->getName(), $row->getFormattedConcentration(), $row->getFormattedAliquots(),
					$row->getNbPcr(), $row->getFormattedHasDnaSequence(),
				);
				break;

			case 'patent_deposit':
				$data[] = array(
					$row->getCode(), $row->getDepositor(), $row->getDepositionDate(),
					sprintf('%s %s %s', $row->getTaxonomicClass(), $row->getGenus(), $row->getSpecies() ? $row->getSpecies()->getName() : sfConfig::get('app_unknown_species_name')),
				);
				break;

			case 'maintenance_deposit':
				$data[] = array(
					$row->getCode(), $row->getDepositor(), $row->getDepositionDate(),
					$row->getIsBlend() ? 'blend' : sprintf('%s %s %s', $row->getTaxonomicClass(), $row->getGenus(), $row->getSpecies() ? $row->getSpecies()->getName() : sfConfig::get('app_unknown_species_name')),
				);
				break;

			case 'culture_medium':
				$data[] = array($row->getCode(), $row->getName(), $row->getLink(), $row->getFormattedIsPublic(), $row->getNbStrains());
				break;

			case 'cryopreservation':
				$code = '' ;
				$taxonomicClass = sfConfig::get('app_no_data_message') ;
				$genusAndSpecies = sfConfig::get('app_no_data_message') ;
				$subject = $row->getSubject() ;

				if ($row->getSubject() == 'sample') {
					$code = $row->getSample()->getCode() ;
				}
				elseif ($row->getSubject() == 'strain') {
					$strain = $row->getStrain() ;
					$code = $strain->getFullCode() ;
					$taxonomicClass = $strain->getTaxonomicClass() ;
					$genusAndSpecies = $strain->getGenusAndSpecies() ;
				}
				elseif ($row->getSubject() == 'external_strain') {
					$subject = 'research_collection' ;
					$externalStrain = $row->getExternalStrain() ;
					$code = $externalStrain->getFullCode() ;
					$taxonomicClass = $externalStrain->getTaxonomicClass() ;
					$genusAndSpecies = $externalStrain->getGenusAndSpecies() ;
				}
				elseif ($row->getSubject() == 'patent_deposit') {
					$subject = 'patent_deposit' ;
					$patentDeposit = $row->getPatentDeposit() ;
					$code = $patentDeposit->getCode() ;
					$taxonomicClass = $patentDeposit->getTaxonomicClass() ;
					$genusAndSpecies = $patentDeposit->getGenusAndSpecies() ;
				}
				elseif ($row->getSubject() == 'maintenance_deposit') {
					$subject = 'maintenance_deposit' ;
					$maintenanceDeposit = $row->getMaintenanceDeposit() ;
					$code = $maintenanceDeposit->getCode() ;
					$taxonomicClass = $maintenanceDeposit->getTaxonomicClass() ;
					$genusAndSpecies = $maintenanceDeposit->getGenusAndSpecies() ;
				}
				$data[] = array($code, $subject, $taxonomicClass, $genusAndSpecies, $row->getCryopreservationDate(), $row->getCryopreservationMethod()->getName());
				break;

			case 'external_strain':
				$data[] = array(
					$row->getFullCode(),
					sprintf('%s %s %s', $row->getTaxonomicClass(), $row->getGenus(), $row->getSpecies() ? $row->getSpecies()->getName() : sfConfig::get('app_unknown_species_name')),
					$row->getFormattedSupervisorWithInitials(),
				);
				break;

			case 'project':
				$code = '' ;
				$taxonomicClass = sfConfig::get('app_no_data_message') ;
				$genusAndSpecies = sfConfig::get('app_no_data_message') ;
				$subject = $row->getSubject() ;

				if ($row->getSubject() == 'sample') {
					$code = $row->getSample()->getCode() ;
				}
				elseif ($row->getSubject() == 'strain') {
					$strain = $row->getStrain() ;
					$code = $strain->getFullCode() ;
					$taxonomicClass = $strain->getTaxonomicClass();
					$genusAndSpecies = $strain->getGenus();
				}
				elseif ($row->getSubject() == 'external_strain') {
					$subject = 'research_collection' ;
					$externalStrain = $row->getExternalStrain() ;
					$code = $externalStrain->getFullCode() ;
					$taxonomicClass = $externalStrain->getTaxonomicClass() ;
					$genusAndSpecies = $externalStrain->getGenus();
				}
				$data[] = array($code, $subject, $row->getProjectName()->getName(), $taxonomicClass, $genusAndSpecies, $row->getInoculationDate(), $row->getPetitioner(), $row->getDeliveryDate());
				break;

			case 'identification':
				$data[] = array(
					$row->getCode(), $row->getIdentificationDate(), $row->getSample()->getCode(), $row->getPetitioner(), $row->getMicroscopyIdentification(), $row->getMolecularIdentification(),
				);
				break;

			case 'potential_usage':
				$data[] = array(
					$row->getTaxonomicClass(),
					$row->getGenus(),
					$row->getSpecies() ? $row->getSpecies()->getName() : sfConfig::get('app_unknown_species_name'),
					$row->getPotentialUsages()->count(),
				);
				break;

			case 'isolation':
				$code = $row->getCode();
				$externalCode = $row->getExternalCode();
				$taxonomicClass = $row->getFormattedTaxonomicClass();
				$genusAndSpecies = $row->getGenusAndSpecies();
				$subject = $row->getIsolationSubject();

			 if ($sample = $row->getSample()) {
				 $externalCode = $sample->getCode();
			 } elseif ($strain = $row->getStrain()) {
				 $externalCode = $strain->getFullCode();
				 $taxonomicClass = $strain->getTaxonomicClass();
				 $genusAndSpecies = $strain->getGenusAndSpecies();
			 } elseif ($externalStrain = $row->getExternalStrain()) {
				 $subject = 'research_collection';
				 $externalCode = $externalStrain->getFullCode();
				 $taxonomicClass = $externalStrain->getTaxonomicClass();
				 $genusAndSpecies = $externalStrain->getGenusAndSpecies();
			 }

				$data[] = array($code, sfInflector::humanize($subject), $externalCode, $taxonomicClass, $genusAndSpecies, $row->getReceptionDate(), $row->getDeliveryDate());
				break;
			}
		}

		$csv->setData($data);
		$csv->startDownload($module);
		return sfView::NONE;
	}

	/**
	 * getRemovablePictures
	 *
	 * @param array $form A form sent by the user
	 * @param string $widgetName Alternate name of the widget that stores the picture information
	 * @return array List of picture filenames
	 */
	protected function getRemovablePictures(sfFormObject $form, $widgetName = 'Pictures') {
		$filenames = array();
		if ( isset($form[$widgetName]) ) {
			foreach ( $form[$widgetName] as $index => $pictures ) {
				foreach ($pictures as $key => $field) {
					if ( $key === 'delete_object' && $field->getValue() === 'on' ) {
						$filenames[] = $pictures['filename']->getValue();
					}
				}
			}
		}

		return $filenames;
	}

	/**
	 * removePicturesFromFilesystem
	 *
	 * @param array $filenames List of filenames to be removed
	 * @return void
	 */
	protected function removePicturesFromFilesystem(array $filenames, $subdirectory) {
		if ( !empty($filenames) ) {
			foreach( $filenames as $filename ) {
				$commonPath = sfConfig::get('sf_web_dir').sfConfig::get('app_pictures_dir').$subdirectory;
				$image = $commonPath.'/'.$filename;
				$thumbnail = preg_replace('/\.[\-\w]+$/', sfConfig::get('app_thumbnail_extension'), $commonPath.sfConfig::get('app_thumbnails_dir').'/'.$filename);

				unlink($image);
				unlink($thumbnail);
			}
		}
	}

	/**
	 * removeDocumentsFromFilesystem
	 *
	 * Each item of $files represent a <filename,directory> pair:
	 *
	 *   filename[0] => array('filename1', 'directory1')
	 *   ...
	 *   filename[i] => array('filename2', 'directory2')
	 *   ...
	 *   filename[n] => array('filename3', 'directory1')
	 *
	 * @param array $files List of files to be removed
	 * @return void
	 */
	protected function removeDocumentsFromFilesystem(array $files) {
		foreach( $files as $file ) {
			unlink(sfConfig::get('sf_upload_dir').$file[1].'/'.$file[0]);
		}
	}

	/**
	 * Deletes a object if it is not referenced by any foreign key
	 *
	 * @param sfWebRequest $request
	 * @return void
	 */
	public function executeDelete(sfWebRequest $request) {
		$request->checkCSRFProtection();

		$id = $request->getParameter('id');
		$module = $this->request->getParameter('module');
		$moduleReadableName = sfInflector::humanize($module);
		$moduleReadableNameLowercase = str_replace('_', ' ', $module);

		$this->forward404Unless($model = Doctrine_Core::getTable(sfInflector::camelize($module))->find(array($id)), sprintf('Object does not exist (%s).', $id));

		try {
			// Remove pictures if any
			$removablePictures = array();
			if ( $module === 'location' || $module === 'sample' || $module === 'strain' ) {
				foreach ($model->getPictures() as $picture ) {
					$removablePictures[] = $picture->getFilename();
				}
			}

			// Remove documents, if any
			$removableDocuments = array();
			if ( $module === 'culture_medium' ) {
				$removableDocuments[] = array($model->getDescription(), sfConfig::get('app_culture_media_dir'));
			}

			$model->delete();
			$this->removePicturesFromFilesystem($removablePictures, sfConfig::get("app_{$module}_pictures_dir"));
			$this->removeDocumentsFromFilesystem($removableDocuments);

			$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log'));
			$this->getUser()->setFlash('notice', "$moduleReadableName deleted successfully");
		}
		catch (Exception $e) {
			$this->getUser()->setFlash('notice', "This $moduleReadableNameLowercase cannot be deleted because it is being used in other records");
		}

		$this->redirect("@$module?page=".$this->getUser()->getAttribute("$module.index_page"));
	}

	/**
	 * Returns the progress of a form upload using APC
	 *
	 * @param sfWebRequest $request
	 * @return void
	 */
	public function executeUploadProgress(sfWebRequest $request) {
		$apc_status = apc_fetch( 'upload_'.$request->getParameter('id'));
		$percentage = 1;
		if ( $apc_status['current'] != 0 ) {
			$percentage = $apc_status['current'] / $apc_status['total']*100;
		}

		$this->setLayout(false);
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		$this->getResponse()->setContent($percentage);
		return sfView::NONE;
	}

	/**
	 * Returns a picture encoded in Base64
	 *
	 * @param string $filename
	 * @param string $path If null, it's assumed that the picture is located in 'images' directory
	 *
	 * @return string Base64 encoded picture
	 */
	public function getBase64EncodedPicture($filename, $path = '/images') {
		$picture = fread(fopen("$path/$filename", 'r'), filesize("$path/$filename"));
		return base64_encode($picture);
	}

	/**
	 * Saves a PNG picture encoded in Base64 in filesystem
	 *
	 * @param string $data Encoded picture
	 * @param string $path If null, it's assumed that the picture is located in 'images' directory
	 *
	 * @return string Filename of the PNG picture in local filesystem
	 */
	public function saveBase64EncodedPicture($data = '', $path = '/images') {
		// Create the picture and save it
		$pngPicture = new sfThumbnail(null, null, true, true, sfConfig::get('app_picture_resolution'), 'sfImageMagickAdapter');
		if (!$pngPicture->loadData(base64_decode($data))) {
			throw Exception("The picture could not be decoded");
		}
		$filename = sha1(substr($data, 0, 40).rand(11111, 99999)).'.png';
		$pngPicture->save("$path/$filename");

		// Create the thumbnail by resizing the image
		try {
			$thumbnailsDirectory = $path.sfConfig::get('app_thumbnails_dir');
			if (!is_dir($thumbnailsDirectory)) {
				mkdir($thumbnailsDirectory, 0770);
			}

			$thumbnail = new sfThumbnail(sfConfig::get('app_max_thumbnail_size'), sfConfig::get('app_max_thumbnail_size'), true, true, 300, 'sfImageMagickAdapter');
			$thumbnail->loadData(base64_decode($data));
			$thumbnailFilename = preg_replace('/\.[\w\-]+$/', sfConfig::get('app_thumbnail_extension'), $filename);
			$thumbnail->save("$thumbnailsDirectory/$filename", 'image/png');
		}
		catch (Exception $e) {
			unlink("$path/$filename");
			throw Exception("The picture thumbnail could not be created. {$e->getMessage()}");
		}

		$pngPicture->clear();
		$pngPicture->destroy();
		return $filename;
	}

	/**
	 * Find the locations that matches a search term
	 *
	 * @param sfWebRequest $request
	 * @return JSON object with location id, name and GPS coordinates
	 */
	public function executeFindLocations(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$results = LocationTable::getInstance()->findByTerm($request->getParameter('term'));
			$locations = array();
			foreach ($results as $location) {
				$locations[] = array(
					'id' => $location->getId(),
					'label' => $location->getName(),	// This attribute must be named label due to the jQuery Autocomplete plugin
					'latitude' => $location->getLatitude(),
					'longitude' => $location->getLongitude(),
				);
			}
			$this->getResponse()->setContent(json_encode($locations));
		}
		return sfView::NONE;
	}

	/**
	 * Find the samples that matches a search term
	 *
	 * @param sfWebRequest $request
	 * @return JSON object with sample id and code
	 */
	public function executeFindSamples(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$results = SampleTable::getInstance()->findByTerm($request->getParameter('term'));
			$samples = array();
			foreach ($results as $sample) {
				$samples[] = array(
					'id' => $sample->getId(),
					'label' => $sample->getCode(),	// This attribute must be named label due to the jQuery Autocomplete plugin
				);
			}
			$this->getResponse()->setContent(json_encode($samples));
		}
		return sfView::NONE;
	}

	/**
	 * Find the strains that matches a search term
	 *
	 * @param sfWebRequest $request
	 * @return JSON object with strain id and code
	 */
	public function executeFindStrains(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$results = StrainTable::getInstance()->findByTerm($request->getParameter('term'));
			$strains = array();
			foreach ($results as $strain) {
				$strains[] = array(
					'id' => $strain->getId(),
					'label' => $strain->getFullCode(),	// This attribute must be named label due to the jQuery Autocomplete plugin
				);
			}
			$this->getResponse()->setContent(json_encode($strains));
		}
		return sfView::NONE;
	}

	/**
	 * Find the external strains that matches a search term
	 *
	 * @param sfWebRequest $request
	 * @return JSON object with strain id and code
	 */
	public function executeFindExternalStrains(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$results = ExternalStrainTable::getInstance()->findByTerm($request->getParameter('term'));
			$strains = array();
			foreach ($results as $strain) {
				$strains[] = array(
					'id' => $strain->getId(),
					'label' => $strain->getFullCode(),	// This attribute must be named label due to the jQuery Autocomplete plugin
				);
			}
			$this->getResponse()->setContent(json_encode($strains));
		}
		return sfView::NONE;
	}

	/**
	 * Find the patent deposits that matches a search term
	 *
	 * @param sfWebRequest $request
	 * @return JSON object with patent deposit ID and code
	 */
	public function executeFindPatentDeposits(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$results = PatentDepositTable::getInstance()->findByTerm($request->getParameter('term'));
			$deposits = array();
			foreach ($results as $deposit) {
				$deposits[] = array(
					'id' => $deposit->getId(),
					'label' => $deposit->getCode(),	// This attribute must be named label due to the jQuery Autocomplete plugin
				);
			}
			$this->getResponse()->setContent(json_encode($deposits));
		}
		return sfView::NONE;
	}

	/**
	 * Find the maintenance deposits that matches a search term
	 *
	 * @param sfWebRequest $request
	 * @return JSON object with maintenance deposit ID and code
	 */
	public function executeFindMaintenanceDeposits(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$results = MaintenanceDepositTable::getInstance()->findByTerm($request->getParameter('term'));
			$deposits = array();
			foreach ($results as $deposit) {
				$deposits[] = array(
					'id' => $deposit->getId(),
					'label' => $deposit->getCode(),	// This attribute must be named label due to the jQuery Autocomplete plugin
				);
			}
			$this->getResponse()->setContent(json_encode($deposits));
		}
		return sfView::NONE;
	}
}
