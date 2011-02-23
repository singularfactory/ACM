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
  }
}
