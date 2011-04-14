<?php

/**
* Sample form.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class SampleForm extends BaseSampleForm {
	public function configure() {
		// Configure collection date format
		$lastYear = date('Y');
		for ($i=$lastYear-5; $i <= $lastYear; $i++) { 
			$years[$i] = $i;
		}
		$this->setWidget('collection_date', new sfWidgetFormDate(array(
			'format' => '%year%-%month%-%day%',
			'years' => $years,
		)));
		
		// Configure collector
		$this->setWidget('collector_id', new sfWidgetFormDoctrineChoice(array(
			'model' => $this->getRelatedModelName('Collector'),
			'add_empty' => false)
		));
		
		// Configure picture widgets
		$this->setWidget('field_picture', new sfWidgetFormInputFileEditable(array(
			'file_src' => '',
			'edit_mode' => $this['field_picture']->getValue(),
			'is_image' => true,
			'delete_label' => 'delete',
			'template'  => '%input% <span>%delete% %delete_label%</span>',
		)));
		$this->setWidget('detailed_picture', new sfWidgetFormInputFileEditable(array(
			'file_src' => '',
			'edit_mode' => $this['detailed_picture']->getValue(),
			'is_image' => true,
			'delete_label' => 'delete',
			'template'  => '%input% <span>%delete% %delete_label%</span>',
		)));
		$this->setWidget('microscopic_picture', new sfWidgetFormInputFileEditable(array(
			'file_src' => '',
			'edit_mode' => $this['microscopic_picture']->getValue(),
			'is_image' => true,
			'delete_label' => 'delete',
			'template'  => '%input% <span>%delete% %delete_label%</span>',
		)));
		
		// Configure picture validators
		$this->setValidator('field_picture', new sfValidatorFile(array(
			'max_size' => sfConfig::get('app_max_picture_size'),
			'mime_types' => 'web_images',
			'path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_sample_pictures_dir'),
			'validated_file_class' => 'sfCustomValidatedFile',
			'required' => false,
		)));
		$this->setValidator('field_picture_delete', new sfValidatorBoolean());
		
		$this->setValidator('detailed_picture', new sfValidatorFile(array(
			'max_size' => sfConfig::get('app_max_picture_size'),
			'mime_types' => 'web_images',
			'path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_sample_pictures_dir'),
			'validated_file_class' => 'sfCustomValidatedFile',
			'required' => false,
		)));
		$this->setValidator('detailed_picture_delete', new sfValidatorBoolean());
		
		$this->setValidator('microscopic_picture', new sfValidatorFile(array(
			'max_size' => sfConfig::get('app_max_picture_size'),
			'mime_types' => 'web_images',
			'path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_sample_pictures_dir'),
			'validated_file_class' => 'sfCustomValidatedFile',
			'required' => false,
		)));
		$this->setValidator('microscopic_picture_delete', new sfValidatorBoolean());
		
		// Configure custom validators
		$this->setValidator('latitude', new sfValidatorOr(array(
				new sfValidatorRegex(array('pattern' => '/^\-?\d{1,2}º\d{1,2}\'\d{1,2}("|\'\')$/')),
				new sfValidatorRegex(array('pattern' => '/^\-?\d{1,2}\.\d{1,6}$/')),
				),
				array('required' => false),
				array('invalid' => 'Invalid coordinates format')));
		$this->setValidator('longitude', new sfValidatorOr(array(
				new sfValidatorRegex(array('pattern' => '/^\-?\d{1,2}º\d{1,2}\'\d{1,2}("|\'\')$/')),
				new sfValidatorRegex(array('pattern' => '/^\-?\d{1,2}\.\d{1,6}$/')),
				),
				array('required' => false),
				array('invalid' => 'Invalid coordinates format')));
		$this->setValidator('notebook_code', new sfValidatorInteger(array('required' => true), array(
			'invalid' => 'Only an integer number allowed',
			'required' => 'Provide the notebook code')));
				
		// Configure labels
		$this->widgetSchema->setLabel('ph', 'pH');
		$this->widgetSchema->setLabel('latitude', 'GPS coordinates');
		$this->widgetSchema->setLabel('longitude', 'GPS coordinates');
		
		// Configure help messages
		$this->widgetSchema->setHelp('notebook_code', 'Sample code assigned in collector\'s notebook');
		$this->widgetSchema->setHelp('latitude', 'Latitude and longitude in degrees, minutes and seconds (e.g. 43º23\'23")');
		$this->widgetSchema->setHelp('longitude', 'Degrees, minutes and seconds (e.g. 43º23\'23")');
		$this->widgetSchema->setHelp('ph', 'Decimal value for pH (e.g. 7)');
		$this->widgetSchema->setHelp('conductivity', 'Decimal value for conductivity (e.g 5.5 S/m)');
		$this->widgetSchema->setHelp('temperature', 'Integer value for temperature (e.g 22 ºC)');
		$this->widgetSchema->setHelp('salinity', 'Value for salinity (ppm)');
		$this->widgetSchema->setHelp('altitude', 'Integer value for altitude in meters (e.g. 1595)');
		$this->widgetSchema->setHelp('collection_date', 'Year, month and day');
	}

	/**
	 * Replace two single-quote symbols by a double-quote symbol before saving the form
	 *
	 * @param object $connection
	 * @return void
	 * @author Eliezer Talon
	 * @version 2011-04-14
	 */
	protected function doSave($connection = null) {
		if ( $this->values['latitude'] && preg_match('/\'\'$/', $this->values['latitude']) ) {
			$this->values['latitude'] = str_replace("''", '"', $this->values['latitude']);
		}
		
		if ( $this->values['longitude'] && preg_match('/\'\'$/', $this->values['longitude']) ) {
			$this->values['longitude'] = str_replace("''", '"', $this->values['longitude']);
		}
		
		parent::doSave($connection);
	}

}
