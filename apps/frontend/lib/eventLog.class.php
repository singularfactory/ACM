<?php
/**
* Event extension class that records events per every user action
*/
class EventLog
{
  static public function save_log_message(sfEvent $event_occurred)
  {
	$notifier = $event_occurred->getSubject();
	
	$event = new Event();

	$event->setUserId($notifier->getUser()->getGuardUser()->getId());
	$event->setIpAddress($notifier->getRequest()->getRemoteAddress());
	$event->setAction($notifier->getActionName());
	$event->setDescription($notifier->getModuleName());
	
	$event->save();	
  } 
}