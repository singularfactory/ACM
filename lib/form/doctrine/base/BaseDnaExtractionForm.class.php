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
 * DnaExtraction form base class.
 *
 * @method DnaExtraction getObject() Returns the current form's model object
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
abstract class BaseDnaExtractionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'strain_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Strain'), 'add_empty' => false)),
      'is_public'         => new sfWidgetFormInputCheckbox(),
      'arrival_date'      => new sfWidgetFormDate(),
      'extraction_date'   => new sfWidgetFormDate(),
      'extraction_kit_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExtractionKit'), 'add_empty' => false)),
      'concentration'     => new sfWidgetFormInputText(),
      '260_280_ratio'     => new sfWidgetFormInputText(),
      '260_230_ratio'     => new sfWidgetFormInputText(),
      'aliquots'          => new sfWidgetFormInputText(),
      'genbank_link'      => new sfWidgetFormInputText(),
      'remarks'           => new sfWidgetFormTextarea(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'strain_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Strain'))),
      'is_public'         => new sfValidatorBoolean(array('required' => false)),
      'arrival_date'      => new sfValidatorDate(),
      'extraction_date'   => new sfValidatorDate(array('required' => false)),
      'extraction_kit_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ExtractionKit'))),
      'concentration'     => new sfValidatorNumber(array('required' => false)),
      '260_280_ratio'     => new sfValidatorNumber(array('required' => false)),
      '260_230_ratio'     => new sfValidatorNumber(array('required' => false)),
      'aliquots'          => new sfValidatorInteger(array('required' => false)),
      'genbank_link'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'remarks'           => new sfValidatorString(array('required' => false)),
      'created_at'        => new sfValidatorDateTime(),
      'updated_at'        => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('dna_extraction[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DnaExtraction';
  }

}
