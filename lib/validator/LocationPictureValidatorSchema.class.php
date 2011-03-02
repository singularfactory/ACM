<?php

/**
* LocationPictureValidatorSchema validator.
*
* @package    bna_green_house
* @subpackage validator
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id
*/
class LocationPictureValidatorSchema extends sfValidatorSchema
{
	protected function configure($options = array(), $messages = array())
	{
		$this->addMessage('filename', 'The filename is required.');
	}

	protected function doClean($values)
	{
		$errorSchema = new sfValidatorErrorSchema($this);

		foreach($values as $key => $value)
		{
			$errorSchemaLocal = new sfValidatorErrorSchema($this);

			// No filename, remove the empty values
			if (!$value['filename'] )
			{
				unset($values[$key]);
			}

			// some error for this embedded-form
			if (count($errorSchemaLocal))
			{
				$errorSchema->addError($errorSchemaLocal, (string) $key);
			}
		}

		// throws the error for the main form
		if (count($errorSchema))
		{
			throw new sfValidatorErrorSchema($this, $errorSchema);
		}

		return $values;
	}
}