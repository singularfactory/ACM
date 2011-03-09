<?php
/**
* Event extension class that records events per every user action
*/
class EventLog
{
  static public function save_log_message(sfEvent $event_occurred)
  {
	$notifier = $event_occurred->getSubject();
	$request = $notifier->getRequest();
	$event = new Event();
	
	$event->setUserId($notifier->getUser()->getGuardUser()->getId());
	$event->setIpAddress($request->getRemoteAddress());
	$event->setAction($notifier->getActionName());
	
	$module = $notifier->getModuleName();
	$description = $request->getParameter('id');
	switch ($module) {
		case 'collector':
		case 'country':
		case 'environment':
		case 'habitat':
		case 'island':
		case 'location':
		case 'province':
		case 'radiation':
		case 'region':
			$description += ';';
			$description += $request->getParameter('name');
			break;
		case 'sample':
			$description += ';';
			$description += $request->getParameter('location_id');
			break;
	}
	$event->setDescription("$module;$description");
	
	$event->save();	
  } 
}