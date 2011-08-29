<?php
class InboxFilter extends sfFilter {
	
	public function execute ($filterChain) {
		// Delete messages marked as delete for 30 days
		$interval = date('Y-m-d H:i:s', time() - (sfConfig::get('app_inbox_days_in_trash') * 86400));
		NotificationTable::getInstance()->createQuery('n')
			->delete()
			->where('n.status = ?', sfConfig::get('app_inbox_notification_deleted'))
			->andWhere('n.updated_at < ?', $interval)
			->execute();
		
		$filterChain->execute();
	}
}
