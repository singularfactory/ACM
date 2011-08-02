<?php

class myUser extends sfGuardSecurityUser {
	
	/**
	 * Checks if logged user has a certain credential
	 *
	 * @param string $credential 
	 * @param boolean $useAnd 
	 * @return boolean
	 * @author Eliezer Talon
	 * @version	2011-08-02
	*/
	public function hasCredential($credential, $useAnd = true) {
		// combine the credential and the permissions check
		return (parent::hasCredential($credential, $useAnd) || parent::hasPermission($credential));
	}
}
