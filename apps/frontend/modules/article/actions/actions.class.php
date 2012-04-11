<?php
/**
 * article actions.
 *
 * @package    bna_green_house
 * @subpackage article
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class articleActions extends myActions {
	/**
	 * Executes configure action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeConfigure(sfWebRequest $request) {
		$this->form = new ArticleForm();
	}

	/**
	 * Executes create action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeCreate(sfWebRequest $request) {
		$this->forward404Unless($request->isMethod(sfRequest::POST));

		$this->form = new ArticleForm();
		$this->form->bind($request->getPostParameters());

		if ( !$this->form->isValid() ) {
			$this->getUser()->setFlash('notice', 'The articles cannot be created with the information you have provided. Make sure everything is OK.');
			$this->setTemplate('configure');
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
