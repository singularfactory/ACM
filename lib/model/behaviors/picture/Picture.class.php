<?php
/**
 * Picture behavior
 *
 * acm : Algae Culture Management (https://github.com/singularfactory/ACM)
 * Copyright 2012, Singular Factory <info@singularfactory.com>
 *
 * This file is part of ACM
 *
 * ACM is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ACM is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ACM.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright     Copyright 2012, Singular Factory <info@singularfactory.com>
 * @package       ACM.Lib.Behavior
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */

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
 * @since 1.0	*/
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
 * @since 1.0	*/
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