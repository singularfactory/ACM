<?php

/**
 * FieldPicture
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class FieldPicture extends BaseFieldPicture {
	
	public function getThumbnail() {
		$file = sfConfig::get('app_pictures_dir').sfConfig::get('app_sample_pictures_dir').sfConfig::get('app_thumbnails_dir').'/'.$this->getFilename();
		return preg_replace('/\.[\-\w]+$/', sfConfig::get('app_thumbnail_extension'), $file);
	}
	
	public function getFilenameWithPath() {
		return sfConfig::get('app_pictures_dir').sfConfig::get('app_sample_pictures_dir').'/'.$this->getFilename();
	}
}
