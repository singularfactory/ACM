<?php
/**
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
 * @package       ACM.Frontend
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */
?>
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
