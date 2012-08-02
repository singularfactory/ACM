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
 * ExternalStrain form.
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
class ExternalStrainForm extends BaseExternalStrainForm {
	public static $groupByChoices = array(
		0 => '',
		'taxonomic_class' => 'Taxonomic class',
		'genus' => 'Genus',
		'species' => 'Species',
		'authority' => 'Authority',
		'container' => 'Container',
		'culture_medium' => 'Culture medium',
		'transfer_interval' => 'Transfer interval',
		'is_epitype' => 'Is epitype',
		'is_axenic' => 'Is axenic',
		'sample' => 'Sample',
	);

	/**
	 * Configure ExternalStrain form
	 *
	 * @return void
	 */
	public function configure() {
		// Skip the whole configuration if this a search form
		if ($this->getOption('search')) {
			$this->setWidget('group_by', new sfWidgetFormChoice(array('choices' => self::$groupByChoices)));
			$this->setValidator('group_by', new sfValidatorChoice(array('choices' => array_keys(self::$groupByChoices), 'required' => false)));

			$this->setWidget('id', new sfWidgetFormInputText());
			$this->setValidator('id', new sfValidatorString(array('required' => false)));

			$this->getWidget('taxonomic_class_id')->setOption('add_empty', true);
			$this->getWidget('genus_id')->setOption('add_empty', true);
			$this->getWidget('species_id')->setOption('add_empty', true);
			$this->getWidget('authority_id')->setOption('add_empty', true);

			$this->setWidget('is_epitype', new sfWidgetFormChoice(array('choices' => self::$booleanChoices)));
			$this->setWidget('is_axenic', new sfWidgetFormChoice(array('choices' => self::$booleanChoices)));

			$this->setWidget('maintenance_status_id', new sfWidgetFormDoctrineChoice(array('model' => 'MaintenanceStatus', 'add_empty' => true)));
			$this->setValidator('maintenance_status_id', new sfValidatorDoctrineChoice(array('model' => 'MaintenanceStatus', 'required' => false)));
			$this->setWidget('culture_medium_id', new sfWidgetFormDoctrineChoice(array('model' => 'CultureMedium', 'add_empty' => true)));
			$this->setValidator('culture_medium_id', new sfValidatorDoctrineChoice(array('model' => 'CultureMedium', 'required' => false)));

			$this->widgetSchema->setLabels(array(
				'id' => 'Code',
				'taxonomic_class_id' => 'Limited to class',
				'genus_id' => 'Limited to genus',
				'species_id' => 'Limited to species',
				'authority_id' => 'Limited to authority',
				'maintenance_status_id' => 'Limited to maintenance status',
				'culture_medium_id' => 'Limited to culture medium',
			));

			return;
		}

		// Unset select fields that do not have values
		if ( IdentifierTable::getInstance()->count() == 0 ) {
			unset($this['identifier_id']);
		}

		if ( ContainerTable::getInstance()->count() == 0 ) {
			unset($this['container_id']);
		}

		// Configure sample code
		$this->setWidget('sample_id', new sfWidgetFormInputHidden(array('default' => (int)SampleTable::getInstance()->getDefaultSampleId())));

		// Configure date formats
		$lastYear = date('Y');
		for ($i=1990; $i <= $lastYear; $i++) { $years[$i] = $i; }
		$this->setWidget('isolation_date', new sfWidgetFormDate(array('format' => '%year% %month% %day%', 'years' => $years)));

		// Set sorting order in taxonomy related fields
		$this['taxonomic_class_id']->getWidget()->setOption('order_by', array('name', 'asc'));
		$this['genus_id']->getWidget()->setOption('order_by', array('name', 'asc'));
		$this['species_id']->getWidget()->setOption('order_by', array('name', 'asc'));
		$this['authority_id']->getWidget()->setOption('order_by', array('name', 'asc'));
		$this['taxonomic_order_id']->getWidget()->setOption('order_by', array('name', 'asc'));
		$this['kingdom_id']->getWidget()->setOption('order_by', array('name', 'asc'));
		$this['subkingdom_id']->getWidget()->setOption('order_by', array('name', 'asc'));
		$this['phylum_id']->getWidget()->setOption('order_by', array('name', 'asc'));
		$this['family_id']->getWidget()->setOption('order_by', array('name', 'asc'));

		// Configure culture media relationships
		$this->setWidget('culture_media_list', new sfWidgetFormDoctrineChoice(array(
			'multiple' => true,
			'model' => 'CultureMedium',
			'method' => 'getName',
			'order_by' => array('name', 'asc'),
		)));

		// Configure list of isolators
		$this->setWidget('isolators_list', new sfWidgetFormDoctrineChoice(array(
			'model' => 'Isolator',
			'method' => 'getFullName',
			'multiple' => true,
			'order_by' => array('name', 'asc'),
		)));

		// Configure list of containers
		$this->setWidget('containers_list', new sfWidgetFormDoctrineChoice(array(
			'model' => 'Container',
			'method' => 'getName',
			'multiple' => true,
			'order_by' => array('name', 'asc'),
		)));

		// Configure list of maintenance statuses
		$this->setWidget('maintenance_status_list', new sfWidgetFormDoctrineChoice(array(
			'model' => 'MaintenanceStatus',
			'method' => 'getName',
			'multiple' => true,
			'order_by' => array('name', 'asc'),
		)));

		// Configure list of supervisors
		$this->setWidget('supervisor_id', new sfWidgetFormDoctrineChoice(array(
			'model' => $this->getRelatedModelName('Supervisor'),
			'method' => 'getFullNameWithInitials',
			'order_by' => array('first_name', 'asc'),
			'add_empty' => true,
		)));

		// Create an embedded form to add or edit pictures, relatives and axenity tests
		$this->embedRelations(array(
			'Relatives' => array(
				'considerNewFormEmptyFields' => array('name'),
				'newFormLabel' => 'Relatives',
				'multipleNewForms' => true,
				'newFormsInitialCount' => 1,
				'newRelationButtonLabel' => 'Add another relative',
			),
		));

		// Configure labels
		$this->widgetSchema->setLabel('sample_id', 'Sample code');
		$this->widgetSchema->setLabel('taxonomic_class_id', 'Class');
		$this->widgetSchema->setLabel('taxonomic_order_id', 'Order');
		$this->widgetSchema->setLabel('culture_media_list', 'Culture media');
		$this->widgetSchema->setLabel('container_id', 'Best container');
		$this->widgetSchema->setLabel('transfer_interval', 'Transfer interval (weeks)');
		$this->widgetSchema->setLabel('isolators_list', 'Isolators');
		$this->widgetSchema->setLabel('containers_list', 'Available containers');

		// Configure help messages
		$this->widgetSchema->setHelp('kingdom_id', 'Taxonomic kingdom');
		$this->widgetSchema->setHelp('subkingdom_id', 'Taxonomic subkingdom');
		$this->widgetSchema->setHelp('phylum_id', 'Taxonomic phylum');
		$this->widgetSchema->setHelp('family_id', 'Taxonomic family');
		$this->widgetSchema->setHelp('taxonomic_class_id', 'Taxonomic class');
		$this->widgetSchema->setHelp('genus_id', 'Taxonomic genus');
		$this->widgetSchema->setHelp('species_id', 'Taxonomic species');
		$this->widgetSchema->setHelp('authority_id', 'Taxonomic authority');
		$this->widgetSchema->setHelp('environment_id', 'Leave it blank if you do not know the value');
		$this->widgetSchema->setHelp('habitat_id', 'Leave it blank if you do not know the value');
		$this->widgetSchema->setHelp('isolation_date', 'Year, month and day');
		$this->widgetSchema->setHelp('new_Relatives', 'Codes used in alternate databases or publications');
		$this->widgetSchema->setHelp('observation', 'Notes about strain culture');
		$this->widgetSchema->setHelp('citations', 'Scientific publications where the strain was used');
		$this->widgetSchema->setHelp('culture_media_list', 'Culture media available for this strain. Select more than one with Ctrl or Cmd key.');
		$this->widgetSchema->setHelp('container_id', 'Type of container where the strain grows better');
		$this->widgetSchema->setHelp('isolators_list', 'Isolators of this strain. Select more than one with Ctrl or Cmd key.');
		$this->widgetSchema->setHelp('maintenance_status_list', 'Maintenance status of this strain. Select more than one with Ctrl or Cmd key.');
		$this->widgetSchema->setHelp('containers_list', 'Containers where a culture of this strain is available. Select more than one with Ctrl or Cmd key.');
	}
}
