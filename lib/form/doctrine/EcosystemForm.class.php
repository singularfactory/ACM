<?php

/**
 * Ecosystem form.
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EcosystemForm extends BaseEcosystemForm
{
  public function configure()
  {
	// Create an embedded form to add pictures
	$pictureForm = new EcosystemPictureCollectionForm(null, array('ecosystem' => $this->getObject()));
	$this->embedForm('Pictures', $pictureForm);
	
	// Hide widgets
	unset($this['created_at'], $this['updated_at']);
	
	// Configure help messages
	$this->widgetSchema->setHelp('latitude_degrees', '<span class="ecosystem_form_help">Integer value for the latitude degrees (N) of GPS coordinates (e.g. 15)</span>');
	$this->widgetSchema->setHelp('longitude_degrees', '<span class="ecosystem_form_help">Integer value for the longitude degrees (E) of GPS coordinates (e.g. 42)</span>');
	$this->widgetSchema->setHelp('latitude_minutes', '<span class="ecosystem_form_help">Decimal value for the latitude minutes of GPS coordinates (e.g. 15.3423)</span>');
	$this->widgetSchema->setHelp('longitude_minutes', '<span class="ecosystem_form_help">Introduce a decimal value for the longitude minutes of GPS coordinates (e.g. 38.2832)</span>');	
  }
}
