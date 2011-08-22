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
		// Unset select fields that do not have values
		if ( DepositorTable::getInstance()->count() == 0 ) {
			unset($this['depositor_id']);
		}
		
		if ( IdentifierTable::getInstance()->count() == 0 ) {
			unset($this['identifier_id']);
		}
		
		// Configure manual ID
		$this->setWidget('id', new sfWidgetFormInputText());
		
		// Configure sample code (commented out to temporarily allow NULL values)
		//$this->setWidget('sample_id', new sfWidgetFormInputHidden(array('default' => (int)SampleTable::getInstance()->getDefaultSampleId())));
		
		// Configure date format
		$lastYear = date('Y');
		for ($i=$lastYear-5; $i <= $lastYear; $i++) { $years[$i] = $i; }
		$dateWidgetForm = new sfWidgetFormDate(array('format' => '%year%-%month%-%day%', 'years' => $years));
		$this->setWidget('isolation_date', $dateWidgetForm);
		$this->setWidget('deposition_date', $dateWidgetForm);
		
		// Calculate maximum number of images the user can upload
		$actualPictures = $this->getObject()->getNbPictures();
		$defaultMaxPictures = sfConfig::get('app_max_strain_pictures');
		$this->setOption('max_strain_pictures', $defaultMaxPictures - $actualPictures);
		
		// Create an embedded form to add or edit pictures and relatives
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
		));
		
		
		// Configure custom validators
		$this->setValidator('id', new sfValidatorString(array('max_length' => 4, 'required' => true)));
		
		// (commented out to temporarily allow NULL values)
		// $this->setValidator('sample_id', new sfValidatorDoctrineChoice(
		// 			array('model' => $this->getRelatedModelName('Sample')),
		// 			array('required' => 'The origin sample of the strain is required')));
		
		// Configure a custom post validator for cryopreservation method
    $this->validatorSchema->setPostValidator( new sfValidatorCallback(array('callback' => array($this, 'checkCryopreservedStatusHasMethod'))));
						
		// Configure labels
		$this->widgetSchema->setLabel('id', 'Strain code');
		$this->widgetSchema->setLabel('sample_id', 'Sample code');
		$this->widgetSchema->setLabel('taxonomic_class_id', 'Class');
		$this->widgetSchema->setLabel('growth_mediums_list', 'Culture media');
		
		// Configure help messages
		$this->widgetSchema->setHelp('id', 'Numeric code assigned to the strain <strong>without BEA nor B suffix</strong>');
		$this->widgetSchema->setHelp('taxonomic_class_id', 'Taxonomic class');
		$this->widgetSchema->setHelp('genus_id', 'Taxonomic genus');
		$this->widgetSchema->setHelp('species_id', 'Taxonomic species');
		$this->widgetSchema->setHelp('authority_id', 'Taxonomic authority');
		$this->widgetSchema->setHelp('isolation_date', 'Year, month and day');
		$this->widgetSchema->setHelp('new_Relatives', 'Codes used in alternate databases or publications');
		$this->widgetSchema->setHelp('deposition_date', 'Year, month and day');
		$this->widgetSchema->setHelp('observation', 'Notes about strain growth');
		$this->widgetSchema->setHelp('citations', 'Scientific publications where the strain was used');
		$this->widgetSchema->setHelp('web_notes', 'Comments that will appear in the public web');
		$this->widgetSchema->setHelp('new_Pictures', 'Select up to '.($defaultMaxPictures - $actualPictures).' pictures in JPEG, PNG or TIFF format');
		$this->widgetSchema->setHelp('growth_mediums_list', 'Culture media available for this strain. Select more than one with Ctrl or Cmd key.');
  }


	public function checkCryopreservedStatusHasMethod($validator, $values) {
		$cryopreservedStatusId = MaintenanceStatusTable::getInstance()
			->findOneByName(sfConfig::get("app_maintenance_status_cryopreserved"))
			->getId();
			
		if ( $values['maintenance_status_id'] != $cryopreservedStatusId ) {
			$values['cryopreservation_method_id'] = null;
		}
		else {
			if ( empty($values['cryopreservation_method_id']) ) {
				$error = new sfValidatorError($validator, 'You must chose a cryopreservation method');
				throw new sfValidatorErrorSchema($validator, array('cryopreservation_method_id' => $error));
			}
		}

		// cryopreserved method is consistent with maintenance status, return the clean values
		return $values;
	}
	
}
