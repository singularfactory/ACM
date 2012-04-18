<?php
/**
 * Custom validator for LocationPicture objects
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
 * @package       ACM.Lib.Validator
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */

/**
 * LocationPictureValidatorSchema validator.
 *
 * @package    ACM.Lib.Validator
 * @since 1.0
 */
class LocationPictureValidatorSchema extends sfValidatorSchema {
	protected function configure($options = array(), $messages = array()) {
		$this->addMessage('filename', 'The filename is required.');
	}

	protected function doClean($values) {
		$errorSchema = new sfValidatorErrorSchema($this);

		foreach($values as $key => $value) {
			$errorSchemaLocal = new sfValidatorErrorSchema($this);

			// No filename, remove the empty values
			if (!$value['filename'] ) {
				unset($values[$key]);
			}

			// some error for this embedded-form
			if (count($errorSchemaLocal)) {
				$errorSchema->addError($errorSchemaLocal, (string) $key);
			}
		}

		// throws the error for the main form
		if (count($errorSchema)) {
			throw new sfValidatorErrorSchema($this, $errorSchema);
		}

		return $values;
	}
}