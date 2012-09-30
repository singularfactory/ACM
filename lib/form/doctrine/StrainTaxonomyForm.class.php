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
 * @since         1.2
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */


/**
 * StrainTaxonomy form
 *
 * @package    ACM
 * @subpackage form
 * @version    1.2
 */
class StrainTaxonomyForm extends BaseStrainTaxonomyForm {
	public static $groupByChoices = array(
		0 => '',
		'taxonomic_class' => 'Taxonomic class',
		'genus' => 'Genus',
		'species' => 'Species',
	);

	/**
	 * Configure Strain form
	 *
	 * @return void
	 */
	public function configure() {
		// Skip the whole configuration if this a search form
		if ($this->getOption('search')) {
			$this->setWidget('group_by', new sfWidgetFormChoice(array('choices' => self::$groupByChoices)));
			$this->setValidator('group_by', new sfValidatorChoice(array('choices' => array_keys(self::$groupByChoices), 'required' => false)));

			$this->getWidget('taxonomic_class_id')->setOption('add_empty', true);
			$this->getWidget('genus_id')->setOption('add_empty', true);
			$this->getWidget('species_id')->setOption('add_empty', true);

			$this->widgetSchema->setLabels(array(
				'taxonomic_class_id' => 'Limited to class',
				'genus_id' => 'Limited to genus',
				'species_id' => 'Limited to species',
			));

			return;
		}

		// Set sorting order in taxonomy related fields
		$this['taxonomic_class_id']->getWidget()->setOption('order_by', array('name', 'asc'));
		$this['genus_id']->getWidget()->setOption('order_by', array('name', 'asc'));
		$this['species_id']->getWidget()->setOption('order_by', array('name', 'asc'));

		// Configure labels
		$this->widgetSchema->setLabel('taxonomic_class_id', 'Class');

		// Configure help messages
		$this->widgetSchema->setHelp('taxonomic_class_id', 'Taxonomic class');
		$this->widgetSchema->setHelp('genus_id', 'Taxonomic genus');
		$this->widgetSchema->setHelp('species_id', 'Taxonomic species');
	}
}
