<?php
class Picture extends Doctrine_Template {
	
	/**
   * Array of Picture options
   *
   * @var array
   */
  protected $_options = array(
		'moduleName' => null,
	);
	
	
	/**
	 * Returns thumbnail path and filename
	 *
	 * @return string
	 * @author Eliezer Talon
	 * @version 2011-08-03
	*/
	public function getThumbnail() {
		$module = $this->_options['moduleName'];
		if ( $module == null ) {
			return '';
		}
		
		$path = sfConfig::get('app_pictures_dir').sfConfig::get("app_{$module}_pictures_dir").sfConfig::get('app_thumbnails_dir');
		$filename = $this->getInvoker()->getFilename();
		
		return preg_replace('/\.[\-\w]+$/', sfConfig::get('app_thumbnail_extension'), "$path/$filename");
	}
	
	
	/**
	 * Return the filename of a picture with its path
	 *
	 * @return string
	 * @author Eliezer Talon
	 * @version 2011-08-03
	*/
	public function getFilenameWithPath() {
		$module = $this->_options['moduleName'];
		if ( $module == null ) {
			return '';
		}
		
		$path = sfConfig::get('app_pictures_dir').sfConfig::get("app_{$module}_pictures_dir");
		$filename = $this->getInvoker()->getFilename();
		
		return "$path/$filename";
	}
	
}