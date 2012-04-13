<?php

/**
* Article form class.
*
* @package    bna_green_house
* @subpackage form
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version    2012-04-10
*/
class ArticleForm extends BaseForm {
	public function configure() {
		// Initialize culture media choices
		$strainId = $this->getValue('strain_id') ? $this->getValue('strain_id') : $this->getDefault('strain_id');
		$cultureMedia = CultureMediumTable::getInstance()->createQuery('cm')->leftJoin('cm.Strains s')->where('s.id = ?', $strainId)->execute();
		$cultureMediaChoices = array();
		$cultureMediaValues = array();
		foreach ($cultureMedia as $cultureMedium) {
			$cultureMediaChoices[$cultureMedium->getId()] = $cultureMedium->getName();
			$cultureMediaValues[] = $cultureMedium->getId();
		}

		$this->setWidgets(array(
			'strain_id' => new sfWidgetFormInputHidden(),
			'strain_picture' => new sfWidgetFormSelectRadio(array(
				'choices' => array(), 'formatter' => array($this, 'pictureRadioFormatterCallback')
			)),
			'location_picture' => new sfWidgetFormSelectRadio(array(
				'choices' => array(), 'formatter' => array($this, 'pictureRadioFormatterCallback')
			)),
			'location_picture_source' => new sfWidgetFormInputHidden(),
			'culture_media_list' => new sfWidgetFormChoice(array('choices' => $cultureMediaChoices)),
		));

		$this->setValidators(array(
			'strain_id' => new sfValidatorInteger(array('required' => true)),
			'strain_picture' => new sfValidatorInteger(array('required' => true)),
			'location_picture' => new sfValidatorInteger(array('required' => true)),
			'location_picture_source' => new sfValidatorChoice(array('choices' => array(0 => 'location_picture', 1 => 'field_picture', 2 => 'detailed_picture'), 'required' => true)),
			'culture_media_list' => new sfValidatorChoice(array('choices' => $cultureMediaValues, 'multiple' => false, 'required' => true)),
		));

		$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

		$this->widgetSchema->setLabels(array(
			'strain_id' => 'Strain code',
			'strain_picture' => 'Strain picture',
			'location_picture' => 'Location picture',
			'culture_media_list' => false,
		));

		$this->widgetSchema->setHelps(array(
			'strain_id' => 'First choose the strain the article will refer to',
			'strain_picture' => 'Choose the strain picture that will be displayed',
			'location_picture' => 'Choose the location picture that will be displayed',
		));

		$this->setup();
	}

	/**
	 * Custom formatter for picture selection
	 *
	 * @param sfWidget $widget
	 * @param array $inputs
	 * @return void
	 * @author Eliezer Talón <elitalon@inventiaplus.com>
	 */
	public function pictureRadioFormatterCallback($widget, $inputs) {
		$rows = array();
		foreach ($inputs as $input) {
			$rows[] = $widget->renderContentTag('li', $input['input']);
		}

		return !$rows ? '' : $widget->renderContentTag('ul', implode($widget->getOption('separator'), $rows), array('class' => $widget->getOption('class')));
	}

}
