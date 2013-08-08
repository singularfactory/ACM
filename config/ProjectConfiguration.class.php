<?php
/**
 * Project configuration
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
 * @package       ACM.Config
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration {
	public function setup() {
		$this->enablePlugins(array(
			'sfDoctrinePlugin',
			'sfDoctrineGuardPlugin',
			'ahDoctrineEasyEmbeddedRelationsPlugin',
			'sfEasyGMapPlugin',
			'sfThumbnailPlugin',
		));

		// Register the logger event handler
		$this->dispatcher->connect('bna_green_house.event_log', array('EventLog', 'save_log_message'));
	}
	
	/**
	 * Configure the Doctrine engine
	 **/
	public function configureDoctrine(Doctrine_Manager $manager) {
		$manager->setAttribute(Doctrine::ATTR_QUERY_CACHE, new Doctrine_Cache_Xcache());
	}
}
