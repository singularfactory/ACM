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
 * report module actions
 *
 * @package ACM.Frontend
 * @subpackage report
 */
class reportActions extends myActions {
	/**
	* Executes configure action
	*
	* @param sfRequest $request A request object
	*/
	public function executeConfigure(sfWebRequest $request) {
		if ( !($subject = $request->getParameter('subject')) ) {
			$subject = 'maintenance';
		}

		if ( $request->isXmlHttpRequest() ) {
			return $this->renderPartial("{$subject}_form", array('form' => new ReportForm()));
		}

		$this->form = new ReportForm();
		$this->form->setDefault('subject', $subject);
		$this->subject = $subject;
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
		if (array_key_exists('maintenance_strain_search', $taintedValues)) {
			unset($taintedValues['maintenance_strain_search']);
		}

		// Validate form
		$this->form = new ReportForm();
		$this->form->bind($taintedValues);
		$this->subject = $request->getParameter('subject');

		if (!$this->form->isValid()) {
			$this->getUser()->setFlash('notice', 'The report cannot be generated with the information you have provided. Make sure everything is OK.');
			$this->setTemplate('configure');
		}
		else {
			switch ($request->getParameter('subject')) {
				case 'maintenance':
				default:
					$values = $request->getPostParameters();

					//Obtains all the strain id's for the maintenance report validator
					$this->strains = StrainTable::getInstance()
						->createQuery('u')
						->whereIn('u.id', $values['maintenance_strain_id'])
						->execute();

					$this->setLayout(false);
					$pdf = new WKPDF();
					$pdf->set_html($this->getPartial('maintenance_pdf'));
					$pdf->render();
					$pdf->output(WKPDF::$PDF_DOWNLOAD, "maintenance_report.pdf");
					throw new sfStopException();
					break;
			}
		}
	}
}
