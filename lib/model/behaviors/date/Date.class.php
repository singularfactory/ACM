<?php
/**
 * Date behavior
 *
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
 * @package       ACM.Lib.Behavior
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */

class Date extends Doctrine_Template {

	public function formatDate($value = '') {
		if ( preg_match('/^(\d{1,4})-0+-0+$/', $value, $matches) ) {
			return $matches[1];
		}
		else {
			return date('M j, Y', strtotime($value));
		}
	}

	public function formatFriendlyDate($value, $withTime = true) {
		$now = time();
		$received = strtotime($value);
		$interval = $now - $received;

		if ($interval < 60) {
			return 'A few seconds ago';
		}

		for ($i=60; $i < 3600; $i+=60) {
			if ( $interval <= $i ) {
				$minutes = floor($interval / 60.0);
				if ($minutes <= 1) {
					return "$minutes minute ago";
				}
				else {
					return "$minutes minutes ago";
				}
			}
		}

		if ($interval <= 3600) {
			return 'Less than an hour ago';
		}

		if ($interval <= 7200) {
			return 'About an hour ago';
		}

		if ($interval < 86400) {
			if (date('d', $received) < date('d', $now)) {
				return $withTime ? 'Yesterday at '.date("H:i", $received) : 'Yesterday';
			}
			else {
				return $withTime ? 'Today at '.date("H:i", $received) : 'Today';
			}
		}

		return $withTime ? date("M jS, Y, H:i", $received) : date("M jS, Y", $received);
	}

}
