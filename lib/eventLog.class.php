<?php
/**
* Event extension class that records events per every user action
*/
class EventLog
{
	static protected $field_separator = ';';
	
	static public function save_log_message(sfEvent $event_occurred)
	{
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
					$description = $module.self::$field_separator.$event_occurred['id'];
				}
				else {
					$description = $module.self::$field_separator.$form['id'];
				}	

				switch ($module) {
					case 'collector':
						$description .= self::$field_separator."{$form['name']} {$form['surname']}";
						break;
					case 'country':
					case 'environment':
					case 'habitat':
					case 'island':
					case 'location':
					case 'province':
					case 'radiation':
					case 'region':
						$description .= $form['name'];
						break;
					case 'sample':
						break;
				}
				break;

			case 'delete':
				$description = $module.self::$field_separator.$request->getParameter('id');
				break;
		}

		// Create and save a Event object
		$event = new Event();
		$event->setUserId($notifier->getUser()->getGuardUser()->getId());
		$event->setIpAddress($request->getRemoteAddress());
		$event->setAction($action);
		$event->setDescription($description);
		$event->save();	
	} 
}