<?php

/**
 * sfGuardUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class sfGuardUser extends PluginsfGuardUser {
	
	public function getNbUnreadNotifications() {
		return NotificationTable::getInstance()->createQuery('n')
			->where('n.user_id = ?', $this->getId())
			->andWhere('n.status = ?', sfConfig::get('app_inbox_notification_new'))
			->count();
	}
}
