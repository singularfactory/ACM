<?php

/**
 * GrowthMedium
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class GrowthMedium extends BaseGrowthMedium {
	
	public function getNbStrains() {
		return Doctrine_Query::create()
			->from('StrainGrowthMediums s')
			->where('s.growth_medium_id = ?', $this->getId())
			->count();
	}
	
	public function getFormattedLink() {
		if ( $link = $this->getLink() ) {
			return $link;
		}
		
		return sfConfig::get('app_no_data_message');
	}
	
}
