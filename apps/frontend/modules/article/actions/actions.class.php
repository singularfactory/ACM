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
 * article actions.
 *
 * @package ACM.Frontend
 * @subpackage article
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class articleActions extends MyActions {
	/**
	 * Executes new action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeNew(sfWebRequest $request) {
		$this->form = new ArticleForm();
	}

	/**
	 * Configure a Google Map to show strain location
	 *
	 * @param Strain $strain
	 * @return void
	 */
	public function configureGoogleMap($strain, $width = '300px', $height = '200px') {
		$this->googleMap = new MyGoogleMap(array(), array('width' => $width, 'height' => $height));
		$coordinates = $strain->getSample()->getGPSCoordinates();
		$location = $strain->getSample()->getLocation();
		$marker = $this->googleMap->getMarkerFromCoordinates($coordinates['latitude'], $coordinates['longitude']);
		$this->googleMap->addMarker($marker);
		$this->googleMap->centerAndZoomOnMarkers(1, 6);
		$this->googleMap->setOption('disableDefaultUI', true);
		$this->googleMap->setOption('mapTypeId', 'google.maps.MapTypeId.SATELLITE');
	}

	/**
	 * Executes configure action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeConfigure(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::GET));
		$this->forward404Unless($strain = StrainTable::getInstance()->find(array($request->getParameter('strain_id'))), sprintf('The strain does not exist', $request->getParameter('strain_id')));

		$this->strain = $strain;
		$this->configureGoogleMap($strain);
		$this->form = new ArticleForm(array('strain_id' => $strain->getId()));
	}

	/**
	 * Executes create action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		$this->forward404Unless($strain = StrainTable::getInstance()->find(array($request->getParameter('strain_id'))), sprintf('The strain does not exist', $request->getParameter('strain_id')));

		$this->strain = $strain;
		$this->configureGoogleMap($strain);
		$this->form = new ArticleForm(array('strain_id' => $strain->getId()));
		$this->form->bind($request->getPostParameters());

		if ( !$this->form->isValid() ) {
			$this->getUser()->setFlash('notice', 'The article cannot be created with the information you have provided. Make sure everything is OK.');
			$this->setTemplate('configure');
		}
		else {
			$this->setLayout(false);

			// Build location picture filename with path
			$path = '/uploads';
			$filename = '';
			$locationPictureId = $this->form->getValue('location_picture');
			switch ($this->form->getValue('location_picture_source')) {
				case 'field_picture':
					$path .= sfConfig::get('app_sample_pictures_dir');
					$filename = FieldPictureTable::getInstance()->findOneById($locationPictureId)->getFilename();
					break;
				case 'detailed_picture':
					$path .= sfConfig::get('app_sample_pictures_dir');
					$filename = DetailedPictureTable::getInstance()->findOneById($locationPictureId)->getFilename();
					break;
				case 'location_picture':
					$path .= sfConfig::get('app_location_pictures_dir');
					$filename = LocationPictureTable::getInstance()->findOneById($locationPictureId)->getFilename();
					break;
			}
			$this->locationPicture = $path . '/' . $filename;

			// Build strain picture filename with path
			$path = '/uploads' . sfConfig::get('app_strain_pictures_dir');;
			$filename = StrainPictureTable::getInstance()->findOneById($this->form->getValue('strain_picture'))->getFilename();
			$this->strainPicture = $path . '/' . $filename;

			$latitude = MyGoogleMap::dms_to_decimal_degrees($strain->getSample()->getLatitude());
			$longitude = MyGoogleMap::dms_to_decimal_degrees($strain->getSample()->getLongitude());
			$this->googleMapUrl .= 'http://maps.google.com/maps/api/staticmap?';
			$this->googleMapUrl .= sprintf('center=%f,%f', $latitude, $longitude) . '&';
			$this->googleMapUrl .= 'zoom=6' . '&';
			$this->googleMapUrl .= 'size=270x170' . '&';
			$this->googleMapUrl .= 'maptype=satellite' . '&';
			$this->googleMapUrl .= 'sensor=false' . '&';
			$this->googleMapUrl .= 'markers=size:small%7C'. $latitude . ',' . $longitude;

			$html = $this->getPartial('pdf');
			$pdf = new WKPDF();
			$pdf->set_html($html);
			$pdf->render();
			$pdf->output(WKPDF::$PDF_DOWNLOAD, "{$strain->getFullCode()}_article.pdf");
			throw new sfStopException();
			return sfView::NONE;
		}
	}
}
