<?php

/**
* report actions.
*
* @package    bna_green_house
* @subpackage report
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class reportActions extends sfActions {
	
	/**
	* Executes configure action
	*
	* @param sfRequest $request A request object
	*/
	public function executeConfigure(sfWebRequest $request) {
		if ( !($subject = $request->getParameter('subject')) ) {
			$subject = 'location';
		}
		
		if ( $request->isXmlHttpRequest() ) {
			return $this->renderPartial("{$subject}_form", array('form' => new ReportForm()));
		}
		
		$this->form = new ReportForm();
		$this->form->setDefault('subject', $subject);
		$this->subject = $subject;
	}
	
	/**
	 * Find the countries that matches a search term
	 *
	 * @param sfWebRequest $request 
	 * @return JSON object with country ID and name
	 * @author Eliezer Talon
	 * @version 2011-10-28
	 */
	public function executeFindCountries(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$countries = CountryTable::getInstance()->createQuery('c')
				->where('c.name LIKE ?', '%'.$request->getParameter('country').'%')->execute();
			
			$matches = array();
			foreach ( $countries as $match ) {
				$matches[] = array(
					'id' => $match->getId(),
					'label' => $match->getName(),	// This attribute must be named label due to the jQuery Autocomplete plugin
				);
			}
			$this->getResponse()->setContent(json_encode($matches));
		}
		return sfView::NONE;
	}
	
	/**
	 * Find the regions that matches a search term
	 *
	 * @param sfWebRequest $request 
	 * @return JSON object with region ID and name
	 * @author Eliezer Talon
	 * @version 2011-10-28
	 */
	public function executeFindRegions(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$regions = RegionTable::getInstance()->createQuery('r')
				->where('r.name LIKE ?', '%'.$request->getParameter('region').'%')->execute();
			
			$matches = array();
			foreach ( $regions as $match ) {
				$matches[] = array(
					'id' => $match->getId(),
					'label' => $match->getName(),	// This attribute must be named label due to the jQuery Autocomplete plugin
				);
			}
			$this->getResponse()->setContent(json_encode($matches));
		}
		return sfView::NONE;
	}
	
	/**
	 * Find the islands that matches a search term
	 *
	 * @param sfWebRequest $request 
	 * @return JSON object with island ID and code
	 * @author Eliezer Talon
	 * @version 2011-10-28
	 */
	public function executeFindIslands(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$islands = IslandTable::getInstance()->createQuery('i')
				->where('i.name LIKE ?', '%'.$request->getParameter('island').'%')->execute();
			
			$matches = array();
			foreach ( $islands as $match ) {
				$matches[] = array(
					'id' => $match->getId(),
					'label' => $match->getName(),	// This attribute must be named label due to the jQuery Autocomplete plugin
				);
			}
			$this->getResponse()->setContent(json_encode($matches));
		}
		return sfView::NONE;
	}
	
	/**
	* Executes generate action
	*
	* @param sfRequest $request A request object
	*/
	public function executeGenerate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		
		// Clean useless form values
		$taintedValues = $request->getPostParameters();
		if ( array_key_exists('location_country_search', $taintedValues) ) {
			unset($taintedValues['location_country_search']);
		}
		if ( array_key_exists('location_region_search', $taintedValues) ) {
			unset($taintedValues['location_region_search']);
		}
		if ( array_key_exists('location_island_search', $taintedValues) ) {
			unset($taintedValues['location_island_search']);
		}
		
		// Validate form
		$this->form = new ReportForm();
		$this->form->bind($taintedValues);
		$this->subject = $request->getParameter('subject');
	
		if ( !$this->form->isValid() ) {
			$this->getUser()->setFlash('notice', 'The report cannot be generated with the information you have provided. Make sure everything is OK.');		
			$this->setTemplate('configure');
		}
		else {
			$table = call_user_func(array(sfInflector::camelize($this->subject).'Table', 'getInstance'));
			$alias = substr($this->subject, 0, 1);
			$query = $table->createQuery($alias)->where('1 = ?', 1)->select("$alias.*");
			
			$this->results = array();
			switch ( $request->getParameter('subject') ) {
				case 'sample':
					// Group by
					if ( $this->modelToGroupBy = $request->getParameter('sample_group_by') ) {
						if ( in_array($this->modelToGroupBy, array('ph', 'conductivity', 'temperature', 'salinity', 'altitude')) ) {
							$relatedAlias = $this->modelToGroupBy;
							$relatedForeignKey = $this->modelToGroupBy;
							$recursive = false;
						}
						else {
							$relatedAlias = sfInflector::camelize($this->modelToGroupBy);
							$relatedForeignKey = sfInflector::foreign_key($this->modelToGroupBy);
							$recursive = true;
						}
						
						$query = $query->addSelect("COUNT($alias.id) as n_samples");
						if ( $recursive ) {
							$query = $query->innerJoin("$alias.$relatedAlias m");
						}
						
						$query = $query
							->leftJoin("$alias.Strains st")
							->addSelect("COUNT(st.id) as n_strains")
							->groupBy("$alias.$relatedForeignKey");
						
						if ( $recursive ) {
							$query = $query->addSelect('m.name as value');
						}
						else {
							$query = $query->addSelect("$alias.$relatedAlias as value");
						}
					}
					
					// Filters
					$this->filters = array();
					$relatedModels = array('environment', 'habitat', 'radiation');
					foreach ( $relatedModels as $model ) {
						if ( $id = $request->getParameter("sample_$model") ) {
							$foreignKey = sfInflector::foreign_key($model);
							$model = sfInflector::camelize($model);
							$table = call_user_func(array("{$model}Table", 'getInstance'));
							
							$this->filters[$model] = $table->find($id)->getName();
							$query = $query->andWhere("$alias.$foreignKey = ?", $id);
						}
					}
					
					if ( $isExtremophile = $request->getParameter('sample_extremophile') ) {
						if ( $isExtremophile == 1 ) {
							$this->filters['Extremophile'] = 'no';
							$query = $query->andWhere("$alias.is_extremophile = ?", 0);
						}
						elseif ( $isExtremophile == 2 ) {
							$this->filters['Extremophile'] = 'yes';
							$query = $query->andWhere("$alias.is_extremophile = ?", 1);
						}
					}
					break;
				
				case 'strain':
					// Group by
					if ( $this->modelToGroupBy = $request->getParameter('strain_group_by') ) {
						if ( in_array($this->modelToGroupBy, array('transfer_interval', 'is_epitype', 'is_axenic')) ) {
							$relatedAlias = $this->modelToGroupBy;
							$relatedForeignKey = $this->modelToGroupBy;
							$recursive = false;
						}
						else {
							$relatedAlias = sfInflector::camelize($this->modelToGroupBy);
							$relatedForeignKey = sfInflector::foreign_key($this->modelToGroupBy);
							$recursive = true;
						}

						$query = $query->addSelect("COUNT($alias.id) as n_strains");
						if ( $recursive ) {
							$query = $query->innerJoin("$alias.$relatedAlias m");
						}

						$query = $query
							->leftJoin("$alias.DnaExtractions d")
							->addSelect("COUNT(d.id) as n_dna_extractions")
							->groupBy("$alias.$relatedForeignKey");

						if ( $recursive ) {
							$query = $query->addSelect('m.name as value');
						}
						else {
							$query = $query->addSelect("$alias.$relatedAlias as value");
						}
					}
					
					// Filters
					$this->filters = array();
					$relatedModels = array('taxonomic_class', 'genus', 'species', 'authority');
					foreach ( $relatedModels as $model ) {
						if ( $id = $request->getParameter("strain_$model") ) {
							$foreignKey = sfInflector::foreign_key($model);
							$model = sfInflector::camelize($model);
							$table = call_user_func(array("{$model}Table", 'getInstance'));
							
							$this->filters[$model] = $table->find($id)->getName();
							$query = $query->andWhere("$alias.$foreignKey = ?", $id);
						}
					}
					
					$relatedModels = array('maintenance_status', 'culture_medium');
					foreach ( $relatedModels as $model ) {
						if ( $id = $request->getParameter("strain_$model") ) {
							$foreignKey = sfInflector::foreign_key($model);
							$model = sfInflector::camelize($model);
							$table = call_user_func(array("{$model}Table", 'getInstance'));
							
							$intermediateModel = $model;
							if ( $model == 'CultureMedium' ) {
								$intermediateModel = 'CultureMedia';
							}
							
							$this->filters[$model] = $table->find($id)->getName();
							$query = $query->andWhere("$alias.Strain$intermediateModel.$foreignKey = ?", $id);
						}
					}
					
					if ( $isEpitype = $request->getParameter('strain_epitype') ) {
						if ( $isEpitype == 1 ) {
							$this->filters['Epitype'] = 'no';
							$query = $query->andWhere("$alias.is_epitype = ?", 0);
						}
						elseif ( $isEpitype == 2 ) {
							$this->filters['Epitype'] = 'yes';
							$query = $query->andWhere("$alias.is_epity = ?", 1);
						}
					}
					
					if ( $isAxenic = $request->getParameter('strain_axenic') ) {
						if ( $isAxenic == 1 ) {
							$this->filters['Axenic'] = 'no';
							$query = $query->andWhere("$alias.is_axenic = ?", 0);
						}
						elseif ( $isAxenic == 2 ) {
							$this->filters['Axenic'] = 'yes';
							$query = $query->andWhere("$alias.is_axenic = ?", 1);
						}
					}
					
					if ( $transferInterval = $request->getParameter('strain_transfer_interval') ) {
						$this->filters['TransferInterval'] = $transferInterval;
						$query = $query->andWhere("$alias.transfer_interval = ?", $transferInterval);
					}
					break;
				
				case 'dna_extraction':
					// Group by
					if ( $this->modelToGroupBy = $request->getParameter('dna_extraction_group_by') ) {
						if ( in_array($this->modelToGroupBy, array('concentration', 'aliquots', '260_280_ratio', '260_230_ratio')) ) {
							$relatedAlias = $this->modelToGroupBy;
							$relatedForeignKey = $this->modelToGroupBy;
							$recursive = false;
						}
						else {
							$relatedAlias = sfInflector::camelize($this->modelToGroupBy);
							$relatedForeignKey = sfInflector::foreign_key($this->modelToGroupBy);
							$recursive = true;
						}

						$query = $query->addSelect("COUNT($alias.id) as n_dna_extractions");
						if ( $recursive ) {
							$query = $query->innerJoin("$alias.$relatedAlias m");
						}

						$query = $query->groupBy("$alias.$relatedForeignKey");

						if ( $recursive ) {
							if ( $this->modelToGroupBy == 'strain' ) {
								$query = $query->addSelect('m.id as value, m.is_axenic as axenic');
							}
							else {
								$query = $query->addSelect('m.id as value');
							}
						}
						else {
							$query = $query->addSelect("$alias.$relatedAlias as value");
						}
					}
					
					// Filters
					$this->filters = array();
					$relatedModels = array('extraction_kit');
					foreach ( $relatedModels as $model ) {
						if ( $id = $request->getParameter("dna_extraction_$model") ) {
							$foreignKey = sfInflector::foreign_key($model);
							$model = sfInflector::camelize($model);
							$table = call_user_func(array("{$model}Table", 'getInstance'));
							
							$this->filters[$model] = $table->find($id)->getName();
							$query = $query->andWhere("$alias.$foreignKey = ?", $id);
						}
					}
										
					if ( $aliquots = $request->getParameter('dna_extraction_aliquots') ) {
						$this->filters['Aliquots'] = $aliquots;
						$query = $query->andWhere("$alias.aliquots = ?", $aliquots);
					}
					
					if ( $concentration = $request->getParameter('dna_extraction_concentration') ) {
						$this->filters['Concentration'] = $concentration;
						$query = $query->andWhere("$alias.concentration = ?", $concentration);
					}
					
					if ( $ratio280 = $request->getParameter('dna_extraction_260_280_ratio') ) {
						$this->filters['260_280_ratio'] = $ratio280;
						$query = $query->andWhere("$alias.260_280_ratio = ?", $ratio280);
					}
					
					if ( $ratio230 = $request->getParameter('dna_extraction_260_230_ratio') ) {
						$this->filters['260_230_ratio'] = $ratio230;
						$query = $query->andWhere("$alias.260_230_ratio = ?", $ratio230);
					}
					break;
				
				case 'location':
				default:
					// Group by
					if ( $this->modelToGroupBy = $request->getParameter('location_group_by') ) {
						$query = $query
							->addSelect("COUNT($alias.id) as n_locations")
							->innerJoin("$alias.".sfInflector::camelize($this->modelToGroupBy)." m")
							->leftJoin("$alias.Samples s")
							->addSelect("COUNT(s.id) as n_samples")
							->groupBy("$alias.".sfInflector::foreign_key($this->modelToGroupBy))
							->addSelect('m.name as value');
					}
					
					// Filters
					$this->filters = array();
					$relatedModels = array('country', 'region', 'island');
					foreach ( $relatedModels as $model ) {
						if ( $id = $request->getParameter("location_$model") ) {
							$foreignKey = sfInflector::foreign_key($model);
							$model = sfInflector::camelize($model);
							$table = call_user_func(array("{$model}Table", 'getInstance'));
							
							$this->filters[$model] = $table->find($id)->getName();
							$query = $query->andWhere("$alias.$foreignKey = ?", $id);
						}
					}
					break;
			}
			
			if ( $this->modelToGroupBy === '0' ) {
				$this->modelToGroupBy = false;
			}
			$this->results = $query->execute();
		}
	}
	
}
