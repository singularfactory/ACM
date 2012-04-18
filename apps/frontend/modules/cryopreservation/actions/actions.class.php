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
 * cryopreservation actions.
 *
 * @package ACM.Frontend
 * @subpackage cryopreservation
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cryopreservationActions extends MyActions {

	public function executeIndex(sfWebRequest $request) {
		// Initiate the pager with default parameters but delay pagination until search criteria has been added
		$this->pager = $this->buildPagination($request, 'Cryopreservation', array('init' => false, 'sort_column' => 'id'));

		// Deal with search criteria
		if ( $text = $request->getParameter('criteria') ) {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Strain st")
				->leftJoin("{$this->mainAlias()}.ExternalStrain est")
				->leftJoin("{$this->mainAlias()}.Sample sa")
				->leftJoin("{$this->mainAlias()}.CryopreservationMethod cm")
				->leftJoin("st.TaxonomicClass tc")
				->leftJoin("st.Genus g")
				->leftJoin("st.Species sp")
				->leftJoin("est.TaxonomicClass etc")
				->leftJoin("est.Genus eg")
				->leftJoin("est.Species esp")
				->where("{$this->mainAlias()}.id LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.remarks LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.cryopreservation_date LIKE ?", "%$text%")
				->orWhere("{$this->mainAlias()}.revival_date LIKE ?", "%$text%")
				->orWhere('tc.name LIKE ?', "%$text%")
				->orWhere('g.name LIKE ?', "%$text%")
				->orWhere('sp.name LIKE ?', "%$text%")
				->orWhere('etc.name LIKE ?', "%$text%")
				->orWhere('eg.name LIKE ?', "%$text%")
				->orWhere('esp.name LIKE ?', "%$text%")
				->orWhere('st.id LIKE ?', "%$text%")
				->orWhere('sa.id LIKE ?', "%$text%")
				->orWhere('cm.name LIKE ?', "%$text%");

			// Parse search term to catch strain codes
			if ( preg_match('/([Bb][Ee][Aa])?\s*(\d{1,4})\s*[Bb]?/', $text, $matches) ) {
				$query = $query->orWhere("st.code = ?", (int)$matches[2]);
			}
			else {
				$query = $query->orWhere("st.code LIKE ?", "%$text%");
			}

			// Parse search term to catch sample codes
			if ( preg_match('/0*(\d+)(\w{1,3})_?(\w{1,3})?(\w{1,3}|00)?(\d{2,6})?/', $text, $matches) ) {
				$query = $query->orWhere("sa.id = ?", (int)$matches[1]);
			}

			// Keep track of search terms for pagination
			$this->getUser()->setAttribute('search.criteria', $text);
		}
		else {
			$query = $this->pager->getQuery()
				->leftJoin("{$this->mainAlias()}.Strain st")
				->leftJoin("{$this->mainAlias()}.ExternalStrain est")
				->leftJoin("{$this->mainAlias()}.CryopreservationMethod cm")
				->leftJoin("st.TaxonomicClass tc")
				->leftJoin("st.Genus g")
				->leftJoin("st.Species sp")
				->leftJoin("est.TaxonomicClass etc")
				->leftJoin("est.Genus eg")
				->leftJoin("est.Species esp");

			$this->getUser()->setAttribute('search.criteria', null);
		}
		$this->pager->setQuery($query);
		$this->pager->init();

		// Keep track of the last page used in list
		$this->getUser()->setAttribute('cryopreservation.index_page', $request->getParameter('page'));

		// Add a form to filter results
		$this->form = new CryopreservationForm();
	}

	public function executeShow(sfWebRequest $request) {
		$this->cryopreservation = CryopreservationTable::getInstance()->find(array($request->getParameter('id')));
		$this->forward404Unless($this->cryopreservation);
	}

	protected function configureFormByCryopreservationSubject(sfForm $form, $subject = 'sample') {
		$form->setDefault('subject', $subject);
		switch( $subject ) {
			case 'strain':
				unset($form['sample_id']);
				unset($form['external_strain_id']);
				break;
			case 'external_strain':
				unset($form['sample_id']);
				unset($form['strain_id']);
				break;
			case 'sample':
			default:
				unset($form['strain_id']);
				unset($form['external_strain_id']);
				break;
		}
	}

	public function executeNew(sfWebRequest $request) {
		if ( $lastCryopreservation = $this->getUser()->getAttribute('cryopreservation.last_object_created') ) {
			$cryopreservation = new Cryopreservation();

			$cryopreservation->setStrainId($lastCryopreservation->getStrainId());
			$cryopreservation->setSampleId($lastCryopreservation->getSampleId());
			$cryopreservation->setExternalStrainId($lastCryopreservation->getExternalStrainId());
			$cryopreservation->setCryopreservationMethodId($lastCryopreservation->getCryopreservationMethodId());

			$this->form = new CryopreservationForm($cryopreservation);
			$this->getUser()->setAttribute('cryopreservation.last_object_created', null);
		}
		else {
			$this->form = new CryopreservationForm();
		}

		if ( $subject = $request->getParameter('subject') ) {
			$this->configureFormByCryopreservationSubject($this->form, $subject);
		}
		else {
			$this->configureFormByCryopreservationSubject($this->form);
		}

		$this->hasStrains = (StrainTable::getInstance()->count() > 0)?true:false;
		$this->hasSamples = (SampleTable::getInstance()->count() > 0)?true:false;
		$this->hasExternalStrains = (ExternalStrainTable::getInstance()->count() > 0)?true:false;
	}

	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new CryopreservationForm();
		$cryopreservation = $request->getParameter('cryopreservation');
		$this->configureFormByCryopreservationSubject($this->form, $cryopreservation['subject']);
		$this->hasStrains = (StrainTable::getInstance()->count() > 0)?true:false;
		$this->hasSamples = (SampleTable::getInstance()->count() > 0)?true:false;
		$this->hasExternalStrains = (ExternalStrainTable::getInstance()->count() > 0)?true:false;

		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->forward404Unless($cryopreservation = CryopreservationTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object cryopreservation does not exist (%s).', $request->getParameter('id')));
		$this->form = new CryopreservationForm($cryopreservation);

		if ( $subject = $request->getParameter('subject') ) {
			$this->configureFormByCryopreservationSubject($this->form, $subject);
		}
		else {
			$this->configureFormByCryopreservationSubject($this->form, $cryopreservation->getSubject());
		}
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($cryopreservation = CryopreservationTable::getInstance()->find(array($request->getParameter('id'))), sprintf('Object cryopreservation does not exist (%s).', $request->getParameter('id')));

		$this->form = new CryopreservationForm($cryopreservation);
		$cryopreservation = $request->getParameter('cryopreservation');
		$this->configureFormByCryopreservationSubject($this->form, $cryopreservation['subject']);
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
			$cryopreservation = null;
			try {
				$cryopreservation = $form->save();

				if ( $request->hasParameter('_save_and_add') ) {
					$message = 'Cryopreservation created successfully. Now you can add another one';
					$url = '@cryopreservation_new';

					// Reuse last object values
					$this->getUser()->setAttribute('cryopreservation.last_object_created', $cryopreservation);
				}
				elseif ( !$isNew ) {
					$message = 'Changes saved';
					$url = '@cryopreservation_show?id='.$cryopreservation->getId();
				}
				else {
					$message = 'Cryopreservation created successfully';
					$url = '@cryopreservation_show?id='.$cryopreservation->getId();
				}
			}
			catch (Exception $e) {
				$message = $e->getMessage();
			}

			if ( $cryopreservation != null ) {
				$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log', array('id' => $cryopreservation->getId())));
				$this->getUser()->setFlash('notice', $message);
				if ( $url !== null ) {
					$this->redirect($url);
				}
			}
		}

		$this->getUser()->setFlash('notice', 'The information on this cryopreservation has some errors you need to fix', false);
	}

}
