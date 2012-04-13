<?php
/**
 * article actions.
 *
 * @package    bna_green_house
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
	 * Executes configure action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeConfigure(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::GET));
		$this->forward404Unless($strain = StrainTable::getInstance()->find(array($request->getParameter('strain_id'))), sprintf('The strain does not exist', $request->getParameter('strain_id')));

		$this->form = new ArticleForm();
		$this->form->setDefault('strain_id', $strain->getId());
		$this->strain = $strain;

		$cultureMediaChoices = array();
		foreach ($strain->getCultureMedia() as $cultureMedium) {
			$cultureMediaChoices[$cultureMedium->getId()] = $cultureMedium->getName();
		}
		$this->form->setWidget('culture_media_list', new sfWidgetFormChoice(array('choices' => $cultureMediaChoices)));
		$this->form->getWidget('culture_media_list')->setLabel(false);

		// Configure a Google Map to show the location
		$this->googleMap = new MyGoogleMap(array(), array('width'=>'300px', 'height'=>'200px'));
		$coordinates = $strain->getSample()->getGPSCoordinates();
		$location = $strain->getSample()->getLocation();
		$marker = $this->googleMap->getMarkerFromCoordinates($coordinates['latitude'], $coordinates['longitude']);
		$this->googleMap->addMarker($marker);
		$this->googleMap->centerAndZoomOnMarkers(1, 6);
		$this->googleMap->setOption('disableDefaultUI', true);
		$this->googleMap->setOption('mapTypeId', 'google.maps.MapTypeId.SATELLITE');
	}

	/**
	 * Executes create action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		$this->forward404Unless($strain = StrainTable::getInstance()->find(array($request->getParameter('strain_id'))), sprintf('The strain does not exist', $request->getParameter('strain_id')));

		$this->form = new ArticleForm();
		$this->form->bind($request->getPostParameters());

		if ( !$this->form->isValid() ) {
			$this->getUser()->setFlash('notice', 'The articles cannot be created with the information you have provided. Make sure everything is OK.');
			$this->redirect('@article_configure_by_id?strain_id='.$strain->getId());
		}
		else {
			$this->setLayout(false);
			$strain = StrainTable::getInstance()->find($request->getParameter('strain_id'));

			//$this->createPdf('0001');
			//return sfView::NONE;
		}
	}

	/**
	 * Creates a PDF using wkhtmltopdf
	 *
	 * @param string $code Strain full code, e.g. BEA0001
	 *
	 * @return boolean False if something goes wrong. Otherwise the execution stops here
	 *
	 * @author Eliezer Talon
	 * @version 2012-04-10
	 * @throws sfStopException
	 */
	protected function createPdf($code) {
		$this->setLayout(false);
		$html = $this->getPartial('create_pdf');

		$pdf = new WKPDF();
		$pdf->set_html($html);
		$pdf->set_orientation('Portrait');
		$pdf->render();
		$pdf->output(WKPDF::$PDF_DOWNLOAD, "{$code}_article.pdf");

	  throw new sfStopException();
	}

}
