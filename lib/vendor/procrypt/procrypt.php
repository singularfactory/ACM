<?php

class proCrypt  {
	/**
	* This is called when we wish to set a variable
	*
	* @access	public
	* @param	string	$name
	* @param	string	$value
	*
	*/
	public function __set( $name, $value ) {
		switch ($name) {
			case 'key':
			case 'ivs':
			case 'iv':
				$this->$name = $value;
				break;

			default:
				throw new Exception( "$name cannot be set" );
		}
	}

	/**
	* Gettor - This is called when an non existant variable is called
	*
	* @access	public
	* @param	string	$name
	*
	*/
	public function __get( $name ) {
		switch( $name ) {
			case 'key':
				return sfConfig::get('app_notify_sent_shared_secret');

			case 'ivs':
				return mcrypt_get_iv_size( MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB );

			case 'iv':
				return mcrypt_create_iv( $this->ivs, MCRYPT_RAND );

			default:
				throw new Exception( "$name cannot be called" );
		}
	}

	/**
	* Encrypt a string
	*
	* @access	public
	* @param	string	$text
	* @return	string	The encrypted string
	*
	*/
	public function encrypt( $text ) {
		// add end of text delimiter
		$data = mcrypt_encrypt( MCRYPT_RIJNDAEL_128, $this->key, $text, MCRYPT_MODE_ECB, $this->iv );
		return base64_encode( $data );
	}

	/**
	* Decrypt a string
	*
	* @access	public
	* @param	string	$text
	* @return	string	The decrypted string
	*
	*/
	public function decrypt( $text ) {
		$text = base64_decode( $text );
		$ret = mcrypt_decrypt( MCRYPT_RIJNDAEL_128, $this->key, $text, MCRYPT_MODE_ECB, $this->iv );
		return rtrim($ret, "\0");
	}
}