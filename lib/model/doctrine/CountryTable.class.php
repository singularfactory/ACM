<?php
/**
 * Model class
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
 * @package       ACM.Lib.Model
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */

/**
 * CountryTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CountryTable extends Doctrine_Table {
	/**
	* Returns an instance of this class.
	*
	* @return object CountryTable
	*/
	public static function getInstance() {
		return Doctrine_Core::getTable('Country');
	}

	/**
	 * Returns the ID of the default country to show in selects
	 *
	 * @return integer
 * @since 1.0	 */
	public function getDefaultCountryId() {
		$country = $this->createQuery()
			->from('Country c')
			->where('c.name LIKE ?', '%'.sfConfig::get('app_default_country_name').'%')
			->fetchOne();

		if ( $country ) {
			return $country->getId();
		}

		return null;
	}

}