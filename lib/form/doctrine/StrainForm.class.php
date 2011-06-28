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
		
		// Configure sample code
		$this->setWidget('sample_id', new sfWidgetFormDoctrineChoice(array(
			'model' => $this->getRelatedModelName('Sample'),
			'method' => 'getNumber',
		)));
		
		// Configure date format
		$lastYear = date('Y');
		for ($i=$lastYear-5; $i <= $lastYear; $i++) { $years[$i] = $i; }
		$dateWidgetForm = new sfWidgetFormDate(array('format' => '%year%-%month%-%day%', 'years' => $years));
		$this->setWidget('isolation_date', $dateWidgetForm);
		$this->setWidget('identification_date', $dateWidgetForm);
		$this->setWidget('deposition_date', $dateWidgetForm);
		
		// Configure a custom post validator for cryopreservation method
    $this->validatorSchema->setPostValidator( new sfValidatorCallback(array('callback' => array($this, 'checkCryopreservedStatusHasMethod'))));
						
		// Configure labels
		$this->widgetSchema->setLabel('sample_id', 'Sample code');
		$this->widgetSchema->setLabel('taxonomic_class_id', 'Class');
		$this->widgetSchema->setLabel('growth_mediums_list', 'Growth mediums');
		
		// Configure help messages
		$this->widgetSchema->setHelp('taxonomic_class_id', 'Taxonomic class');
		$this->widgetSchema->setHelp('genus_id', 'Taxonomic genus');
		$this->widgetSchema->setHelp('species_id', 'Taxonomic species');
		$this->widgetSchema->setHelp('authority_id', 'Taxonomic authority');
		$this->widgetSchema->setHelp('isolation_date', 'Year, month and day');
		$this->widgetSchema->setHelp('identification_date', 'Year, month and day');
		$this->widgetSchema->setHelp('deposition_date', 'Year, month and day');
		$this->widgetSchema->setHelp('observation', 'Notes about strain growth');
		$this->widgetSchema->setHelp('citations', 'Scientific publications where the strain was used');
		$this->widgetSchema->setHelp('new_Pictures', 'Select up to '.($defaultMaxPictures - $actualPictures).' pictures in JPEG, PNG or TIFF format');
  }


	public function checkCryopreservedStatusHasMethod($validator, $values) {
		$cryopreservedStatusId = Doctrine_Core::getTable('MaintenanceStatus')
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
