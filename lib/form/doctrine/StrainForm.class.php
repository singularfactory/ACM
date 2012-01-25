<?php

/**
 * Strain form.
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class StrainForm extends BaseStrainForm {
  
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
		
		// Calculate maximum number of images the user can upload
		$actualPictures = $this->getObject()->getNbPictures();
		$defaultMaxPictures = sfConfig::get('app_max_strain_pictures');
		$this->setOption('max_strain_pictures', $defaultMaxPictures - $actualPictures);
		
		// Create an embedded form to add or edit pictures, relatives and axenity tests
		$this->embedRelations(array(
			'Pictures' => array(
				'considerNewFormEmptyFields' => array('filename'),
				'newFormLabel' => 'Pictures',
				'multipleNewForms' => true,
				'newFormsInitialCount' => 1,
				'newRelationButtonLabel' => 'Add another picture',
			),
			'Relatives' => array(
				'considerNewFormEmptyFields' => array('name'),
				'newFormLabel' => 'Relatives',
				'multipleNewForms' => true,
				'newFormsInitialCount' => 1,
				'newRelationButtonLabel' => 'Add another relative',
			),
			'AxenityTests' => array(
				'considerNewFormEmptyFields' => array('date'),
				'newFormLabel' => 'Axenity tests',
				'multipleNewForms' => true,
				'newFormsInitialCount' => 1,
				'newRelationButtonLabel' => 'Add another date',
			),
		));
		
		// Configure custom validators
		$this->setValidator('code', new sfValidatorString(array('max_length' => 4, 'required' => true)));
		
		// (commented out to temporarily allow NULL values)
		// $this->setValidator('sample_id', new sfValidatorDoctrineChoice(
		// 	array('model' => $this->getRelatedModelName('Sample')),
		// 	array('required' => 'The origin sample of the strain is required')
		// ));
		
		// Configure labels
		$this->widgetSchema->setLabel('code', 'Strain code');
		$this->widgetSchema->setLabel('sample_id', 'Sample code');
		$this->widgetSchema->setLabel('taxonomic_class_id', 'Class');
		$this->widgetSchema->setLabel('culture_media_list', 'Culture media');
		$this->widgetSchema->setLabel('container_id', 'Best container');
		$this->widgetSchema->setLabel('transfer_interval', 'Transfer interval (weeks)');
		$this->widgetSchema->setLabel('isolators_list', 'Isolators');
		$this->widgetSchema->setLabel('in_g_catalog', 'In G catalog');
		$this->widgetSchema->setLabel('containers_list', 'Available containers');
		
		// Configure help messages
		$this->widgetSchema->setHelp('code', 'Only the number');
		$this->widgetSchema->setHelp('clone_number', 'Leave empty if not applicable');
		$this->widgetSchema->setHelp('taxonomic_class_id', 'Taxonomic class');
		$this->widgetSchema->setHelp('genus_id', 'Taxonomic genus');
		$this->widgetSchema->setHelp('species_id', 'Taxonomic species');
		$this->widgetSchema->setHelp('authority_id', 'Taxonomic authority');
		$this->widgetSchema->setHelp('isolation_date', 'Year, month and day');
		$this->widgetSchema->setHelp('new_Relatives', 'Codes used in alternate databases or publications');
		$this->widgetSchema->setHelp('new_AxenityTests', 'Date of axenity tests performed');
		$this->widgetSchema->setHelp('observation', 'Notes about strain culture');
		$this->widgetSchema->setHelp('citations', 'Scientific publications where the strain was used');
		$this->widgetSchema->setHelp('web_notes', 'Comments that will appear in the public web');
		$this->widgetSchema->setHelp('is_public', 'Whether the strain must be shown in public catalog or not');
		//$this->widgetSchema->setHelp('amount', 'Items in stock');
		$this->widgetSchema->setHelp('new_Pictures', 'Select up to '.($defaultMaxPictures - $actualPictures).' pictures in JPEG, PNG or TIFF format');
		$this->widgetSchema->setHelp('culture_media_list', 'Culture media available for this strain. Select more than one with Ctrl or Cmd key.');
		$this->widgetSchema->setHelp('container_id', 'Type of container where the strain grows better');
		$this->widgetSchema->setHelp('isolators_list', 'Isolators of this strain. Select more than one with Ctrl or Cmd key.');
		$this->widgetSchema->setHelp('maintenance_status_list', 'Maintenance status of this strain. Select more than one with Ctrl or Cmd key.');
		$this->widgetSchema->setHelp('containers_list', 'Containers where a culture of this strain is available. Select more than one with Ctrl or Cmd key.');
  }
	
}
