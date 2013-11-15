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
 * strain actions
 *
 * @package ACM.Frontend
 * @subpackage strain
 * @version 1.2
 */
class strainActions extends MyActions {
	/**
	 * Index action
	 */
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'Strain', array('init' => false, 'sort_column' => 'code'));
		$filters = $this->_processFilterConditions($request, 'strain');

		$query = null;
		if (count($filters)) {
			if (!empty($filters['group_by'])) {
				$query = StrainTable::getInstance()->createQuery($this->mainAlias())->select("{$this->mainAlias()}.*");
				$this->groupBy = $filters['group_by'];

				if (in_array($this->groupBy, array('transfer_interval', 'is_epitype', 'is_axenic', 'deceased', 'is_public'))) {
					$relatedAlias = $this->groupBy;
					$relatedForeignKey = $this->groupBy;
					$recursive = false;
				} else {
					$relatedAlias = sfInflector::camelize($this->groupBy);
					$relatedForeignKey = sfInflector::foreign_key($this->groupBy);
					$recursive = true;
				}

				$query = $query
					->addSelect("COUNT(DISTINCT {$this->mainAlias()}.id) as n_strains")
					->addSelect("COUNT(DISTINCT d.id) as n_dna_extractions")
					->leftJoin("{$this->mainAlias()}.DnaExtractions d")
					->groupBy("{$this->mainAlias()}.$relatedForeignKey");

				if ($recursive) {
					$query = $query->innerJoin("{$this->mainAlias()}.$relatedAlias m");
					if (in_array($this->groupBy, array('sample'))) {
						$query = $query->addSelect('m.id as value');
					} else {
						$query = $query->addSelect('m.name as value');
					}
				} else {
					$query = $query->addSelect("{$this->mainAlias()}.$relatedAlias as value");
				}
			} else {
				$query = $this->pager->getQuery();
			}

			$query = $query
				->leftJoin("{$this->mainAlias()}.Sample s")
				->leftJoin("{$this->mainAlias()}.TaxonomicClass c")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species sp")
				->leftJoin("{$this->mainAlias()}.Supervisor su")
				->where('1=1');

			foreach (array('taxonomic_class_id', 'genus_id', 'species_id', 'authority_id', 'supervisor_id') as $filter) {
				if (!empty($filters[$filter])) {
					$query = $query->andWhere("{$this->mainAlias()}.$filter = ?", $filters[$filter]);

					$table = ($filter === 'supervisor_id') ? 'sfGuardUserTable' : sprintf('%sTable', sfInflector::camelize(str_replace('_id', '', $filter)));
					$table = call_user_func(array($table, 'getInstance'));
					$this->filters[$filter] = $table->find($filters[$filter])->getName();
				}
			}

			foreach (array('maintenance_status_id', 'culture_medium_id', 'property_id') as $filter) {
				if (!empty($filters[$filter])) {
					$intermediateModel = '';
					switch ($filter) {
					case 'culture_medium_id':
						$intermediateModel = 'CultureMedia';
						break;
					case 'maintenance_status_id':
						$intermediateModel = 'MaintenanceStatus';
						break;
					case 'property_id':
						$intermediateModel = 'Properties';
						break;
					}
					$query = $query->andWhere("{$this->mainAlias()}.Strain$intermediateModel.{$filter} = ?", $filters[$filter]);

					if ($filter === 'property_id') {
						$table = 'StrainPropertyTable';
					} else {
						$table = sprintf('%sTable', sfInflector::camelize(str_replace('_id', '', $filter)));
					}
					$table = call_user_func(array($table, 'getInstance'));
					$this->filters[$filter] = $table->find($filters[$filter])->getName();
				}
			}

			if (!empty($filters['is_epitype']) && $filters['is_epitype'] > 0) {
				$this->filters['Epitype'] = ($filters['is_epitype'] == 1) ? 'no' : 'yes';
				$query = $query->andWhere("{$this->mainAlias()}.is_epitype = ?", ($filters['is_epitype'] == 1) ? 0 : 1);
			}

			if (!empty($filters['is_axenic']) && $filters['is_axenic'] > 0) {
				$this->filters['Axenic'] = ($filters['is_axenic'] == 1) ? 'no' : 'yes';
				$query = $query->andWhere("{$this->mainAlias()}.is_axenic = ?", ($filters['is_axenic'] == 1) ? 0 : 1);
			}

			if (!empty($filters['is_public']) && $filters['is_public'] > 0) {
				$this->filters['Public'] = ($filters['is_public'] == 1) ? 'no' : 'yes';
				$query = $query->andWhere("{$this->mainAlias()}.is_public = ?", ($filters['is_public'] == 1) ? 0 : 1);
			}

			if (!empty($filters['deceased']) && $filters['deceased'] > 0) {
				$this->filters['Deceased'] = ($filters['deceased'] == 1) ? 'no' : 'yes';
				$query = $query->andWhere("{$this->mainAlias()}.deceased = ?", ($filters['deceased'] == 1) ? 0 : 1);
			}

			if (!empty($filters['transfer_interval'])) {
				$this->filters['Transfer interval'] = $filters['transfer_interval'];
				$query = $query->andWhere("{$this->mainAlias()}.transfer_interval = ?", $filters['transfer_interval']);
			}

			if (!empty($filters['id'])) {
				$this->filters['Code'] = $filters['id'];
				preg_match('/^[Bb]?[Ee]?[Aa]?\s*(\d{1,4})\s*[bB]?.*$/', $filters['id'], $matches);
				$query = $query->andWhere("{$this->mainAlias()}.code = ?", $matches[1]);
			}
		} else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Sample sa")
				->leftJoin("sa.Location loc")
				->leftJoin("{$this->mainAlias()}.TaxonomicClass c")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species sp")
				->leftJoin("{$this->mainAlias()}.Supervisor su");
		}

		if (empty($filters['group_by'])) {
			$this->pager->setQuery($query);
			$this->pager->init();
			$this->results = $this->pager->getResults();
		} else {
			$this->results = $query->execute();
		}

		// Keep track of the last page used in list
		$this->getUser()->setAttribute('strain.index_page', $request->getParameter('page'));

		// Add a form to filter results
		$this->form = new StrainForm(array(), array('search' => true));
	}

	/**
	 * Show action
	 */
	public function executeShow(sfWebRequest $request) {
		$this->strain = StrainTable::getInstance()->find(array($request->getParameter('id')));
		$this->forward404Unless($this->strain);
	}

	/**
	 * NewRelatedModelEmbeddedForm action
	 */
	public function executeNewRelatedModelEmbeddedForm(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$this->setLayout(false);
			return $this->renderPartial('embeddedForm', array('model' => $request->getParameter('related_model')));
		}
		else {
			return sfView::NONE;
		}
	}

	/**
	 * Find an existing strain that matches a search term
	 *
	 * @param sfWebRequest $request
	 * @return JSON object with strain id and code
	 */
	public function executeFindClone(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {

			$strains = StrainTable::getInstance()->createQuery('s')
				->where('s.code LIKE ?', '%'.$request->getParameter('term').'%')
				->andWhere('s.clone_number IS NULL')
				->execute();

			$data = array();
			foreach ($strains as $strain) {
				$data[] = array(
					'label' => $strain->getCode(),
					'sample_code' => $strain->getSample()->getCode(),
					'sample_id' => $strain->getSampleId(),
					'taxonomic_class_id' => $strain->getTaxonomicClassId(),
					'genus_id' => $strain->getGenusId(),
					'species_id' => $strain->getSpeciesId(),
				);
			}

			$this->getResponse()->setContent(json_encode($data));
		}
		return sfView::NONE;
	}

	/**
	 * Reorder the list of isolators of a strain
	 *
	 * @param sfWebRequest $request
	 * @return JSON object with strain id and code
	 * @author Eliezer Talon
	 * @version 2011-11-10
	 */
	public function executeUpdateIsolatorsOrder(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			try {
				$table = StrainIsolatorsTable::getInstance();
				$order = 0;
				$strainId = $request->getParameter('strain_id');

				foreach ( $request->getParameter('isolators') as $id ) {
					$table->createQuery('si')
						->update()
						->set('si.sort_order', $order++)
						->where('si.isolator_id = ?', $id)
						->andWhere('si.strain_id = ?', $strainId)
						->execute();
				}

				$this->getResponse()->setContent('');
			}
			catch (Exception $e) {
				$this->getResponse()->setContent($e->getMessage());
			}

		}
		return sfView::NONE;
	}

	/**
	 * Import strains from CSV file
	 */
	public function executeImportFromCSV(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::GET));

		$this->form = new StrainImportForm();
		if ($request->isMethod(sfRequest::POST)) {
			$taintedValues = $request->getParameter($this->form->getName());
			$this->form->bind($taintedValues, $request->getFiles($this->form->getName()));

			$uploadedFiles = $request->getFiles();
			$error = false;
			if (isset($uploadedFiles)) {
				if (($handle = fopen($uploadedFiles['filename']['tmp_name'], "r")) !== false) {
					$strains = array();
					$nRequiredFields = 24;
					$strainTable = StrainTable::getInstance();
                                        $this->results = null;
					$line = 0;
                                        $posInitColumn=0;
                                        $arrayTitles= array();
                                        if(($data = fgetcsv($handle, 0, ";", '"')) !== false){
                                          
                                            foreach ($data as $key =>$value){
                                                if($value=='#BEA_CODE' && $key!= 0){
                                                    $data[$key] = $data[0];
                                                    $data[0] ='#BEA_CODE';
                                                    $posInitColumn = $key;
                                                }
                                            }
                                                                                       
                                            foreach ($data as $key =>$value) 
                                                $arrayTitles [$value] = $key+1;
                                        }                                        
                                        ++$line;
					while (($data = fgetcsv($handle, 0, ";", '"')) !== false) {
						++$line;
						if (count($data) < $nRequiredFields) {
							$error = sprintf('Changes could not be applied. The number of fields in line %d is less than %d', $line, $nRequiredFields);
							break;
						}
                          
						$strain = null;
						$field = 0;
                                                $valInitcolumn = $data[$posInitColumn];
                                                if($posInitColumn != 0){
                                                    $data[$posInitColumn] = $data[0];
                                                    $data[0] = $valInitcolumn;
                                                }
                                               
						foreach ($data as $value) {
							$error = false;
							++$field;

							$value = trim($value);
							if (strlen($value) === 0) {
								continue;
							}

							// Strain code
							if ($field == $arrayTitles['#BEA_CODE']) {
								if (preg_match("/^[Bb][Ee][Aa]\s*(\d+)\s*(\/\d+)?\s*([Bb])?$/", $value, $matches)) {
									$code = (isset($matches[1]) ? $matches[1] : '');
									$clone = (isset($matches[2]) ? ltrim($matches[2], '/') : null);
									$axenic = (isset($matches[3]) ? false : true);

									if ($clone !== null && $clone !== '') {
										$strain = $strainTable->findOneByCodeAndCloneNumber($code, $clone);                                                                                
									} else {
										$strain = $strainTable->findOneByCode($code);
                                                                                 
									}
                                                                       
									if ($strain == null) {
										$strain = new Strain();
										$strain->setCode($code);
									}
                                                                        if ($clone !== null && $clone !== ''){   
                                                                            $strain->setCloneNumber($clone);
                                                                        }
									$strain->setIsAxenic($axenic);
									continue;
								} else {
									$error = "Malformed BEA code in line $line column #BEA_CODE";
									break;
								}
							}

//							// Sample code
							if ($field == $arrayTitles['SAMPLE_CODE_ACM']) {
								if (preg_match("/^(\d+)\s*([A-Za-z]+)\s*(\w{3}|_\w\w)\s*(00|[A-Za-z]{2,3})\s*(\d{2})(\d{2})(\d{2})$/", $value, $matches)) {
									$id = (isset($matches[1]) ? $matches[1] : '');
									$sampleTable = SampleTable::getInstance();                                                                        
									$sample = $sampleTable->findOneById(intval($id));
                                                                        if($sample == null ){
                                                                            $error = "Sample code no exists in line $line column SAMPLE_CODE_ACM";
                                                                            break;
                                                                        }elseif ($sample != null && $strain != null) {
										$strain->setSampleId($sample->getId());
									}
									continue;
								} else {
									$error = "Malformed sample code in line $line column SAMPLE_CODE_ACM value:".$value;
									break;
								}
							}
//
//							// Kingdom
//							if ($field == 3) {
//								$kingdom = KingdomTable::getInstance()->findOneByName($value);
//								if ($kingdom != null && $strain != null) {
//									$strain->setKingdomId($kingdom->getId());
//								}
//								continue;
//							}
//
//							// Subkingdom
//							if ($field == 4) {
//								$subkingdom = SubkingdomTable::getInstance()->findOneByName($value);
//								if ($subkingdom != null && $strain != null) {
//									$strain->setSubkingdomId($subkingdom->getId());
//								}
//								continue;
//							}
//
//							// Phylum
//							if ($field == 5) {
//								$phylum = PhylumTable::getInstance()->findOneByName($value);
//								if ($phylum != null && $strain != null) {
//									$strain->setPhylumId($phylum->getId());
//								}
//								continue;
//							}
//
//							// Taxonomic class
							if ($field == $arrayTitles['TAX_CURRENT_CLASS']) {
                                                                if($value != 'sp.'){
                                                                    $taxonomicClass = TaxonomicClassTable::getInstance()->findOneByName($value);
                                                                    if($taxonomicClass == null && $value!= ''){
                                                                          $taxonomicClass = new TaxonomicClass();
                                                                          $taxonomicClass->setName(trim($value));                                                   
                                                                          $taxonomicClass->save();
                                                                    }
                                                                    if ($taxonomicClass != null && $strain != null) {
                                                                          $strain->setTaxonomicClassId($taxonomicClass->getId());
                                                                    }
                                                                }elseif($strain != null ){
                                                                    $strain->setTaxonomicClassId(null);
                                                                }  
								continue;
							}
//
//							// Taxonomic order
//							if ($field == 7) {
//								$taxonomicOrder = TaxonomicOrderTable::getInstance()->findOneByName($value);
//								if ($taxonomicOrder != null && $strain != null) {
//									$strain->setTaxonomicOrderId($taxonomicOrder->getId());
//								}
//								continue;
//							}
//
//							// Family
//							if ($field == 8) {
//								$family = FamilyTable::getInstance()->findOneByName($value);
//								if ($family != null && $strain != null) {
//									$strain->setFamilyId($family->getId());
//								}
//								continue;
//							}
//
//							// Genus
							if ($field == $arrayTitles['TAX_CURRENT_GENUS']) {
                                                                if($value != 'sp.'){
                                                                    $genus = GenusTable::getInstance()->findOneByName($value);
                                                                    if($genus == null && $value!= ''){
                                                                          $genus = new Genus();
                                                                          $genus->setName(trim($value));                                                   
                                                                          $genus->save();
                                                                    }
                                                                    if ($genus != null && $strain != null) {
                                                                          $strain->setGenusId($genus->getId());
                                                                    }
                                                                }elseif($strain != null ){
                                                                    $strain->setGenusId(null);
                                                                }    
								continue;
							}

							// Species
							if ($field == $arrayTitles['TAX_CURRENT_SPECIES']) {
                                                                if($value != 'sp.'){
                                                                    $species = SpeciesTable::getInstance()->findOneByName($value);
                                                                    if($species == null && $value!= ''){
                                                                          $species = new Species();
                                                                          $species->setName(trim($value));                                                   
                                                                          $species->save();
                                                                    }
                                                                    if ($species != null && $strain != null) {
                                                                         $strain->setSpeciesId($species->getId());
                                                                    }
                                                                }elseif($strain != null ){
                                                                    $strain->setSpeciesId(null);
                                                                }    
								continue;
							}

							// Authority
							if ($field == $arrayTitles['STRAIN_TAX_AUTHORITY']) {
								$authority = AuthorityTable::getInstance()->findOneByName(trim($value));
                                                              
                                                                if($authority == null && $value!= ''){
//                                                                      $error = "Authority not found in line $line column STRAIN_TAX_AUTHORITY";
                                                                        break; 
                                                                }
								if ($authority != null && $strain != null) {
								      $strain->setAuthorityId($authority->getId());
								}
								continue;
							}

							// Epitype
							if ($field == $arrayTitles['STRAIN_TYPE_STRAIN']) {
								if (preg_match("/^(0|1)$/", $value)) {
									$epitype = strcmp($value, 0) !== 0;
									if ($strain != null) {
										$strain->setIsEpitype($epitype);
									}
									continue;
								} else {
                                                                        $error = "Invalid epitype value. Must be 0 or 1 in line $line column STRAIN_TYPE_STRAIN";
									break;
								}
							}

							// Isolators
							if ($field == $arrayTitles['SAMPLE_ISOLATOR']) {
								        $matches = explode("&", $value);
									$isolators = new Doctrine_Collection('StrainIsolators');
                                                                        $relationshipExists=false;
                                                                        $hasErrors=false;
                                                                        if($strain->getId() != null){
                                                                            StrainIsolatorsTable::getInstance()->createQuery('q')->delete('StrainIsolators i')->whereIn('i.strain_id', $strain->getId())->execute();
                                                                        }    
									foreach ($matches as $match) {                                                                           
										if (strlen($match) == 0) {
											continue;
										}
                                                                                                                                                              
										$isolator = IsolatorTable::getInstance()->createQuery('i')
                                                                                    ->where("CONCAT(TRIM(i.name), ' ', TRIM(i.surname)) LIKE ?", sprintf("%%%s%%",rtrim(trim(preg_replace('/[ ]+/',' ',$match)), '&')))
                                                                                    ->fetchOne();
                                                                                                                                                              
                                                                                if($isolator != null && $strain->getId()!= null){
                                                                                    $relationshipExists = StrainIsolatorsTable::getInstance()->findOneByStrainIdAndIsolatorId($strain->getId(), $isolator->getId());
                                                                                }
                                                                                if($isolator == null && $match!= ''){
                                                                                    $hasErrors = true;
                                                                                    break;                                                                                                                                                                          
                                                                                }                                                                               
										if ($isolator != null && !$relationshipExists) {
											$isolators->add($isolator);
										}
									}
                                                                        if($hasErrors){
                                                                            $error = "Isolator not found in line $line column SAMPLE_ISOLATOR name:".$match;
                                                                            break;
                                                                        }
									if ($strain != null && count($isolators) > 0) {
										$strain->setIsolators($isolators);
									}
									continue;
								
							}

							// Isolation date
							if ($field == $arrayTitles['SAMPLE_ISOLATION_DATE']) {
                                                           
								if ($value!= '') {
                                                                        $value = str_replace( array("\\", "Â¨", "Âº", "~","#", "@", "|", "!", "\"",
                                                                                               "Â·", "$", "%", "&","(", ")", "?", "'", "Â¡",
                                                                                               "Â¿", "[", "^", "`", "]","+", "}", "{", "Â¨", "Â´",
                                                                                               ">", "< ", ";", ",", ":",".", " "),'', $value);
                                                                        $value = str_replace( "-",'/', $value);
                                                                        $value = explode("/",$value);
                                                                        
                                                                        if(count($value)==2){
                                                                            $value[2] = $value[1];
                                                                            $value[1] = $value[0];
                                                                            $value[0] = '01';
                                                                        }
                                                                        if(count($value)==1){
                                                                            $value[2] = $value[0];
                                                                            $value[1] = '01';
                                                                            $value[0] = '01';
                                                                        }    
                                                                      
									if ($strain != null && count($value) == 3) {
										$strain->setIsolationDate($value[2].'-'.$value[1].'-'.$value[0]);
									}
									continue;
								} 
							}

//							// Identifier
//							if ($field == 15) {
//								$identifier = IdentifierTable::getInstance()->createQuery('i')
//									->where("CONCAT(i.name, ' ', i.surname) LIKE ?", sprintf('%%%s%%', $value))
//									->fetchOne();
//								if ($identifier != null && $strain != null) {
//									$strain->setIdentifierId($identifier->getId());
//								}
//								continue;
//							}
//
							// Depositor
							if ($field == $arrayTitles['STRAIN_DEPOSITOR']) {
                                                                if($value != ''){
                                                                    $depositor = DepositorTable::getInstance()->createQuery('d')
                                                                            ->where("CONCAT(TRIM(d.name), ' ', TRIM(d.surname)) LIKE ?", sprintf('%%%s%%', trim($value)))
                                                                            ->fetchOne();
                                                                    
                                                                    if($depositor == null){
                                                                            $error = "Depositor not found in line $line column STRAIN_DEPOSITOR value:".$value;
                                                                            break;
//                                                                         
                                                                    }
                                                                    if ($depositor != null && $strain != null) {
                                                                            $strain->setDepositorId($depositor->getId());
                                                                    }
                                                                }
								continue;
							}
                                                        // Remarks
							if ($field == $arrayTitles['STRAIN_REMARKS']) {	
                                                                if ($strain != null) {
									$strain->setRemarks(trim($value));
								}
								continue;
								
							}

							// Maintenance statuses
							if ($field == $arrayTitles['CRYO_AUTO_CALC']) {
								if (preg_match("/^([^&]+&)*([^&]+)$/", $value, $matches)) {
									$matches = explode("&", $value);
									$maintenanceStatuses = new Doctrine_Collection('StrainMaintenanceStatus');
                                                                        $hasErrors = false;
                                                                        if($strain->getId() != null){
                                                                            MaintenanceStatusTable::getInstance()->createQuery('q')->delete('StrainMaintenanceStatus sm')->whereIn('sm.strain_id', $strain->getId())->execute();
                                                                        }    
									foreach ($matches as $match) {
										if (strlen($match) == 0) {
											continue;
										}
                                                                                
                                                                                if(rtrim(trim($match), '&') == 1)
                                                                                    $name = 'Cryopreserved';
                                                                                else
                                                                                    $name = 'Liquid';
                                                                                
										$maintenanceStatus = MaintenanceStatusTable::getInstance()->findOneByName($name);
                                                                                if($maintenanceStatus == null){
                                                                                    $hasErrors = true;
                                                                                    break;
                                                                                }
                                                                                    
                                                                                if($maintenanceStatus != null && $strain->getId() != null){
                                                                                   $relationshipExists = StrainMaintenanceStatusTable::getInstance()->findOneByStrainIdAndMaintenanceStatusId($strain->getId(), $maintenanceStatus->getId());
										}
                                                                                if ($maintenanceStatus != null && !$relationshipExists) {
											$maintenanceStatuses->add($maintenanceStatus);
										}
									}
                                                                        if($hasErrors){
                                                                            $error = "StrainMaintenanceStatus not found in line $line column CRYO_AUTO_CALC";
                                                                            break;
                                                                        }
									if ($strain != null && count($maintenanceStatuses) > 0) {
										$strain->setMaintenanceStatus($maintenanceStatuses);
									}
									continue;
								} else {
									$error = sprintf("Malformed maintenance statuses list (%s)", $value);
									break;
								}
							}

							// Culture medium
							if ($field == $arrayTitles['STRAIN_CULTURE_MEDIUM_1']) {
								if($value != ''){
                                                                    $cultureMedium = CultureMediumTable::getInstance()->findOneByName(trim($value));
                                                                    if($cultureMedium == null){
                                                                        $error = "culture_medium not found in line $line column STRAIN_CULTURE_MEDIUM_1 value:".$value;
                                                                        break;
                                                                    }elseif ($cultureMedium != null && $strain != null) {
                                                                            $strain->setCultureMediumId($cultureMedium->getId());
                                                                    }
                                                                }
								continue;
							}

							// Culture media
							if ($field == $arrayTitles['STRAIN_CULTURE_MEDIUM_2']) {
                                                          
								$matches = explode("&", $value);
                                                                $cultureMedia = new Doctrine_Collection('StrainCultureMedia');
                                                                $relationshipExists = false;
                                                                $hasErrors = false;
                                                                if($strain->getId() != null){
                                                                            CultureMediumTable::getInstance()->createQuery('q')->delete('StrainCultureMedia sm')->whereIn('sm.strain_id', $strain->getId())->execute();
                                                                }            
                                                                foreach ($matches as $match) {
                                                                        if (strlen($match) == 0) {
                                                                                continue;
                                                                        }
                                                                        $cultureMedium = CultureMediumTable::getInstance()->findOneByName(rtrim(trim($match), '&'));
                                                                        if($cultureMedium == null){
                                                                            $hasErrors = true;
                                                                            break;
                                                                        }
                                                                        if($cultureMedium != null && $strain->getId() != null){
                                                                            $relationshipExists = StrainCultureMediaTable::getInstance()->findOneByStrainIdAndCultureMediumId($strain->getId(), $cultureMedium->getId());
                                                                        }
                                                                        if ($cultureMedium != null && !$relationshipExists) {
                                                                                $cultureMedia->add($cultureMedium);
                                                                        }
                                                                }
                                                                if($hasErrors){
                                                                        $error = "CultureMedium not found in line $line column STRAIN_CULTURE_MEDIUM_2 value:".$value;
                                                                        break;
                                                                }
                                                                if ($strain != null && count($cultureMedia) > 0) {
                                                                        $strain->setCultureMedia($cultureMedia);
                                                                }
                                                                continue;
								
							}
//
//							
							// Containers
							if ($field == $arrayTitles['STRAIN_CULTURE_CONTAINER']) {
								if (preg_match("/^([^&]+&)*([^&]+)$/", $value, $matches)) {
									$matches = explode("&", $value);
									$relationshipExists=false;
									$containers = new Doctrine_Collection('StrainContainers');
                                                                        $hasErrors = false;
                                                                        if($strain->getId() != null){
                                                                            ContainerTable::getInstance()->createQuery('q')->delete('StrainContainers sc')->whereIn('sc.strain_id', $strain->getId())->execute();
                                                                        }
                                                                        $cont_containers= 0;
									foreach ($matches as $match) {
										if (strlen($match) == 0) {
											continue;
										}
                                                                              
                                                                                switch (strtoupper(rtrim(trim($match), '&'))) {
                                                                                    case 'EF':
                                                                                       $name = 'E-flask';
                                                                                    break;
                                                                                    case 'TC':
                                                                                       $name = 'Tissue culture';
                                                                                    break;
                                                                                    case 'PT':
                                                                                       $name = 'Plastic tube';
                                                                                    break;
                                                                                    case 'GT':
                                                                                       $name = 'Glass tube';
                                                                                    break;
                                                                                    case 'PD':
                                                                                       $name = 'Petri dish 30';
                                                                                    break;
                                                                                    default:
                                                                                       $name = '';    
                                                                                     break;
                                                                                }
										$container = ContainerTable::getInstance()->findOneByName($name);
                                                                               
                                                                                if($container == null){
                                                                                    $hasErrors = true;
                                                                                    break;
                                                                                }
                                                                                if($container != null && $strain->getId()!= null )
                                                                                    $relationshipExists = StrainContainersTable::getInstance()->findOneByStrainIdAndContainerId($strain->getId(), $container->getId());
										if ($container != null && !$relationshipExists) {
										    $containers->add($container);
										}
                                                                                // el primero se almacena en el strain
                                                                                if($cont_containers == 0){
                                                                                    if ($container != null && $strain != null) {
                        								$strain->setContainerId($container->getId());
                        							    }
                                                                                }
                                                                                $cont_containers++;
									}
                                                                        if($hasErrors){
                                                                            $error = "Container not found in line $line column STRAIN_CULTURE_CONTAINER name:".$value;
                                                                            break;
                                                                        }
									if ($strain != null && count($containers) > 0) {
										$strain->setContainers($containers);
									}
									continue;
								} else {
									$error = "Malformed containers list in line $line column STRAIN_PUBLIC";
									break;
								}
							}
//
							// Transfer interval
							if ($field == $arrayTitles['STRAIN_TRANSFER_INTERVAL_1']) {
								if ($strain != null) {
									$strain->setTransferInterval($value);
								}
								continue;
							}
                                                        // Is public
							if ($field == $arrayTitles['STRAIN_PUBLIC']) {
								if (preg_match("/^(0|1)$/", $value)) {
									$public = strcmp($value, 0) !== 0;
									if ($strain != null) {
										$strain->setIsPublic($public);
									}
									continue;
								} else {
                                                                        $error = "Invalid public value . Must be 0 or 1 in line $line column STRAIN_PUBLIC";
									break;
								}
							}
                                                        // Deceased
							if ($field == $arrayTitles['STRAIN_STATUS']) {
								if ($strain != null && $value !='') {
                                                                    if(in_array($value,array('Dead','Lost','Removed')))
									$strain->setDeceased(1);
                                                                    else
                                                                        $strain->setDeceased(0);
								}
								continue;
							}
                                                        //observation
                                                        if ($field == $arrayTitles['SAMPLE_OLD_CODE_SAMPLING']) {
								if ($strain != null && $value !='' ) {
									$strain->setObservation(trim($value));
								}
								continue;
							}
                                                        // web notes
                                                        if ($field == $arrayTitles['STRAIN_NOTES_FOR_THE_WEB']) {
								if ($strain != null && $value !='') {
									$strain->setWebNotes (trim($value));
								}
								continue;
							}
                                                        //relatives
                                                        if ($field == $arrayTitles['STRAIN_RELATIVES']) {
                                                            $relative=null;
                                                            if($strain->getId()!= null){
                                                                $relative = StrainRelativeTable::getInstance()->createQuery('d')
                                                                        ->where("d.strain_id = ?",$strain->getId())
                                                                        ->fetchOne();                                                                                     
                                                            } 
                                                            
                                                            if ($relative == null) {
                                                                $relative = new StrainRelative();
                                                                $relative->setName(trim($value));                                                   
                                                                $relative->setStrain($strain);                                                   
                                                                $relative->save();                                                               
                                                            }else{
                                                                $relative->setName($value);  
                                                            }
                                                            continue;
                                                        }
                                                        //citations
                                                        if ($field == $arrayTitles['STRAIN_REFERENCES']) {
                                                            if ($strain != null && $value !='') {
                                                                $strain->setCitations(trim($value));
                                                            }
                                                            continue;
                                                        }
                                                        
							// Supervisor
							if ($field == $arrayTitles['STRAIN_SUPERVISOR']) {
								$supervisor = sfGuardUserTable::getInstance()->createQuery('u')
									->where("CONCAT(u.first_name, ' ', u.last_name) LIKE ?", sprintf('%%%s%%', trim($value)))
									->fetchOne();
                                                                if($supervisor == null){
                                                                     $error = "supervisor not found in line $line column STRAIN_SUPERVISOR";
								     break;
                                                                }
								if ($supervisor != null && $strain != null) {
									$strain->setSupervisorId($supervisor->getId());
								}
								continue;
							}
                                                        
                                                        //MOL_ ID
//                                                      if ($field == $arrayTitles['TAX_MOLTAX_SEEN']) {
//                                                            if (preg_match("/^(0|1)$/", $value)) {
//									$public = strcmp($value, 0) !== 0;
//									if ($strain != null&& $value !='') {
//										$strain->setMolId(trim($value));
//									}
//									continue;
//							    } else {
//                                                                        $error = "Invalid mol_id value . Must be 0 or 1 in line $line column TAX_MOLTAX_SEEN";
//									break;
//							    }
//                                                            continue;
//                                                      }
//
//							// Temperature
//							if ($field == 24) {
//								if (is_numeric($value)) {
//									if ($strain != null) {
//										$strain->setTemperature($value);
//									}
//									continue;
//								} else {
//									$error = sprintf("Malformed temperature value (%s)", $value);
//									break;
//								}
//							}
//
//							// Photoperiod
//							if ($field == 24) {
//								if (is_numeric($value)) {
//									if ($strain != null) {
//										$strain->setPhoperiod($value);
//									}
//									continue;
//								} else {
//									$error = sprintf("Malformed photoperiod value (%s)", $value);
//									break;
//								}
//							}
//
//							// Irradiation
//							if ($field == 24) {
//								if (is_numeric($value)) {
//									if ($strain != null) {
//										$strain->setIrradiation($value);
//									}
//									continue;
//								} else {
//									$error = sprintf("Malformed irradiation value (%s)", $value);
//									break;
//								}
//							}
						}

						if ($strain != null) {
							$strains[] = $strain;
						}
						if ($error != null) {
							$errors[] = $error;
						}
					}
					fclose($handle);

					if ($data === NULL) {
						$error = sprintf('Changes could not be applied. Line %d could not be read', $line);
					} else if (isset($errors) && count($errors)>=1) {
						$error = sprintf('Changes could not be applied.');
					} else {
						$dbConnection = Doctrine_Manager::connection();
						try {
							$dbConnection->beginTransaction();
							foreach ($strains as $strain) {
								$strain->save();
							}
							$dbConnection->commit();
						} catch (Exception $e) {
							$dbConnection->rollback();
							$error = $e->getMessage();
						}
					}
				} else {
					$error = sprintf('The file could not be read. Try it again or contact the administrator if the error persists.');
				}
			} else {
				$error = 'You have not upload any file or the file provided is not valid';
			}

			if ($error !== false) {
				$this->getUser()->setFlash('notice', $error, false);
                                if(!isset($errors)) $errors = null;
                                $this->results = $errors;
                                $this->error = true;
			} else {
				$this->getUser()->setFlash('notice', 'Strains information uploaded and applied');
                                $this->results = $strains;
                                 $this->error = false;
				//$this->redirect('@strain');
			}
		}
	}

	/**
	 * New action
	 */
	public function executeNew(sfWebRequest $request) {
		$lastStrain = false;
		if ($request->hasParameter('id')) {
			$lastStrain = StrainTable::getInstance()->find(array($request->getParameter('id')));
		}
		elseif ($this->getUser()->hasAttribute('strain.last_object_created')) {
			$lastStrain = $this->getUser()->getAttribute('strain.last_object_created');
		}

		if ($lastStrain) {
			$strain = new Strain();
			$strain->setSampleId($lastStrain->getSampleId());
			$strain->setTaxonomicClassId($lastStrain->getTaxonomicClassId());
			$strain->setGenusId($lastStrain->getGenusId());
			$strain->setSpeciesId($lastStrain->getSpeciesId());
			$strain->setAuthorityId($lastStrain->getAuthorityId());
			$strain->setIsEpitype($lastStrain->getIsEpitype());
			$strain->setIsPublic($lastStrain->getIsPublic());
			$strain->setCultureMediumId($lastStrain->getCultureMediumId());
			$strain->setContainerId($lastStrain->getContainerId());
			$strain->setIsolationDate($lastStrain->getIsolationDate());
			$strain->setIdentifierId($lastStrain->getIdentifierId());
			$strain->setIsAxenic($lastStrain->getIsAxenic());
			$strain->setTransferInterval($lastStrain->getTransferInterval());
			$strain->setObservation($lastStrain->getObservation());
			$strain->setCitations($lastStrain->getCitations());
			$strain->setRemarks($lastStrain->getRemarks());
			$strain->setWebNotes($lastStrain->getWebNotes());

			$this->form = new StrainForm($strain);
			$this->sampleCode = $lastStrain->getSample()->getCode();
			$this->getUser()->setAttribute('strain.last_object_created', null);
		}
		else {
			$this->form = new StrainForm();
			$this->sampleCode = null;
		}

		$this->hasSamples = (Doctrine::getTable('Sample')->count() > 0)?true:false;
		$this->hasTaxonomicClasses = (Doctrine::getTable('TaxonomicClass')->count() > 0)?true:false;
		$this->hasGenus = (Doctrine::getTable('Genus')->count() > 0)?true:false;
		$this->hasSpecies = (Doctrine::getTable('Species')->count() > 0)?true:false;
		$this->hasAuthorities = (Doctrine::getTable('Authority')->count() > 0)?true:false;
		$this->hasIsolators = (Doctrine::getTable('Isolator')->count() > 0)?true:false;
		$this->hasCultureMedia = (Doctrine::getTable('CultureMedium')->count() > 0)?true:false;
	}

	/**
	 * Create action
	 */
	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new StrainForm();
		$this->hasSamples = (Doctrine::getTable('Sample')->count() > 0)?true:false;
		$this->hasTaxonomicClasses = (Doctrine::getTable('TaxonomicClass')->count() > 0)?true:false;
		$this->hasGenus = (Doctrine::getTable('Genus')->count() > 0)?true:false;
		$this->hasSpecies = (Doctrine::getTable('Species')->count() > 0)?true:false;
		$this->hasAuthorities = (Doctrine::getTable('Authority')->count() > 0)?true:false;
		$this->hasIsolators = (Doctrine::getTable('Isolator')->count() > 0)?true:false;
		$this->hasCultureMedia = (Doctrine::getTable('CultureMedium')->count() > 0)?true:false;
		$this->sampleCode = ($request->hasParameter('strain_sample_search')) ? $request->getParameter('strain_sample_search') : null;

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	/**
	 * Edit action
	 */
	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($strain = StrainTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object strain does not exist (%s).', $request->getParameter('id')));
		$this->form = new StrainForm($strain);
		$this->sampleCode = $strain->getSample()->getCode();
	}

	/**
	 * Update action
	 */
	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($strain = StrainTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object strain does not exist (%s).', $request->getParameter('id')));
		$this->form = new StrainForm($strain);
		$this->sampleCode = $strain->getSample()->getCode();

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	/**
	 * processForm action
	 */
	protected function processForm(sfWebRequest $request, sfForm $form) {
		$taintedValues = $request->getParameter($form->getName());

		// Keep track of isolators
		$isolatorsOrder = array();
		if ( isset($taintedValues['isolators_list']) ) {
			if ( $form->getObject()->isNew() ) {
				$order = 0;
				foreach ( $taintedValues['isolators_list'] as $id ) {
					$isolatorsOrder[$id] = $order++;
				}
			}
			else {
				$strainId = $form->getObject()->getId();
				$table = StrainIsolatorsTable::getInstance();
				$nextOrder = $table->createQuery('si')->select('MAX(si.sort_order) as order')->where('si.strain_id = ?', $strainId)->fetchOne()->order + 1;
				foreach ( $taintedValues['isolators_list'] as $id ) {
					if ( $table->createQuery('si')->where('si.isolator_id = ?', $id)->andWhere('si.strain_id = ?', $strainId)->count() <= 0 ) {
						$isolatorsOrder[$id] = $nextOrder++;
					}
				}
			}
		}

		// Look for related models embedded forms
		$relatedModels = array('taxonomic_class', 'genus', 'species', 'authority', 'taxonomic_order', 'phylum', 'family', 'kingdom', 'subkingdom');
		foreach ( $relatedModels as $modelName ) {
			$modelInput = "new_$modelName";
			$modelClass = sfInflector::camelize($modelName);

			if (array_key_exists($modelInput, $taintedValues)) {
				$model = new $modelClass();
				$model->setName($taintedValues[$modelInput]['name']);
				unset($taintedValues[$modelInput]);

				if ($model->trySave()) {
					$taintedValues["{$modelName}_id"] = $model->getId();
				} else {
					$this->getUser()->setFlash('notice', "A related model ($model) could not be saved. Try again", false);
					return;
				}
			}
		}

		// Unset axenity tests if values are empty
		if (isset($taintedValues['new_AxenityTests'])) {
			$validTests = array();
			foreach ( $taintedValues['new_AxenityTests'] as $test ) {
				if ( empty($test['date']['day']) || empty($test['date']['month']) || empty($test['date']['year']) ) {
					continue;
				}
				$validTests[] = $test;
			}

			$nValidTests = count($validTests);
			if ( $nValidTests == 0 ) {
				$taintedValues['new_AxenityTests'] = array();
			}
			else if ( $nValidTests > 0 && $nValidTests < count($taintedValues['new_AxenityTests']) ) {
				$taintedValues['new_AxenityTests'] = $validTests;
			}
		}

		// Unset pictures if values are empty
		if (!isset($taintedValues['new_Pictures'])) {
			$taintedValues['new_Pictures'] = array();
		}

		// Bind input fields with files uploaded
		$form->bind($taintedValues, $request->getFiles($form->getName()));

		// Count files uploaded in form
		$uploadedFiles = $request->getFiles();
		$nbValidFiles = 0;
		if (isset($uploadedFiles['strain']['new_Pictures'])) {
			foreach ( $uploadedFiles['strain']['new_Pictures'] as $file ) {
				if ( !empty($file['filename']['name']) ) {
					$nbValidFiles += 1;
				}
			}
		}
		$nbFiles = $form->getObject()->getNbPictures() + $nbValidFiles;

		// Validate form
		$message = null;
		if ($form->isValid() && $nbFiles <= sfConfig::get('app_max_strain_pictures')) {
			$url = null;
			$isNew = $form->getObject()->isNew();

			// Detect pictures that must be deleted
			$removablePictures = $this->getRemovablePictures($form);

			// Save object
			$strain = null;
			$dbConnection = Doctrine_Manager::connection();
			try {
				$dbConnection->beginTransaction();
				$strain = $form->save();

				// Initialize sort_order of new records in StrainIsolator
				foreach ( $isolatorsOrder as $id => $order ) {
					StrainIsolatorsTable::getInstance()->createQuery('si')
						->update()
						->set('si.sort_order', $order)
						->where('si.isolator_id = ?', $id)
						->andWhere('si.strain_id = ?', $strain->getId())
						->execute();
				}

				// Normalize sort_order values
				$isolators = StrainIsolatorsTable::getInstance()->createQuery('si')->where('si.strain_id = ?', $strain->getId())->orderBy('si.sort_order')->execute();
				$order = 0;
				foreach ($isolators as $isolator) {
					$isolator->setSortOrder($order++);
					$isolator->save();
				}

				$dbConnection->commit();

				if ( $request->hasParameter('_save_and_add') ) {
					$message = 'Strain created successfully. Now you can add another one';
					$url = '@strain_new';

					// Reuse last object values
					$this->getUser()->setAttribute('strain.last_object_created', $strain);
				}
				elseif ( !$isNew ) {
					$message = 'Changes saved';
					$url = '@strain_show?id='.$strain->getId();
				}
				else {
					$message = 'Strain created successfully';
					$url = '@strain_show?id='.$strain->getId();
				}

				// Remove Location pictures
				$this->removePicturesFromFilesystem($removablePictures, sfConfig::get('app_strain_pictures_dir'));
			}
			catch (Exception $e) {
				$dbConnection->rollback();
				$message = $e->getMessage();
			}

			if ( $strain != null ) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $strain->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ( $url !== null ) {
					$this->redirect($url);
				}
			}
		}

		$this->getUser()->setFlash('notice', 'The information on this strain has some errors you need to fix', false);
	}

	/**
	 * Create labels for Strain records
	 *
	 * @param sfWebRequest $request Request information
	 * @return void
	 */
	public function executeCreateLabel(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::GET));
		if ($request->isMethod(sfRequest::POST)) {
			$values = $request->getPostParameters();
			$this->labels = StrainTable::getInstance()->availableStrainsForLabelConfiguration($values);
			$this->copies = $values['copies'];

			$this->setLayout(false);
			$pdf = new WKPDF();
			$pdf->set_html($this->getPartial('create_pdf'));
			$pdf->set_orientation('Landscape');
			$pdf->render();
			$pdf->output(WKPDF::$PDF_DOWNLOAD, "strain_labels.pdf");
			throw new sfStopException();
		} else {
			$this->getUser()->setAttribute('strain_label_configuration', array());
			$this->form = new StrainLabelForm();
			$this->form->setWidgets(array(
				'supervisor_id' => new sfWidgetFormDoctrineChoice(array(
					'model' => 'Supervisor',
					'query' => StrainTable::getInstance()->availableSupervisorsQuery(),
					'add_empty' => true,
				)),
			));
		}
	}

	/**
	 * Returns the HTML form section of a label field
	 *
	 * @param sfWebRequest $request
	 * @return string HTML content
	 */
	public function executeGetLabelField(sfWebRequest $request) {
		if ($request->isXmlHttpRequest()) {
			$div = $request->getParameter('field');
			$value = $request->getParameter('value');
			$strains = array();

			if (empty($div) || empty($value)) {
				return sfView::NONE;
			}

			$labelConfiguration = $this->getUser()->getAttribute('strain_label_configuration');
			$form = new StrainLabelForm();
			switch ($div) {
			case 'transfer_intervals':
				$labelConfiguration['supervisor_id'] = $value;
				$field = 'transfer_interval';
				$form->setWidgets(array(
					'transfer_interval' => new sfWidgetFormChoice(array(
						'choices' => StrainTable::getInstance()->availableTransferIntervalChoices($labelConfiguration['supervisor_id']),
					))));
				break;
			case 'genus':
				$labelConfiguration['transfer_interval'] = $value;
				$field = 'genus_id';
				$form->setWidgets(array(
					'genus_id' => new sfWidgetFormDoctrineChoice(array(
						'model' => 'Genus',
						'query' => StrainTable::getInstance()->availableGenusQuery(
							$labelConfiguration['supervisor_id'], $labelConfiguration['transfer_interval']),
						'add_empty' => true,
					)),
				));
				break;
			case 'axenicity':
				$labelConfiguration['genus_id'] = $value;
				$field = 'is_axenic';
				$form->setWidgets(array('is_axenic' => new sfWidgetFormChoice(array('choices' => StrainLabelForm::$booleanChoices))));
				break;
			case 'container':
				$labelConfiguration['is_axenic'] = $value;
				$field = 'container_id';
				$form->setWidgets(array(
					'container_id' => new sfWidgetFormDoctrineChoice(array(
						'model' => 'Container',
						'query' => StrainTable::getInstance()->availableContainersQuery(
							$labelConfiguration['supervisor_id'], $labelConfiguration['transfer_interval'], $labelConfiguration['genus_id'], $labelConfiguration['is_axenic']),
						'add_empty' => true,
					)),
				));
				break;
			case 'culture_medium':
				$labelConfiguration['container_id'] = $value;
				$field = 'culture_medium_id';
				$form->setWidgets(array(
					'culture_medium_id' => new sfWidgetFormDoctrineChoice(array(
						'model' => 'CultureMedium',
						'query' => StrainTable::getInstance()->availableCultureMediaQuery(
							$labelConfiguration['supervisor_id'], $labelConfiguration['transfer_interval'], $labelConfiguration['genus_id'], $labelConfiguration['is_axenic'], $labelConfiguration['container_id']),
						'add_empty' => true,
					)),
				));
				break;
			case 'strain':
				$labelConfiguration['culture_medium_id'] = $value;
				$strains = StrainTable::getInstance()->availableStrainsForLabelConfiguration($labelConfiguration);
				break;
			}
			$this->getUser()->setAttribute('strain_label_configuration', $labelConfiguration);

			$this->setLayout(false);
			if ($div === 'strain') {
				return $this->renderPartial('labelStrains', array('strains' => $strains));
			} else {
				return $this->renderPartial('labelFieldForm', array('div' => $div, 'field' => $field, 'form' => $form));
			}
		}
		return sfView::NONE;
	}
}
