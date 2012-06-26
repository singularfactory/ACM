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
 * location actions
 *
 * @package ACM.Frontend
 * @subpackage location
 */
class locationActions extends MyActions {
	/**
	 * Shows a list of locations
	 */
	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'Location', array('init' => false));
		$filters = $this->_processFilterConditions($request, 'location');

		$query = null;
		if (count($filters)) {
			if (!empty($filters['group_by'])) {
				$query = LocationTable::getInstance()->createQuery($this->mainAlias())->select("{$this->mainAlias()}.*");
				$this->groupBy = $filters['group_by'];

				$query = $query
					->addSelect('m.name as value')
					->addSelect("COUNT(DISTINCT {$this->mainAlias()}.id) as n_locations")
					->addSelect("COUNT(DISTINCT s.id) as n_samples")
					->addSelect("COUNT(DISTINCT st.id) as n_strains")
					->innerJoin("{$this->mainAlias()}.".sfInflector::camelize($this->groupBy)." m")
					->leftJoin("{$this->mainAlias()}.Samples s")
					->leftJoin('s.Strains st')
					->groupBy("{$this->mainAlias()}.".sfInflector::foreign_key($this->groupBy));
			} else {
				$query = $this->pager->getQuery();
			}

			$query = $query
				->leftJoin("{$this->mainAlias()}.Country c")
				->leftJoin("{$this->mainAlias()}.Region r")
				->leftJoin("{$this->mainAlias()}.Island i")
				->leftJoin("{$this->mainAlias()}.Category cat")
				->where('1=1');

			foreach (array('country_id', 'region_id', 'island_id', 'category_id') as $filter) {
				if (!empty($filters[$filter])) {
					$query = $query->andWhere("{$this->mainAlias()}.$filter = ?", $filters[$filter]);

					$model = sfInflector::camelize(str_replace('_id', '', $filter));
					$table = $model === 'Category' ? 'LocationCategoryTable' : $model.'Table';
					$table = call_user_func(array($table, 'getInstance'));
					$this->filters[$filter] = $table->find($filters[$filter])->getName();
				}
			}

			if (!empty($filters['name'])) {
				$query = $query->andWhere("{$this->mainAlias()}.name LIKE ?", "%{$filters['name']}%");
			}
		} else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Country c")
				->leftJoin("{$this->mainAlias()}.Region r")
				->leftJoin("{$this->mainAlias()}.Island i")
				->leftJoin("{$this->mainAlias()}.Samples s");
		}

		if (empty($filters['group_by'])) {
			$this->pager->setQuery($query);
			$this->pager->init();
			$this->results = $this->pager->getResults();
		} else {

			$this->results = $query->execute();
		}

		// Keep track of the last page used in list
		$this->getUser()->setAttribute('location.index_page', $request->getParameter('page'));

		// Add a form to filter results
		$this->form = new LocationForm(array(), array('search' => true));
	}

	/**
	 * Shows location details
	 */
	public function executeShow(sfWebRequest $request) {
		$this->location = Doctrine_Core::getTable('Location')->find(array($request->getParameter('id')));

		// Configure a Google Map to show the location
		$this->googleMap = new MyGoogleMap();
		$coordinates = $this->location->getGPSCoordinates();
		$information = array(
			'title' => $this->location->getName(),
			'description' => "{$this->location->getRegion()->getName()}, {$this->location->getIsland()->getName()}",
			'notes' => $this->location->getRemarks());
		if ($coordinates['latitude'] && $coordinates['longitude']) {
			$marker = $this->googleMap->getMarkerFromCoordinates($coordinates['latitude'], $coordinates['longitude'], $information);
		} else {
			$marker = $this->googleMap->getMarkerFromAddress("{$information['title']}, {$information['description']}, {$this->location->getCountry()->getName()}", $information);
		}

		$this->googleMap->addMarker($marker);
		$this->googleMap->addMarker($this->googleMap->getHomeMarker());
		$this->googleMap->centerAndZoomOnMarkers();
		$this->googleMap->setZoom($this->googleMap->getZoom() - 2);

		$this->forward404Unless($this->location);
	}

	public function executeNew(sfWebRequest $request) {
		if ( $lastLocation = $this->getUser()->getAttribute('location.last_object_created') ) {
			$location = new Location();
			$location->setCountryId($lastLocation->getCountryId());
			$location->setRegionId($lastLocation->getRegionId());
			$location->setLatitude($lastLocation->getLatitude());
			$location->setLongitude($lastLocation->getLongitude());
			$location->setRemarks($lastLocation->getRemarks());

			$this->form = new LocationForm($location);
			$this->form->setIslandChoicesByRegion($lastLocation->getRegionId());
			$this->form->setDefault('island_id', $lastLocation->getIslandId());

			$this->getUser()->setAttribute('location.last_object_created', null);
		}
		else {
			$this->form = new LocationForm();
			$countryId = CountryTable::getInstance()->getDefaultCountryId();
			$regionId = RegionTable::getInstance()->getDefaultRegionId($countryId);
			$islandId = IslandTable::getInstance()->getDefaultIslandId($regionId);
			$this->form->setDefault('country_id', $countryId);
			$this->form->setDefault('region_id', $regionId);
			$this->form->setDefault('island_id', $islandId);
		}
	}

	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new LocationForm();

		$this->processForm($request, $this->form);

		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($location = Doctrine_Core::getTable('Location')->find(array($request->getParameter('id'))), sprintf('Object location does not exist (%s).', $request->getParameter('id')));
		$this->form = new LocationForm($location);
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($location = Doctrine_Core::getTable('Location')->find(array($request->getParameter('id'))), sprintf('Object location does not exist (%s).', $request->getParameter('id')));
		$this->form = new LocationForm($location);

		$this->processForm($request, $this->form);

		$this->setTemplate('edit');
	}

	protected function processForm(sfWebRequest $request, sfForm $form) {
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

		// Count files uploaded in form
		$uploadedFiles = $request->getFiles();
		$nbValidFiles = 0;
		if ( $uploadedFiles['location']['new_Pictures'] ) {
			foreach ( $uploadedFiles['location']['new_Pictures'] as $file ) {
				if ( !empty($file['filename']['name']) ) {
					$nbValidFiles += 1;
				}
			}
		}
		$nbFiles = $form->getObject()->getNbPictures() + $nbValidFiles;

		// Validate form
		$flashMessage = null;
		$url = null;
		$location = null;
		if ( $form->isValid() && $nbFiles <= sfConfig::get('app_max_location_pictures') ) {
			try {
				$removablePictures = $this->getRemovablePictures($form);

				$location = $form->save();
				if ( $request->hasParameter('_save_and_add') ) {
					$flashMessage = 'Location created successfully. Now you can add another one';
					$url = '@location_new';
					$this->getUser()->setAttribute('location.last_object_created', $location);
				}
				elseif ( !$form->getObject()->isNew() ) {
					$flashMessage = 'Changes saved';
					$url = '@location_show?id='.$location->getId();
				}
				else {
					$flashMessage = 'Location created successfully';
					$url = '@location_show?id='.$location->getId();
				}

				$this->removePicturesFromFilesystem($removablePictures, sfConfig::get('app_location_pictures_dir'));

				// Update GPS coordinates of every sample (temporary measure)
				foreach ($location->getSamples() as $sample) {
					$sample->setLatitude($location->getLatitude());
					$sample->setLongitude($location->getLongitude());
					$sample->trySave();
				}
			}
			catch (Exception $e) {
				$flashMessage = $e->getMessage();
			}
		}

		if ( $location != null ) {
			$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $location->getId())));
			$this->getUser()->setFlash('notice', $flashMessage);
			$this->redirect($url);
		}
		else {
			$this->getUser()->setFlash('notice', 'The information on this location has some errors you need to fix: '.$flashMessage, false);
		}
	}
}
