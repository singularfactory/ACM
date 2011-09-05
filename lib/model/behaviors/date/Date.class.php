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
	
}