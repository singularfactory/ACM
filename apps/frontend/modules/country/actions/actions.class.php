<?php
/**
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
 * @package       ACM.Frontend
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */

/**
 * country actions
 *
 * @package ACM.Frontend
 * @subpackage country
 */
class countryActions extends sfActions {
	/**
	 * Find all regions that belong to a Country
	 *
	 * @param sfWebRequest $request
	 * @return JSON object
	 * @author Eliezer Talon
	 * @version 2011-04-20
	 */
	public function executeFindRegions(sfWebRequest $request) {
		if ( $request->isXmlHttpRequest() ) {
			$results = Doctrine_Core::getTable('Region')->getRegions($request->getParameter('country'));
			$regions = array(0 => '');
			foreach ($results as $region) {
				$regions[] = array('id' => $region->getId(), 'name' => $region->getName());
			}
			$this->getResponse()->setContent(json_encode($regions));
		}
		return sfView::NONE;
	}
}
