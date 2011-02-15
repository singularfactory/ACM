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
	$this->useFields(array(
		'id',
	    'name',
	    'latitude_degrees',
	    'longitude_degrees',
	    'latitude_minutes',
	    'longitude_minutes',
	    'country_id',
	    'province_id',
	    'city',
	    'picture',
		'remarks',
	));
	
	
	$q = Doctrine_Query::create()
		->from('Country c')
		->where('c.name = ?', 'Spain');
	$countries = $q->execute();
		
	if ( !empty($countries) )
	{
		$this->setDefault('country_id', $countries[0]->getId());
	}
	else
	{
		$this->setDefault('country_id', 208);
	}
	
	$this->setWidget('picture', new sfWidgetFormInputFile());
	$this->setValidator('picture', new sfValidatorFile(array('path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_ecosystem_pictures_directory'), 'required' => false)));
  }
}
