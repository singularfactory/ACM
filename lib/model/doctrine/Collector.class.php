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
 * Collector
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package ACM.Lib.Model
 * @since 1.0
 */
class Collector extends BaseCollector {

	public function __toString() {
		return $this->getName().' '.$this->getSurname();
	}

	public function getFullName() {
		return $this->__toString();
	}

	public function getNbExternalStrains() {
		return Doctrine_Query::create()
			->from('ExternalStrainCollectors s')
			->where('s.collector_id = ?', $this->getId())
			->count();
	}

	public function getNbSamples() {
		return Doctrine_Query::create()
			->from('SampleCollectors s')
			->where('s.collector_id = ?', $this->getId())
			->count();
	}

	public function getNbPatentDeposits() {
		return Doctrine_Query::create()
			->from('PatentDepositCollectors s')
			->where('s.collector_id = ?', $this->getId())
			->count();
	}

	public function getNbMaintenanceDeposits() {
		return Doctrine_Query::create()
			->from('MaintenanceDepositCollectors s')
			->where('s.collector_id = ?', $this->getId())
			->count();
	}

}
