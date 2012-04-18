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
?>
<?php

/**
 * isolation actions.
 *
 * @package ACM.Frontend
 * @subpackage isolation
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class isolationActions extends MyActions {

	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'Isolation', array('init' => false, 'sort_column' => 'reception_date'));

		// Deal with search criteria
		if ( $text = $request->getParameter('criteria') ) {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Strain st")
				->leftJoin("{$this->mainAlias()}.ExternalStrain est")
				->leftJoin("{$this->mainAlias()}.Sample sa")
				->leftJoin("st.TaxonomicClass tc")
				->leftJoin("st.Genus g")
				->leftJoin("st.Species sp")
				->leftJoin("est.TaxonomicClass etc")
				->leftJoin("est.Genus eg")
				->leftJoin("est.Species esp")
				->where("{$this->mainAlias()}.id LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.external_code LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.reception_date LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.delivery_date LIKE ?", "%$text%")
				->orWhere('tc.name LIKE ?', "%$text%")
				->orWhere('g.name LIKE ?', "%$text%")
				->orWhere('sp.name LIKE ?', "%$text%")
				->orWhere('etc.name LIKE ?', "%$text%")
				->orWhere('eg.name LIKE ?', "%$text%")
				->orWhere('esp.name LIKE ?', "%$text%")
				->orWhere('st.id LIKE ?', "%$text%")
				->orWhere('sa.id LIKE ?', "%$text%");

			// Keep track of search terms for pagination
			$this->getUser()->setAttribute('search.criteria', $text);
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.ExternalStrain est")
				->leftJoin("{$this->mainAlias()}.Strain st")
				->leftJoin("{$this->mainAlias()}.Sample sa")
				->leftJoin("{$this->mainAlias()}.TaxonomicClass tc")
				->leftJoin("{$this->mainAlias()}.Genus g")
				->leftJoin("{$this->mainAlias()}.Species sp")
				->leftJoin("st.TaxonomicClass sttc")
				->leftJoin("st.Genus stg")
				->leftJoin("st.Species stsp")
				->leftJoin("est.TaxonomicClass esttc")
				->leftJoin("est.Genus estg")
				->leftJoin("est.Species estsp");

			$this->getUser()->setAttribute('search.criteria', null);
		}
		$this->pager->setQuery($query);
		$this->pager->init();

		// Keep track of the last page used in list
		$this->getUser()->setAttribute('isolation.index_page', $request->getParameter('page'));

		// Add a form to filter results
		$this->form = new IsolationForm();
	}

	public function executeShow(sfWebRequest $request) {
		$this->isolation = Doctrine_Core::getTable('Isolation')->find(array($request->getParameter('id')));
		$this->forward404Unless($this->isolation);
	}

	protected function configureFormByIsolationSubject(sfForm $form, $subject = 'sample') {
		$form->setDefault('isolation_subject', $subject);
		switch( $subject ) {
			case 'external':
				unset($form['sample_id']);
				unset($form['strain_id']);
				unset($form['external_strain_id']);
				break;

			case 'strain':
				unset($form['external_code']);
				unset($form['location_id']);
				unset($form['sample_id']);
				unset($form['environment_id']);
				unset($form['habitat_id']);
				unset($form['taxonomic_class_id']);
				unset($form['genus_id']);
				unset($form['species_id']);
				unset($form['authority_id']);
				unset($form['external_strain_id']);
				break;

			case 'external_strain':
				unset($form['external_code']);
				unset($form['location_id']);
				unset($form['sample_id']);
				unset($form['environment_id']);
				unset($form['habitat_id']);
				unset($form['taxonomic_class_id']);
				unset($form['genus_id']);
				unset($form['species_id']);
				unset($form['authority_id']);
				unset($form['strain_id']);
				break;

			case 'sample':
			default:
				unset($form['external_code']);
				unset($form['location_id']);
				unset($form['strain_id']);
				unset($form['environment_id']);
				unset($form['habitat_id']);
				unset($form['taxonomic_class_id']);
				unset($form['genus_id']);
				unset($form['species_id']);
				unset($form['authority_id']);
				unset($form['external_strain_id']);
				break;
		}
	}

	public function executeNew(sfWebRequest $request) {
		if ( $lastIsolation = $this->getUser()->getAttribute('isolation.last_object_created') ) {
			$isolation = new Isolation();

			$isolation->setExternalStrainId($lastIsolation->getExternalStrainId());
			$isolation->setStrainId($lastIsolation->getStrainId());
			$isolation->setSampleId($lastIsolation->getSampleId());
			$isolation->setReceptionDate($lastIsolation->getReceptionDate());
			$isolation->setTaxonomicClassId($lastIsolation->getTaxonomicClassId());
			$isolation->setGenusId($lastIsolation->getGenusId());
			$isolation->setSpeciesId($lastIsolation->getSpeciesId());
			$isolation->setAuthorityId($lastIsolation->getAuthorityId());
			$isolation->setLocationId($lastIsolation->getLocationId());
			$isolation->setEnvironmentId($lastIsolation->getEnvironmentId());
			$isolation->setHabitatId($lastIsolation->getHabitatId());
			$isolation->setPurificationMethodId($lastIsolation->getPurificationMethodId());

			$this->form = new IsolationForm($isolation);
			$this->getUser()->setAttribute('isolation.last_object_created', null);
		}
		else {
			$this->form = new IsolationForm();
		}

		if ( $subject = $request->getParameter('subject') ) {
			$this->configureFormByIsolationSubject($this->form, $subject);
		}
		else {
			$this->configureFormByIsolationSubject($this->form);
		}

		$this->hasPurificationMethods = (PurificationMethodTable::getInstance()->count() > 0)?true:false;
	}

	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new IsolationForm();
		$isolation = $request->getParameter('isolation');
		$this->configureFormByIsolationSubject($this->form, $isolation['isolation_subject']);
		$this->hasPurificationMethods = (PurificationMethodTable::getInstance()->count() > 0)?true:false;

		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($isolation = IsolationTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object isolation does not exist (%s).', $request->getParameter('id')));
		$this->form = new IsolationForm($isolation);

		if ( $subject = $request->getParameter('subject') ) {
			$this->configureFormByIsolationSubject($this->form, $subject);
		}
		else {
			$this->configureFormByIsolationSubject($this->form, $isolation->getIsolationSubject());
		}
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($isolation = IsolationTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object isolation does not exist (%s).', $request->getParameter('id')));

		$this->form = new IsolationForm($isolation);
		$isolation = $request->getParameter('isolation');
		$this->configureFormByIsolationSubject($this->form, $isolation['isolation_subject']);
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
			$isolation = null;
			try {
				$isolation = $form->save();

				if ( $request->hasParameter('_save_and_add') ) {
					$message = 'Isolation created successfully. Now you can add another one';
					$url = '@isolation_new';

					// Reuse last object values
					$this->getUser()->setAttribute('isolation.last_object_created', $isolation);
				}
				elseif ( !$isNew ) {
					$message = 'Changes saved';
					$url = '@isolation_show?id='.$isolation->getId();
				}
				else {
					$message = 'Isolation created successfully';
					$url = '@isolation_show?id='.$isolation->getId();
				}
			}
			catch (Exception $e) {
				$message = $e->getMessage();
			}

			if ( $isolation != null ) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $isolation->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ( $url !== null ) {
					$this->redirect($url);
				}
			}
		}

		$this->getUser()->setFlash('notice', 'The information on this isolation has some errors you need to fix', false);
	}

}
