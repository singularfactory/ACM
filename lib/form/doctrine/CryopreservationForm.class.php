<?php

/**
* Cryopreservation form.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class CryopreservationForm extends BaseCryopreservationForm {
	public function configure(){
		// Configure search boxes
		$this->setWidget('sample_id', new sfWidgetFormInputHidden(array('default' => SampleTable::getInstance()->getDefaultSampleId())));
		$this->setWidget('strain_id', new sfWidgetFormInputHidden(array('default' => StrainTable::getInstance()->getDefaultStrainId())));
		$this->setWidget('external_strain_id', new sfWidgetFormInputHidden(array('default' => ExternalStrainTable::getInstance()->getDefaultExternalStrainId())));
		$this->setWidget('subject', new sfWidgetFormChoice(array('choices' => array(
			'sample' => 'sample',
			'strain' => 'strain',
			'external_strain' => 'research collection',
		))));

		// Configure date format
		$lastYear = date('Y');
		for ($i=1990; $i <= $lastYear; $i++) { $years[$i] = $i; }
		$this->setWidget('cryopreservation_date', new sfWidgetFormDate(array('format' => '%year% %month% %day%','years' => $years)));
		$this->setWidget('revival_date', new sfWidgetFormDate(array('format' => '%year% %month% %day%','years' => $years), array('class' => 'noauto')));

		// Configure subject validator
		$this->setValidator('subject', new sfValidatorChoice(array('choices' => array(0 => 'sample', 1 => 'strain', 2 => 'external_strain'), 'required' => false)));

		// Configure a custom post validator to manage changes in isolation_subject
    $this->validatorSchema->setPostValidator( new sfValidatorCallback(array('callback' => array($this, 'cleanFieldsByCryopreservationSubject'))));

		// Configure labels
		$this->widgetSchema->setLabel('sample_id', 'Sample code');
		$this->widgetSchema->setLabel('strain_id', 'Strain code');
		$this->widgetSchema->setLabel('external_strain_id', 'Research collection code');

		// Configure help messages
		$this->widgetSchema->setHelp('subject', 'Choose the type of material requested');
		$this->widgetSchema->setHelp('cryopreservation_date', 'Year, month and day');
		$this->widgetSchema->setHelp('revival_date', 'Year, month and day');
	}

	public function cleanFieldsByCryopreservationSubject($validator, $values) {
		switch( $values['subject'] ) {
			case 'strain':
				$values['sample_id'] = null;
				$values['external_strain_id'] = null;
				if ( empty($values['strain_id']) ) {
					$error = new sfValidatorError($validator, 'You must choose a strain before registering this cryopreservation');
					throw new sfValidatorErrorSchema($validator, array('strain_id' => $error));
				}
				break;

			case 'external_strain':
				$values['sample_id'] = null;
				$values['strain_id'] = null;
				if ( empty($values['external_strain_id']) ) {
					$error = new sfValidatorError($validator, 'You must choose a strain from research collection before registering this cryopreservation');
					throw new sfValidatorErrorSchema($validator, array('strain_id' => $error));
				}
				break;

			case 'sample':
			default:
				$values['strain_id'] = null;
				$values['external_strain_id'] = null;
				if ( empty($values['sample_id']) ) {
					$error = new sfValidatorError($validator, 'You must choose a sample before registering this cryopreservation');
					throw new sfValidatorErrorSchema($validator, array('sample_id' => $error));
				}
				break;
		}

		return $values;
	}
}
