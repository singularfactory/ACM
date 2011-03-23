<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfDoctrinePlugin');
    $this->enablePlugins('sfDoctrineGuardPlugin');

	// Register the logger event handler
	$this->dispatcher->connect('bna_green_house.event_log', array('EventLog', 'save_log_message'));
    $this->enablePlugins('ahDoctrineEasyEmbeddedRelationsPlugin');
  }
}
