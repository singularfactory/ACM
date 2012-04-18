<?php
/**
 * ArticleForm class
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
 * Article form class.
 *
 * @package ACM.Lib.Form
 * @since 1.0
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
	 */
	public function pictureRadioFormatterCallback($widget, $inputs) {
		$rows = array();
		foreach ($inputs as $input) {
			$rows[] = $widget->renderContentTag('li', $input['input']);
		}

		return !$rows ? '' : $widget->renderContentTag('ul', implode($widget->getOption('separator'), $rows), array('class' => $widget->getOption('class')));
	}

}
