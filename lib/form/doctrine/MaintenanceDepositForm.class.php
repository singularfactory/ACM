<?php

/**
* MaintenanceDeposit form.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class MaintenanceDepositForm extends BaseMaintenanceDepositForm {
	
	public function configure() {
		// Configure location
		$this->setWidget('location_id', new sfWidgetFormInputHidden(array('default' => $this->getObject()->getLocation()->getTable()->getDefaultLocationId())));
		
		// Configure date fields
		for ($i=1980; $i <= date('Y'); $i++) { $years[$i] = $i; }
		$dateWidget = new sfWidgetFormDate(array('format' => '%year% %month% %day%', 'years' => $years), array('class' => 'noauto'));
		$this->setWidget('collection_date', $dateWidget);
		$this->setWidget('isolation_date', $dateWidget);
		$this->setWidget('deposition_date', new sfWidgetFormDate(array('format' => '%year% %month% %day%', 'years' => $years)));
		
		// Configure many-to-many relationships
		$this->setWidget('culture_media_list', new sfWidgetFormDoctrineChoice(array(
			'multiple' => true,
			'model' => 'CultureMedium',
			'method' => 'getName',
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
			array('required' => 'The location of the sample is required')));
		
		// Configure a custom post validator for cryopreservation method
    $this->validatorSchema->setPostValidator( new sfValidatorCallback(array('callback' => array($this, 'checkCryopreservedStatusHasMethod'))));
		
		// Configure labels
		$this->widgetSchema->setLabel('taxonomic_class_id', 'Class');
		$this->widgetSchema->setLabel('culture_media_list', 'Culture media');
		$this->widgetSchema->setLabel('transfer_interval', 'Transfer interval (weeks)');
		$this->widgetSchema->setLabel('isolators_list', 'Isolators');
		$this->widgetSchema->setLabel('collectors_list', 'Collectors');
		$this->widgetSchema->setLabel('mf1_link', 'MF1 link');
		
		// Configure help messages
		$this->widgetSchema->setHelp('taxonomic_class_id', 'Taxonomic class');
		$this->widgetSchema->setHelp('genus_id', 'Taxonomic genus');
		$this->widgetSchema->setHelp('species_id', 'Taxonomic species');
		$this->widgetSchema->setHelp('authority_id', 'Taxonomic authority');
		$this->widgetSchema->setHelp('isolation_date', 'Year, month and day');
		$this->widgetSchema->setHelp('new_Relatives', 'Codes used in alternate databases or publications');
		$this->widgetSchema->setHelp('observation', 'Notes about strain culture');
		$this->widgetSchema->setHelp('citations', 'Scientific publications where the strain was used');
		$this->widgetSchema->setHelp('amount', 'Items in stock');
		$this->widgetSchema->setHelp('culture_media_list', 'Culture media available for this strain. Select more than one with Ctrl or Cmd key.');
		$this->widgetSchema->setHelp('isolators_list', 'Isolators of this deposit. Select more than one with Ctrl or Cmd key.');
		$this->widgetSchema->setHelp('collectors_list', 'Collectors of this deposit. Select more than one with Ctrl or Cmd key.');
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
