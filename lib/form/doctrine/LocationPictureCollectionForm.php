<?php

/**
* LocationPictureCollection form.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class LocationPictureCollectionForm extends sfForm
{
	public function configure()
	{
		if ( !$location = $this->getOption('location') )
		{
			throw new InvalidArgumentException('You must provide a location object.');
		}

		for ($i = 1; $i <= sfConfig::get('app_max_location_pictures'); $i++)
		{
			$locationPicture = new LocationPicture();
			$locationPicture->Location = $location;

			$form = new LocationPictureForm($locationPicture);
			unset($form['id']);

			$this->embedForm($i, $form);
		}
		
		$this->mergePostValidator(new LocationPictureValidatorSchema());
	}
}
