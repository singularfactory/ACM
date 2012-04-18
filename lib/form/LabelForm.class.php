<?php
/**
 * LabelForm class
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
 * Label form class.
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
class LabelForm extends BaseForm {

	protected static $products = array(
		'strain' => 'Strain',
	);

	public function configure() {
		$this->setWidgets(array(
			'product_type'		=> new sfWidgetFormChoice(array('choices' => self::$products)),
			'product_id'			=> new sfWidgetFormInputHidden(),
			'supervisor'			=> new sfWidgetFormInputText(),
			'all_products'		=> new sfWidgetFormInputCheckbox(),

			// Strain attributes
			'culture_medium_id'	=> new sfWidgetFormDoctrineChoice(array('model' => 'CultureMedium', 'add_empty' => true)),
			'transfer_interval'	=> new sfWidgetFormInputText(),
		));

		$this->setValidators(array(
			'product_type'	=> new sfValidatorChoice(array('choices' => array_keys(self::$products), 'required' => false)),
			'product_id'		=> new sfValidatorInteger(array('required' => true)),
			'supervisor'		=> new sfValidatorString(array('max_length' => 5, 'required' => false, 'trim' => true)),
			'all_products'	=> new sfValidatorBoolean(array('required' => false)),

			// Strain attributes
			'culture_medium_id' => new sfValidatorDoctrineChoice(array('model' => 'CultureMedium')),
			'transfer_interval' => new sfValidatorInteger(array('required' => false, 'trim' => true)),
		));

		$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

		$this->widgetSchema->setLabels(array(
			'product_type'	=> 'Product type',
			'product_id'		=> 'Product code',
			'supervisor'		=> 'Supervisor',
			'all_products'	=> 'Create labels for every product',

			// Strain attributes
			'culture_medium_id' => 'Culture medium',
			'transfer_interval' => 'Transfer interval',
		));

		$this->widgetSchema->setHelps(array(
			'product_type'	=> 'Choose the product to create labels for',
			'product_id'		=> '',
			'supervisor'		=> 'Alias of the supervisor that will appear in the label (5 characters maximum)',
			'all_products'	=> null,

			// Strain attributes
			'culture_medium_id' => 'Choose the culture medium that will appear in the label',
			'transfer_interval'=> 'Overrides the transfer interval specified for the strain',
		));

		$this->setup();
	}

}
