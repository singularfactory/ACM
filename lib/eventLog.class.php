<?php
/**
 * Records every CRUD action on frontend objects
 *
 * @package bna_green_house
 * @author Eliezer Talon
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
					case ''
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