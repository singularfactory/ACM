<?php
/**
 * Logs every CRUD action
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
 * @package       ACM.Lib
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */

/**
 * Records every CRUD action on frontend objects
 *
 * @package ACM.Lib
 * @since 1.0
 */
class EventLog {
	static protected $field_separator = ';';

	static public function save_log_message(sfEvent $event_occurred) {
		// Get event information
		$notifier = $event_occurred->getSubject();
		$request = $notifier->getRequest();

		// Get action information
		$module = $notifier->getModuleName();
		$action = $notifier->getActionName();

		// Generate the description for the event
		switch ( $action ) {
			case 'create':
			case 'update':
				$form = $request->getPostParameter($module);
				if ( $action === 'create') {
					$description = $event_occurred['id'];
				}
				else {
					$description = $form['id'];
				}

				switch ($module) {
					case 'collector':
					case 'depositor':
					case 'identifier':
					case 'isolator':
						$description .= self::$field_separator."{$form['name']} {$form['surname']}";
						break;
					case 'authority':
					case 'cryopreservation_method':
					case 'country':
					case 'environment':
					case 'habitat':
					case 'island':
					case 'location':
					case 'province':
					case 'radiation':
					case 'region':
					case 'culture_medium':
					case 'dna_polymerase':
					case 'dna_primer':
					case 'extraction_kit':
					case 'genus':
					case 'species':
					case 'taxonomic_class':
					case 'maintenance_status':
					case 'pcr_program':
					case 'purchase_order':
					case 'purchase_item':
						$description .= self::$field_separator.$form['name'];
						break;
					default:
						break;
				}
				break;

			case 'delete':
				$description = $request->getParameter('id');
				break;
		}

		// Create and save a Event object
		$event = new Event();
		$event->setUserId($notifier->getUser()->getGuardUser()->getId());
		$event->setIpAddress($request->getRemoteAddress());
		$event->setModule($module);
		$event->setAction($action);
		$event->setDescription($description);
		$event->save();
	}
}