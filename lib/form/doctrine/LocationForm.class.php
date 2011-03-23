<?php

/**
 * Location form.
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LocationForm extends BaseLocationForm
{
  	public function configure()
	{
		// Create an embedded form to add pictures
		$this->embedRelations(array(
			'Pictures' => array(
				'considerNewFormEmptyFields' => array('filename', 'location_id'),
				'newFormLabel' => 'Pictures',
				'newFormAfterExistingRelations' => true,
				'multipleNewForms' => true,
				'newFormsInitialCount' => 1,
				'newRelationButtonLabel' => 'Add another picture',
			),
		));

		// Hide widgets
		unset($this['created_at'], $this['updated_at']);

		// Configure help messages
		$this->widgetSchema->setHelp('latitude', 'Degrees, minutes and seconds (e.g. 43º23\'23")');
		$this->widgetSchema->setHelp('longitude', 'Degrees, minutes and seconds (e.g. 43º23\'23")');
		$this->widgetSchema->setHelp('region_id', 'States and provinces as well');
		$this->widgetSchema->setHelp('island_id', 'Only for regions with islands');
		$this->widgetSchema->setHelp('new_Pictures', 'Only JPG, PNG or TIFF images. 5MB image maximum size');
		
		// Remove <br /> tag after labels and set custom tag
		$this->getWidgetSchema()->getFormFormatter()->setHelpFormat('<p class="input_help">%help%</p>');
	}
}
