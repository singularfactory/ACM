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
 * sample actions.
 *
 * @package ACM.Frontend
 * @subpackage sample
 */
class sampleActions extends MyActions {
	/**
	 * Shows a list of samples
	 */
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'Sample', array('init' => false, 'sort_column' => 'id'));
		$filters = $this->_processFilterConditions($request, 'sample');

		$query = null;
		if (count($filters)) {
			if (!empty($filters['group_by'])) {
				$query = SampleTable::getInstance()->createQuery($this->mainAlias())->select("{$this->mainAlias()}.*");
				$this->groupBy = $filters['group_by'];

				if (in_array($this->groupBy, array('ph', 'conductivity', 'temperature', 'salinity', 'altitude'))) {
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
					->addSelect("COUNT(DISTINCT {$this->mainAlias()}.id) as n_samples")
					->addSelect("COUNT(DISTINCT st.id) as n_strains")
					->leftJoin("{$this->mainAlias()}.Strains st")
					->groupBy("{$this->mainAlias()}.$relatedForeignKey");

				if ($recursive) {
					$query = $query->innerJoin("{$this->mainAlias()}.$relatedAlias m");
					$query = $query->addSelect('m.name as value');
				} else {
					$query = $query->addSelect("{$this->mainAlias()}.$relatedAlias as value");
				}
			} else {
				$query = $this->pager->getQuery();
			}

			$query = $query
				->leftJoin("{$this->mainAlias()}.Location l")
				->leftJoin("{$this->mainAlias()}.Environment e")
				->leftJoin("{$this->mainAlias()}.Habitat h")
				->leftJoin("{$this->mainAlias()}.Radiation r")
				->leftJoin("{$this->mainAlias()}.Collectors c")
				->where('1=1');

			foreach (array('environment_id', 'habitat_id', 'radiation_id') as $filter) {
				if (!empty($filters[$filter])) {
					$query = $query->andWhere("{$this->mainAlias()}.$filter = ?", $filters[$filter]);

					$table = sprintf('%sTable', sfInflector::camelize(str_replace('_id', '', $filter)));
					$table = call_user_func(array($table, 'getInstance'));
					$this->filters[$filter] = $table->find($filters[$filter])->getName();
				}
			}

			if (!empty($filters['is_extremophile'])) {
				$this->filters['Extremophile'] = ($filters['is_extremophile'] == 1) ? 'no' : 'yes';
				$query = $query->andWhere("{$this->mainAlias()}.is_extremophile = ?", ($filters['is_extremophile'] == 1) ? 0 : 1);
			}

			if (!empty($filters['location_details'])) {
				$this->filters['Location details'] = $filters['location_details'];
				$query = $query->andWhere("{$this->mainAlias()}.location_details LIKE ?", "%{$filters['location_details']}%");
			}

			if (!empty($filters['id'])) {
				$this->filters['Code'] = $filters['id'];
				preg_match('/^(\d{1,4}).*$/', $filters['id'], $matches);
				$query = $query->andWhere("{$this->mainAlias()}.id = ?", $matches[1]);
			}

		} else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Location l")
				->leftJoin("{$this->mainAlias()}.Collectors c")
				->leftJoin("{$this->mainAlias()}.Strains s");
		}

		if (empty($filters['group_by'])) {
			$this->pager->setQuery($query);
			$this->pager->init();
			$this->results = $this->pager->getResults();
		} else {

			$this->results = $query->execute();
		}

		// Keep track of the last page used in list
		$this->getUser()->setAttribute('sample.index_page', $request->getParameter('page'));

		// Add a form to filter results
		$this->form = new SampleForm(array(), array('search' => true));
	}

	/**
	 * Shows sample details
	 */
	public function executeShow(sfWebRequest $request) {
		$this->sample = Doctrine_Core::getTable('Sample')->find(array($request->getParameter('id')));

		// Configure a Google Map to show the location
		$this->googleMap = new MyGoogleMap();
		$coordinates = $this->sample->getGPSCoordinates();
		$location = $this->sample->getLocation();
		$information = array(
			'title' => $location->getName(),
			'description' => "{$location->getName()}, {$location->getRegion()->getName()}, {$location->getIsland()->getName()}",
			'notes' => $this->sample->getRemarks());
		if ( $coordinates['latitude'] && $coordinates['longitude'] ) {
			$marker = $this->googleMap->getMarkerFromCoordinates($coordinates['latitude'], $coordinates['longitude'], $information);
		}
		else {
			$marker = $this->googleMap->getMarkerFromAddress("{$information['description']}, {$location->getCountry()->getName()}", $information);
		}
		$this->googleMap->addMarker($marker);
		$this->googleMap->addMarker($this->googleMap->getHomeMarker());
		$this->googleMap->centerAndZoomOnMarkers(1);

		$this->forward404Unless($this->sample);
	}

	public function executeNew(sfWebRequest $request) {
		if ( $lastSample = $this->getUser()->getAttribute('sample.last_object_created') ) {
			$sample = new Sample();
			$sample->setLocationId($lastSample->getLocationId());
			$sample->setLatitude($lastSample->getLatitude());
			$sample->setLongitude($lastSample->getLongitude());
			$sample->setEnvironmentId($lastSample->getEnvironmentId());
			$sample->setIsExtremophile($lastSample->getIsExtremophile());
			$sample->setHabitatId($lastSample->getHabitatId());
			$sample->setPh($lastSample->getPh());
			$sample->setConductivity($lastSample->getConductivity());
			$sample->setTemperature($lastSample->getTemperature());
			$sample->setSalinity($lastSample->getSalinity());
			$sample->setAltitude($lastSample->getAltitude());
			$sample->setRadiationId($lastSample->getRadiationId());
			$sample->setCollectionDate($lastSample->getCollectionDate());
			$sample->setRemarks($lastSample->getRemarks());

			$this->form = new SampleForm($sample);
			$this->locationName = $lastSample->getLocation()->getName();
			$this->getUser()->setAttribute('sample.last_object_created', null);
		}
		else {
			$this->form = new SampleForm();
			$this->locationName = null;
		}

		$this->hasLocations = (Doctrine::getTable('Location')->count() > 0)?true:false;
	}

	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new SampleForm();
		$this->hasLocations = (Doctrine::getTable('Location')->count() > 0)?true:false;

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($sample = Doctrine_Core::getTable('Sample')->find(array($request->getParameter('id'))), sprintf('Object sample does not exist (%s).', $request->getParameter('id')));
		$this->form = new SampleForm($sample);
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($sample = Doctrine_Core::getTable('Sample')->find(array($request->getParameter('id'))), sprintf('Object sample does not exist (%s).', $request->getParameter('id')));
		$this->form = new SampleForm($sample);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	protected function processForm(sfWebRequest $request, sfForm $form) {
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		$uploadedFiles = $request->getFiles();

		// Count field pictures uploaded in form
		$nbValidFieldPictures = 0;
		if ( $uploadedFiles['sample']['new_FieldPictures'] ) {
			foreach ( $uploadedFiles['sample']['new_FieldPictures'] as $file ) {
				if ( !empty($file['filename']['name']) ) {
					$nbValidFieldPictures += 1;
				}
			}
		}
		$nbFieldPictures = $form->getObject()->getNbFieldPictures() + $nbValidFieldPictures;

		// Count detailed pictures uploaded in form
		$nbValidDetailedPictures = 0;
		if ( $uploadedFiles['sample']['new_DetailedPictures'] ) {
			foreach ( $uploadedFiles['sample']['new_DetailedPictures'] as $file ) {
				if ( !empty($file['filename']['name']) ) {
					$nbValidDetailedPictures += 1;
				}
			}
		}
		$nbDetailedPictures = $form->getObject()->getNbDetailedPictures() + $nbValidDetailedPictures;

		// Count microscopic pictures uploaded in form
		$nbValidMicroscopicPictures = 0;
		if ( $uploadedFiles['sample']['new_MicroscopicPictures'] ) {
			foreach ( $uploadedFiles['sample']['new_MicroscopicPictures'] as $file ) {
				if ( !empty($file['filename']['name']) ) {
					$nbValidMicroscopicPictures += 1;
				}
			}
		}
		$nbMicroscopicPictures = $form->getObject()->getNbMicroscopicPictures() + $nbValidMicroscopicPictures;

		// Detect invalid number of pictures
		$pictureCountIsValid = ($nbFieldPictures <= sfConfig::get('app_max_sample_field_pictures')) &&
			($nbDetailedPictures <= sfConfig::get('app_max_sample_detailed_pictures')) &&
			($nbMicroscopicPictures <= sfConfig::get('app_max_sample_microscopic_pictures'));

		// Validate form
		if ( $form->isValid() && $pictureCountIsValid ) {
			$flashMessage = null;
			$url = null;
			$isNew = $form->getObject()->isNew();

			// Detect pictures that must be deleted
			$removablePictures = $this->getRemovablePictures($form, 'FieldPictures');
			$removablePictures = array_merge($removablePictures, $this->getRemovablePictures($form, 'DetailedPictures'));
			$removablePictures = array_merge($removablePictures, $this->getRemovablePictures($form, 'MicroscopicPictures'));

			// Save object
			$sample = null;
			try {
				$sample = $form->save();

				if ( $request->hasParameter('_save_and_add') ) {
					$message = 'Sample created successfully. Now you can add another one';
					$url = '@sample_new';

					// Reuse last object values
					$this->getUser()->setAttribute('sample.last_object_created', $sample);
				}
				elseif ( !$isNew ) {
					$message = 'Changes saved';
					$url = '@sample_show?id='.$sample->getId();
				}
				else {
					$message = 'Sample created successfully';
					$url = '@sample_show?id='.$sample->getId();
				}

				// Remove Location pictures
				$this->removePicturesFromFilesystem($removablePictures, sfConfig::get('app_sample_pictures_dir'));
			}
			catch (Exception $e) {
				$message = $e->getMessage();
			}

			if ( $sample != null ) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $sample->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ( $url !== null ) {
					$this->redirect($url);
				}
			}
		}

		$this->getUser()->setFlash('notice', 'The information on this sample has some errors you need to fix', false);
	}

	/**
	 * Create labels for Sample records
	 *
	 * @param sfWebRequest $request Request information
	 * @return void
	 */
	public function executeCreateLabel(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::GET));
		$id = $request->getParameter('id');
		$this->forward404Unless($sample = SampleTable::getInstance()->find(array($id)), sprintf('Object sample does not exist (%s).', $id));

		if ($request->isMethod(sfRequest::POST)) {
			$values = $request->getPostParameters();
			$this->label = $sample;
			$this->copies = $values['copies'];

			$this->setLayout(false);
			$pdf = new WKPDF();
			$pdf->set_html($this->getPartial('create_pdf'));
			$pdf->set_orientation('Landscape');
			$pdf->render();
			$pdf->output(WKPDF::$PDF_DOWNLOAD, "sample_labels.pdf");
			throw new sfStopException();
		} else {
			$this->form = new SampleLabelForm($sample);
			$this->sample = $sample;
		}
	}
}
