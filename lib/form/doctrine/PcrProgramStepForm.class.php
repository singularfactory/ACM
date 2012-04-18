<?php
/**
 * Form class
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
 * @package       ACM.Lib.Form
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */


/**
 * PcrProgramStep form.
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
class PcrProgramStepForm extends BasePcrProgramStepForm {
	public function configure() {
		$this->useFields(array('segment', 'temperature', 'duration'));
		$this->setValidator('delete_object', new sfValidatorBoolean());

		$this->widgetSchema->setHelp('temperature', 'Decimal value for temperature (e.g 22.5 ºC)');
		$this->widgetSchema->setHelp('duration', 'Elapsed time in hours and minutes');
	}
}
