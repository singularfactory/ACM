<?php

/**
* EcosystemPictureCollection form.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class EcosystemPictureCollectionForm extends sfForm
{
	public function configure()
	{
		if ( !$ecosystem = $this->getOption('ecosystem') )
		{
			throw new InvalidArgumentException('You must provide an ecosystem object.');
		}

		for ($i = 1; $i <= sfConfig::get('app_max_ecosystem_pictures'); $i++)
		{
			$ecosystemPicture = new EcosystemPicture();
			$ecosystemPicture->Ecosystem = $ecosystem;

			$form = new EcosystemPictureForm($ecosystemPicture);
			unset($form['id']);

			$this->embedForm($i, $form);
		}
		
		$this->mergePostValidator(new EcosystemPictureValidatorSchema());
	}
}
