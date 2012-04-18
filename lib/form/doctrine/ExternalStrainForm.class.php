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
	public function configure() {
		// Skip the whole configuration if this a search form
		if ( $this->getOption('search') ) {
			return;
		}

		// Unset select fields that do not have values
		if ( IdentifierTable::getInstance()->count() == 0 ) {
			unset($this['identifier_id']);
		}

		if ( ContainerTable::getInstance()->count() == 0 ) {
			unset($this['container_id']);
		}

		// Configure location
		$this->setWidget('location_id', new sfWidgetFormInputHidden(array('default' => $this->getObject()->getLocation()->getTable()->getDefaultLocationId())));

		// Configure date formats
		$lastYear = date('Y');
		for ($i=1990; $i <= $lastYear; $i++) { $years[$i] = $i; }
		$this->setWidget('isolation_date', new sfWidgetFormDate(array('format' => '%year% %month% %day%', 'years' => $years)));
		$this->setWidget('collection_date', new sfWidgetFormDate(array('format' => '%year% %month% %day%', 'years' => $years)));

		// Set sorting order in taxonomy related fields
		$this['taxonomic_class_id']->getWidget()->setOption('order_by', array('name', 'asc'));
		$this['genus_id']->getWidget()->setOption('order_by', array('name', 'asc'));
		$this['species_id']->getWidget()->setOption('order_by', array('name', 'asc'));
		$this['authority_id']->getWidget()->setOption('order_by', array('name', 'asc'));

		// Configure culture media relationships
		$this->setWidget('culture_media_list', new sfWidgetFormDoctrineChoice(array(
			'multiple' => true,
			'model' => 'CultureMedium',
			'method' => 'getName',
			'order_by' => array('name', 'asc'),
		)));

		// Configure list of isolators
		$this->setWidget('collectors_list', new sfWidgetFormDoctrineChoice(array(
			'model' => 'Collector',
			'method' => 'getFullName',
			'multiple' => true,
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

		$this->setValidator('location_id', new sfValidatorDoctrineChoice(
			array('model' => $this->getRelatedModelName('Location')),
			array('required' => 'The location of the sample is required')
		));

		// Configure labels
		$this->widgetSchema->setLabel('taxonomic_class_id', 'Class');
		$this->widgetSchema->setLabel('culture_media_list', 'Culture media');
		$this->widgetSchema->setLabel('container_id', 'Best container');
		$this->widgetSchema->setLabel('transfer_interval', 'Transfer interval (weeks)');
		$this->widgetSchema->setLabel('isolators_list', 'Isolators');
		$this->widgetSchema->setLabel('containers_list', 'Available containers');
		$this->widgetSchema->setLabel('collectors_list', 'Collectors');

		// Configure help messages
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
		$this->widgetSchema->setHelp('collectors_list', 'Collectors of this strain. Select more than one with Ctrl or Cmd key.');
	}
}
