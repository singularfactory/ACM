<?php

/**
* Sample form.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class SampleForm extends BaseSampleForm
{
	public function configure()
	{
		$this->useFields(array(
			'id',
			'number',
			'location',
			'latitude_degrees',
			'latitude_minutes',
			'longitude_degrees',
			'longitude_minutes',
			'ecosystem_id',
			'environment_id',
			'habitat_id',
			'ph',
			'conductivity',
			'temperature',
			'salinity',
			'close_picture',
			'laboratory_picture',
			'collector_id',
			'collection_date',
			));
	}
}
