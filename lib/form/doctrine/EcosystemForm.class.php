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
	    'picture_1',
		'picture_2',
		'picture_3',
		'picture_4',
		'picture_5',
		'remarks',
	));
	
	// Set default country to Spain
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
	
	// Set default province to Las Palmas
	$q = Doctrine_Query::create()
		->from('Province p')
		->where('p.name = ?', 'Las Palmas');
	$provinces = $q->execute();
		
	if ( !empty($provinces) )
	{
		$this->setDefault('province_id', $provinces[0]->getId());
	}
	else
	{
		$this->setDefault('province_id', 28);
	}
	
	$this->setWidget('picture_1', new sfWidgetFormInputFile());
	$this->setWidget('picture_2', new sfWidgetFormInputFile());
	$this->setWidget('picture_3', new sfWidgetFormInputFile());
	$this->setWidget('picture_4', new sfWidgetFormInputFile());
	$this->setWidget('picture_5', new sfWidgetFormInputFile());
	
	$this->setValidator('picture_1', new sfValidatorFile(array('path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_ecosystem_pictures_directory'), 'required' => false)));
	$this->setValidator('picture_2', new sfValidatorFile(array('path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_ecosystem_pictures_directory'), 'required' => false)));
	$this->setValidator('picture_3', new sfValidatorFile(array('path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_ecosystem_pictures_directory'), 'required' => false)));
	$this->setValidator('picture_4', new sfValidatorFile(array('path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_ecosystem_pictures_directory'), 'required' => false)));
	$this->setValidator('picture_5', new sfValidatorFile(array('path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_ecosystem_pictures_directory'), 'required' => false)));
  }
}
