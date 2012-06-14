<?php
/**
 * StrainLabelForm class
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
 * StrainLabel form
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
class StrainLabelForm extends LabelForm {
	/**
	 * Configures form for strain labels
	 *
	 * @return void
	 */
	public function configure() {
		parent::configure();
		$this->widgetSchema->setLabels(array(
			'supervisor_id' => 'Supervisor',
			'transfer_interval' => 'Transfer interval',
			'genus_id' => 'Genus',
			'is_axenic' => 'Is axenic?',
			'container_id' => 'Container',
			'culture_medium_id' => 'Culture medium',
		));
		$this->setup();
	}

	/**
	 * Returns the name of form associated model
	 */
	public function getModelName() {
		return 'Strain';
	}
}
