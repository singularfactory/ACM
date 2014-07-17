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
 * dna_extraction actions.
 *
 * @package ACM.Frontend
 * @subpackage dna_extraction
 */
class dna_extractionActions extends MyActions {
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'DnaExtraction', array('init' => false, 'sort_column' => 'Strain.code'));
		$filters = $this->_processFilterConditions($request, 'dna_extraction');

		$query = null;
		if (count($filters)) {
			if (!empty($filters['group_by'])) {
				$query = DnaExtractionTable::getInstance()->createQuery($this->mainAlias())->select("{$this->mainAlias()}.*");
				$this->groupBy = $filters['group_by'];

				if (in_array($this->groupBy, array('concentration', 'aliquots', '260_280_ratio', '260_230_ratio'))) {
					$relatedAlias = $this->groupBy;
					$relatedForeignKey = $this->groupBy;
					$recursive = false;
				}
				else {
					$relatedAlias = sfInflector::camelize($this->groupBy);
					$relatedForeignKey = sfInflector::foreign_key($this->groupBy);
					$recursive = true;
				}

				$query = $query
					->addSelect("COUNT(DISTINCT {$this->mainAlias()}.id) as n_dna_extractions")
					->groupBy("{$this->mainAlias()}.$relatedForeignKey");

				if ($recursive) {
					$query = $query->innerJoin("{$this->mainAlias()}.$relatedAlias m");
					if ($this->groupBy === 'strain') {
						$query = $query->addSelect('m.code as value');
						$query = $query->orderBy('s.code');
					} else {
						$query = $query->addSelect('m.id as value');
					}
				} else {
					$query = $query->addSelect("{$this->mainAlias()}.$relatedAlias as value");
				}
			} else {
				$query = $this->pager->getQuery();
			}

			$query = $query
				->leftJoin("{$this->mainAlias()}.Strain s")
				->leftJoin("{$this->mainAlias()}.ExtractionKit c")
				->leftJoin("s.TaxonomicClass tc")
				->leftJoin("s.Genus g")
				->leftJoin("s.Species sp")
				->where('1=1');

			if (!empty($filters['strain_id'])) {
				$this->filters['BEA code'] = $filters['strain_id'];
				preg_match('/^\s*[Bb]?[Ee]?[Aa]?\s*(\d{1,4})\s*[bB]?\s*_?(\d*).*$/', $filters['strain_id'], $matches);
				if (isset($matches[1])) {
					$id = ltrim($matches[1], '0');
					$query = $query->andWhere("s.code = ?", $id);
				}
			}

			foreach (array('taxonomic_class_id', 'genus_id') as $filter) {
				if (!empty($filters[$filter])) {
					$query = $query->andWhere("s.$filter = ?", $filters[$filter]);

					$table = sprintf('%sTable', sfInflector::camelize(str_replace('_id', '', $filter)));
					$table = call_user_func(array($table, 'getInstance'));
					$this->filters[$filter] = $table->find($filters[$filter])->getName();
				}
			}

			if (!empty($filters['aliquots']) && $filters['aliquots'] > 0) {
				if ($filters['aliquots'] == 1) {
					$this->filters['Aliquots'] = 'no';
					$query = $query->andWhere("({$this->mainAlias()}.aliquots = 0 OR {$this->mainAlias()}.aliquots IS NULL)");
				} else {
					$this->filters['Aliquots'] = 'yes';
					$query = $query->andWhere("{$this->mainAlias()}.aliquots > 0");
				}
			}

			switch ($filters['pcr']) {
			case 0:
			default:
				$query = $query->leftJoin("{$this->mainAlias()}.Pcr p");
				break;
			case 1:
				$this->filters['PCR'] = 'no';
				$query = $query->leftJoin("{$this->mainAlias()}.Pcr p")->andWhere('p.id IS NULL');
				break;
			case 2:
				$this->filters['PCR'] = 'yes';
				$query = $query->innerJoin("{$this->mainAlias()}.Pcr p");
				break;
			}

			switch ($filters['dna_sequence']) {
			case 0:
			default:
				$query = $query->leftJoin("p.Sequence seq");
				break;
			case 1:
				$this->filters['DNA sequence'] = 'no';
				$query = $query->leftJoin("p.Sequence seq")->andWhere('seq.id IS NULL');
				break;
			case 2:
				$this->filters['DNA sequence'] = 'yes';
				$query = $query->innerJoin("p.Sequence seq");
				break;
			}

			$query = $query->distinct();
		} else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Strain s")
				->leftJoin("{$this->mainAlias()}.ExtractionKit k")
				->leftJoin("{$this->mainAlias()}.Pcr p")
				->leftJoin("s.TaxonomicClass tc")
				->leftJoin("s.Genus g")
				->leftJoin("s.Species sp");
		}

		if (empty($filters['group_by'])) {
			$this->pager->setQuery($query);
			$this->pager->init();
			$this->results = $this->pager->getResults();
		} else {
			if ($request->getParameter('sort_column') === 'aliquots') {
				$query = $query->orderBy(sprintf('%s.aliquots>0 %s, s.code ASC', $this->mainAlias, $this->sortDirection));
			}
			$this->results = $query->execute();
		}

		// Keep track of the last page used in list
		$this->getUser()->setAttribute('dna_extraction.index_page', $request->getParameter('page'));

		// Add a form to filter results
		$this->form = new DnaExtractionForm(array(), array('search' => true));
	}

	public function executeShow(sfWebRequest $request) {
		$this->dnaExtraction = DnaExtractionTable::getInstance()->find(array($request->getParameter('id')));

		// Retrieve the PCR linked to this DNA extraction
		$this->pcrResults = $this->buildPagination($request, 'Pcr', array('init' => false, 'sort_column' => 'id'));
		$query = $this->pcrResults->getQuery()
			->leftJoin("{$this->mainAlias()}.DnaPolymerase")
			->leftJoin("{$this->mainAlias()}.ForwardPrimer")
			->leftJoin("{$this->mainAlias()}.ReversePrimer")
			->where("{$this->mainAlias()}.dna_extraction_id = ?", $this->dnaExtraction->getId());
		$this->pcrResults->setQuery($query);
		$this->pcrResults->init();

		$this->forward404Unless($this->dnaExtraction);
	}

	public function executeNew(sfWebRequest $request) {
		if ( $lastDnaExtraction = $this->getUser()->getAttribute('dna_extraction.last_object_created') ) {
			$dnaExtraction = new DnaExtraction();

			$dnaExtraction->setStrainId($lastDnaExtraction->getStrainId());
			$dnaExtraction->setExtractionKitId($lastDnaExtraction->getExtractionKitId());

			$this->form = new DnaExtractionForm($dnaExtraction);
			$this->getUser()->setAttribute('dna_extraction.last_object_created', null);
		}
		else {
			$this->form = new DnaExtractionForm();
		}

		$this->hasStrains = (Doctrine::getTable('Strain')->count() > 0)?true:false;
		$this->hasExtractionKits = (Doctrine::getTable('ExtractionKit')->count() > 0)?true:false;
		$this->aliquotsAreEditable = false;
	}

	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new DnaExtractionForm();
		$this->hasStrains = (Doctrine::getTable('Strain')->count() > 0)?true:false;
		$this->hasExtractionKits = (Doctrine::getTable('ExtractionKit')->count() > 0)?true:false;

		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($dna_extraction = DnaExtractionTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object dna extraction does not exist (%s).', $request->getParameter('id')));
		$this->form = new DnaExtractionForm($dna_extraction);

		$this->aliquotsAreEditable = $dna_extraction->aliquotsAreEditable();
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($dna_extraction = DnaExtractionTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object dna_extraction does not exist (%s).', $request->getParameter('id')));
		$this->form = new DnaExtractionForm($dna_extraction);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	protected function processForm(sfWebRequest $request, sfForm $form) {
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

		// Validate form
		if ( $form->isValid() ) {
			$message = null;
			$url = null;
			$isNew = $form->getObject()->isNew();

			// Save object
			$dnaExtraction = null;
			try {
				$dnaExtraction = $form->save();

				if ( $request->hasParameter('_save_and_add') ) {
					$message = 'DNA extraction created successfully. Now you can add another one';
					$url = '@dna_extraction_new';

					// Reuse last object values
					$this->getUser()->setAttribute('dna_extraction.last_object_created', $dnaExtraction);
				}
				elseif ( !$isNew ) {
					$message = 'Changes saved';
					$url = '@dna_extraction_show?id='.$dnaExtraction->getId();
				}
				else {
					$message = 'DNA extraction created successfully';
					$url = '@dna_extraction_show?id='.$dnaExtraction->getId();
				}
			}
			catch (Exception $e) {
				$message = $e->getMessage();
			}

			if ( $dnaExtraction != null ) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $dnaExtraction->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ( $url !== null ) {
					$this->redirect($url);
				}
			}
		}

		$this->getUser()->setFlash('notice', 'The information on this DNA extraction has some errors you need to fix', false);
	}

	/**
	 * Create labels for DnaExtraction records
	 *
	 * @param sfWebRequest $request Request information
	 * @return void
	 */
	public function executeCreateLabel(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::GET));
		$id = $request->getParameter('id');
		$this->forward404Unless($dnaExtraction = DnaExtractionTable::getInstance()->find(array($id)), sprintf('Object DNA extraction does not exist (%s).', $id));

		if ($request->isMethod(sfRequest::POST)) {
			$values = $request->getPostParameters();
			$this->label = $dnaExtraction;
			$this->copies = $values['copies'];

			$this->setLayout(false);
			$pdf = new WKPDF();
			$pdf->set_html($this->getPartial('create_pdf'));
			$pdf->set_orientation('Landscape');
			$pdf->render();
			$pdf->output(WKPDF::$PDF_DOWNLOAD, "dna_extraction_labels.pdf");
			throw new sfStopException();
		} else {
			$this->form = new DnaExtractionLabelForm($dnaExtraction);
			$this->dnaExtraction = $dnaExtraction;
		}
	}
        
        /**
	 * Import strains from CSV file
	 */
        public function executeImportFromCSV(sfWebRequest $request) {

        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::GET));
        $this->form = new DnaImportForm();
        if ($request->isMethod(sfRequest::POST)) {
            
            $taintedValues = $request->getParameter($this->form->getName());
            $this->form->bind($taintedValues, $request->getFiles($this->form->getName()));
            $uploadedFiles = $request->getFiles();
            $error = false;
            
            if (($handle = fopen($uploadedFiles['filename']['tmp_name'], "r")) !== false) {
                $dnas = array();
                $line = 0;
                $strainTable = StrainTable::getInstance();
                $dnaExtractionTable = DnaExtractionTable::getInstance();
                $this->results = null;
                $arrayTitles = array();
                
                //PROCESO BORRADO TABLA INICIAL
                $dnaExtractionTable->createQuery()
                                   ->delete()
                                   ->execute();
                
                if(($data = fgetcsv($handle, 0, ";", '"')) !== false) {
                  
                    if(strtoupper($data[0]) != 'MOL_CODE'){
                        die('Changes could not be applied. the first column must be MOL_CODE');
                    }
                    foreach ($data as $key =>$value){
                        $arrayTitles[$key] = strtoupper($value);
                    }
                }
               
                // BEGIN PROCESING LINES
                while (($data = fgetcsv($handle, 0, ";", '"')) !== false) {
                    ++$line;
                    if (count($data) < 8) {
                        $error = sprintf('Changes could not be applied. The number of fields in line %d is less than %d', $line, 8);
                        break;
                    }
                    $dnaExtraction = null;
                    $field = -1;
                    foreach ($data as $value) {
                        $error = false;
                        $value = trim($value);
                        
                        $field++;  
                       
                        // Strain code
                        if ($arrayTitles[$field] == 'MOL_CODE') {
                            $value = str_replace('_','', $value);
                            if (preg_match("/^[Bb][Ee][Aa]\s*(\d+)\s*(\/\d+)?\s*([Bb])?$/", $value, $matches)) {
                                $code = (isset($matches[1]) ? $matches[1] : '');
				$clone = (isset($matches[2]) ? ltrim($matches[2], '/') : null);
				$axenic = (isset($matches[3]) ? false : true);
                                if ($clone !== null && $clone !== '') {
                                    $strain = $strainTable->findOneByCodeAndCloneNumber($code, $clone);
                                } else {
                                    $strain = $strainTable->findOneByCode($code);
                                }
                               
                              
                                if($strain == '' || $strain == null){
                                    $error = "Not found Strain in line $line column MOL_CODE";
                                    break;
                                }
                               
//                                $dnaExtraction = $dnaExtractionTable->findOneByStrainId($strain->id);
//                                if ($dnaExtraction == null) {
//                                    //CREATE NEW OBJECT ROW
//                                    $dnaExtraction = new DnaExtraction();
//                                    $dnaExtraction->setStrainId($strain->id);
//                                    
//                                }
                                
                                //CREATE NEW OBJECT ROW
                                $dnaExtraction = new DnaExtraction();
                                $dnaExtraction->setStrainId($strain->id);
                                
                                if($strain->is_public)
                                    $dnaExtraction->is_public = true;
                                else
                                    $dnaExtraction->is_public = false; 
                                
                            }else{
                                $error = "Malformed BEA code in line $line column MOL_CODE value : ".$value;
		                break;
                            }
                            
                            continue;
                        }    
                        if ($arrayTitles[$field] == 'EXTRACTION_DATE') {
                            if ($value != '') {
                                $value = str_replace("-", '/', $value);
                                $value = explode("/", $value);
                                $dnaExtraction->extraction_date = $value[2] . '-' . $value[0] . '-' . $value[1];
                                $dnaExtraction->arrival_date = $value[2] . '-' . $value[0] . '-' . $value[1];
                            }
                            continue;
                        }
                        if ($arrayTitles[$field] == 'EXTRACTION METHOD') {
                            if ($value != '') {
                                $ek = ExtractionKitTable::getInstance()->findOneByName($value);
                                if ($ek == null) {
                                    $ek = new ExtractionKit();
                                    $ek->setName($value);
                                    $ek->save();
                                }
                                $dnaExtraction->extraction_kit_id = $ek->id;
                            } else {
                                $error = "Not found EXTRACTION METHOD  in line $line column EXTRACTION METHOD";
                                break;
                            }
                            continue;
                        }
                        if ($arrayTitles[$field] == 'DNA CONCENTRATION') {
                            if($value != '') {
                                $dnaExtraction->setConcentration(str_replace(',', '.', $value));
                            }
                            continue;
                        }
                        if ($arrayTitles[$field] == '260_280') {
                            if($value != '') {
                                
                                $dnaExtraction->set260_280Ratio(str_replace(',', '.', $value));
                            }
                            continue;
                        }
                        if ($arrayTitles[$field] == '260_230') {
                            if($value != '') {
                                $dnaExtraction->set260_230Ratio(str_replace(',', '.', $value));
                            }
                            continue;
                        }
                        if ($arrayTitles[$field] == 'PRESERVATION') {
                            if($value != '' && is_numeric($value)) {
                                $dnaExtraction->setPreservation(str_replace(',', '.', $value));
                            }
                            continue;
                        }
                        if ($arrayTitles[$field] == 'GENES') {
                             if($value != '') {
                                $dnaExtraction->setGenes(trim($value));
                            }
                            continue;
                        }
                        
                        
                    }
                    
                    if ($dnaExtraction != null) {
                        $dnas[] = $dnaExtraction;
                    }
                    if ($error != null) {
                        $errors[] = $error;
                    }
                    
                }
                 
                //APPLY CHANGES IN BD
                fclose($handle);
                if ($data === NULL) {
                    $error = sprintf('Changes could not be applied. Line %d could not be read', $line);
                } else if (isset($errors) && count($errors) >= 1) {
                    $error = sprintf('Changes could not be applied.');
                } else {
                    $dbConnection = Doctrine_Manager::connection();
                    try {
                        $dbConnection->beginTransaction();
                        foreach ($dnas as $dnaExtractionRow) {
                            $dnaExtractionRow->save();
                        }
                        $dbConnection->commit();
                    } catch (Exception $e) {
                        $dbConnection->rollback();
                        $error = $e->getMessage();
                    }
                }
                
            } else {
                $error = sprintf('The file could not be read.');
            }

            if ($error !== false) {
                $this->getUser()->setFlash('notice', $error, false);
                if (!isset($errors)) $errors = null;
                $this->results = $errors;
                $this->error = true;
            } else {
                $this->getUser()->setFlash('notice', 'DNA information uploaded and applied');
                $this->results = $dnas;
                $this->error = false;
            }
        }
    }

}
