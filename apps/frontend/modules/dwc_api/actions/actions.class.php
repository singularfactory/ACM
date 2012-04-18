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
 * dwc_api actions.
 *
 * @package ACM.Frontend
 * @subpackage dwc_api
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dwc_apiActions extends GreenhouseAPI {

	protected $xmlErrors = false;

	protected function createEmptyXml() {
		// Clear previous XML errors
		$this->xmlErrors = false;

		// Load the XML document template
		libxml_use_internal_errors(true);
		$xml = simplexml_load_string($this->getPartial('xml_empty'));

		// Retrieve the messages in case of error
		if ( !$xml ) {
			$errors = libxml_get_errors();
			$separator = (count($errors)) ? '' : '';

			foreach( $errors as $error ) {
				$this->xmlErrors .= $error->message.$separator;
			}
			$this->xmlErrors = str_replace("\n", '', $this->xmlErrors);
		}

		return $xml;
	}

	public function executeGetStrains(sfWebRequest $request) {
		if ( !$this->validateRequestMethod($request, sfRequest::GET) ) {
			return $this->requestExitStatus(self::InvalidRequestMethod, 'This resource only admits GET requests');
		}

		if ( !$this->validateToken($request->getParameter('token')) ) {
			return $this->requestExitStatus(self::InvalidToken);
		}

		// Create an empty XML document
		$xml = $this->createEmptyXml();
		if ( $this->xmlErrors ) {
			return $this->requestExitStatus(self::ServerError, "The XML document could not be created ({$this->xmlErrors})");
		}

		// Retrieve information from strains
		try {
			foreach ( StrainTable::getInstance()->findAll() as $strain ) {
				$record = $xml->addChild('dwr:SimpleDarwinRecord');

				// Common attributes
				$record->addChild('dcterms:language', 'en');
				$record->addChild('dcterms:rightsHolder', 'Banco Español de Algas');
				$record->addChild('dwc:institutionID', 'Banco Español de Algas');
				$record->addChild('dwc:institutionCode', 'BEA');
				$record->addChild('dwc:basisOfRecord', 'LivingSpecimen');
				$record->addChild('dwc:collectionCode', 'Algae strains');

				// Strain attributes
				$record->addChild('dwc:occurrenceID', $strain->getFullCode());
				$record->addChild('dwc:catalogNumber', $strain->getFullCode());
				$record->addChild('dcterms:modified', $strain->getUpdatedAt());
				$record->addChild('dwc:eventDate', $strain->getIsolationDate());
				$record->addChild('dwc:eventRemarks', $strain->getObservation());
				$record->addChild('dwc:associatedReferences', $strain->getCitations());
				$record->addChild('dwc:occurrenceRemarks', $strain->getRemarks());
				$record->addChild('dwc:dynamicProperties', sprintf('isAxenic=%s', $strain->getIsAxenic()));

				// Strain taxonomic description
				$record->addChild('dwc:class', $strain->getTaxonomicClass()->getName());
				$record->addChild('dwc:genus', sprintf('%s %s', $strain->getGenus()->getName(), $strain->getSpecies()->getName()));
				$record->addChild('dwc:scientificNameAuthorship', $strain->getAuthority()->getName());
				$identifier = $strain->getIdentifier();
				$record->addChild('dwc:identifiedBy', sprintf('%s %s', $identifier->getName(), $identifier->getSurname()));

				// Strain attributes inherited from Sample
				if ( $sample = $strain->getSample() ) {
					$record->addChild('dwc:habitat', $sample->getHabitat()->getName());
					$record->addChild('dwc:fieldNotes', $sample->getRemarks());
					$record->addChild('dwc:minimumElevationInMeters', $sample->getAltitude());
	        $record->addChild('dwc:maximumElevationInMeters', $sample->getAltitude());
					$record->addChild('dwc:decimalLatitude', $sample->getLatitude());
	        $record->addChild('dwc:decimalLongitude', $sample->getLongitude());
					$record->addChild('dwc:locality', $sample->getLocationDetails());

					// Strain attributes inherited from Location
					if ( $location = $sample->getLocation() ) {
						$record->addChild('dwc:country', $location->getCountry()->getName());
		        $record->addChild('dwc:countryCode', $location->getCountry()->getCode());
		        $record->addChild('dwc:stateProvince', $location->getRegion()->getName());
						if ( $island = $location->getIsland() ) {
							$record->addChild('dwc:island', $island);
						}
					}

					// Unofficial attributes
					$record->addChild('dwc:dynamicProperties', sprintf('environment=%s', $sample->getEnvironment()->getName()));
					$record->addChild('dwc:dynamicProperties', sprintf('habitat=%s', $sample->getHabitat()->getName()));
					$record->addChild('dwc:dynamicProperties', sprintf('ph=%s', $sample->getPh()));
					$record->addChild('dwc:dynamicProperties', sprintf('conductivity=%s', $sample->getConductivity()));
					$record->addChild('dwc:dynamicProperties', sprintf('temperatureInDegrees=%s', $sample->getTemperature()));
					$record->addChild('dwc:dynamicProperties', sprintf('salinity=%s', $sample->getSalinity()));
					$record->addChild('dwc:dynamicProperties', sprintf('radiation=%s', $sample->getRadiation()->getName()));
					$record->addChild('dwc:dynamicProperties', sprintf('isExtremophile=%s', $sample->getIsExtremophile()));
				}

				foreach ( $strain->getIsolators() as $isolator ) {
					$record->addChild('dwc:recordedBy', "$isolator");
				}

				foreach ( $strain->getMaintenanceStatus() as $status ) {
					$status = $status->getName();
					if ( $status === 'Cryopreserved' ) {
						$status = sprintf('%s (%s)', $status, $strain->getCryopreservationMethod()->getName());
					}
					$record->addChild('dwc:preparations', $status);
				}

				foreach ( $strain->getCultureMedia() as $medium ) {
					$record->addChild('dwc:preparations', $medium->getName());
				}
			}
		}
		catch (Exception $e) {
			return $this->requestExitStatus(self::ServerError, "The XML document was created but it's empty ({$e->getMessage()})");
		}

		$this->getResponse()->setContentType('text/xml');
		return $this->requestExitStatus(self::RequestSuccess, $xml->asXML());
	}

}
