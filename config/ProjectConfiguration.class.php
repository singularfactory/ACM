<?php
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

		//apc_clear_cache();
		//apc_clear_cache('user');
		//apc_clear_cache('opcode');
	  $this->enablePlugins('sfTCPDFPlugin');
  }
	
	/**
	 * Configure the Doctrine engine
	 **/
	public function configureDoctrine(Doctrine_Manager $manager) {
		$manager->setAttribute(Doctrine::ATTR_QUERY_CACHE, new Doctrine_Cache_Apc());
	}
}
