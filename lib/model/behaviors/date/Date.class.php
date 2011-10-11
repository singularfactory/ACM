<?php
class Date extends Doctrine_Template {
	
	public function formatDate($value = '') {
		if ( preg_match('/^(\d{1,4})-0+-0+$/', $value, $matches) ) {
			return $matches[1];
		}
		else {
			return date('M j, Y', strtotime($value));
		}
	}
	
	public function formatFriendlyDate($value = '') {
		$now = time();
		$received = strtotime($value);
		$interval = $now - $received;
		
		if ( $interval < 60 ) {
			return 'A few seconds ago';
		}
		
		for ( $i=60; $i < 3600; $i+=60 ) { 
			if ( $interval <= $i ) {
				$minutes = floor($interval / 60.0);
				if ( $minutes <= 1 ) {
					return "$minutes minute ago";
				}
				else {
					return "$minutes minutes ago";	
				}
			}
		}
		
		if ( $interval <= 3600 ) {
			return 'Less than an hour ago';
		}
		
		if ( $interval <= 7200 ) {
			return 'About an hour ago';
		}
		
		if ( $interval < 86400 ) {
			return 'Today at '.date("H:i", $received);
		}
		
		return date("M S, H:i", $received);
	}
	
}