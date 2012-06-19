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
 * CultureMedium
 *
 * @package ACM.Lib.Model
 * @since 1.0
 */
class CultureMedium extends BaseCultureMedium {

	public function getCode() {
		$code = str_pad($this->getId(), 4, '0', STR_PAD_LEFT);
		return "BEA$code-cm";
	}

	public function getNbStrains() {
		if ( $strains = $this->getStrains() ) {
			return count($strains);
		}
		else {
			return Doctrine_Query::create()
				->from('StrainCultureMedia s')
				->where('s.culture_medium_id = ?', $this->getId())
				->count();
		}
	}

	public function getNbPatentDeposits() {
		return Doctrine_Query::create()
			->from('PatentDepositCultureMedia s')
			->where('s.culture_medium_id = ?', $this->getId())
			->count();
	}

	public function getNbMaintenanceDeposits() {
		return Doctrine_Query::create()
			->from('MaintenanceDepositCultureMedia s')
			->where('s.culture_medium_id = ?', $this->getId())
			->count();
	}

	public function getFormattedLink() {
		if ( $link = $this->_get('link') ) {
			return $link;
		}

		return sfConfig::get('app_no_data_message');
	}

	public function getFormattedIsPublic() {
		if ( $this->getIsPublic() ) {
			return 'yes';
		}
		return 'no';
	}

	public function getLink() {
		$link = $this->_get('link');

		if ( !empty($link) && !preg_match('/^https?:\/\//', $link) ) {
			return "http://$link";
		}

		return $link;
	}

	public function getDescriptionUrl() {
		$path = sfConfig::get('app_documents_dir').sfConfig::get('app_culture_media_dir');
		$filename = $this->getDescription();

		if ( empty($filename) ) {
			return null;
		}
		else {
			return "$path/$filename";
		}
	}

}
