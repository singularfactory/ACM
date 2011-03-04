<?php

class frontendConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
	$this->dispatcher->connect('bna_green_house.event_log', array('EventLog', 'save_log_message'));
  }
}
