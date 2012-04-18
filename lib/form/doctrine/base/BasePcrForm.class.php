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
 * Pcr form base class.
 *
 * @method Pcr getObject() Returns the current form's model object
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
abstract class BasePcrForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'dna_extraction_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DnaExtraction'), 'add_empty' => false)),
      'forward_dna_primer_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ForwardPrimer'), 'add_empty' => false)),
      'reverse_dna_primer_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ReversePrimer'), 'add_empty' => false)),
      'dna_polymerase_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DnaPolymerase'), 'add_empty' => false)),
      'pcr_program_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PcrProgram'), 'add_empty' => false)),
      'concentration'         => new sfWidgetFormInputText(),
      '260_280_ratio'         => new sfWidgetFormInputText(),
      '260_230_ratio'         => new sfWidgetFormInputText(),
      'can_be_sequenced'      => new sfWidgetFormInputCheckbox(),
      'remarks'               => new sfWidgetFormTextarea(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'dna_extraction_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DnaExtraction'))),
      'forward_dna_primer_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ForwardPrimer'))),
      'reverse_dna_primer_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ReversePrimer'))),
      'dna_polymerase_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DnaPolymerase'))),
      'pcr_program_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('PcrProgram'))),
      'concentration'         => new sfValidatorNumber(array('required' => false)),
      '260_280_ratio'         => new sfValidatorNumber(array('required' => false)),
      '260_230_ratio'         => new sfValidatorNumber(array('required' => false)),
      'can_be_sequenced'      => new sfValidatorBoolean(array('required' => false)),
      'remarks'               => new sfValidatorString(array('required' => false)),
      'created_at'            => new sfValidatorDateTime(),
      'updated_at'            => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('pcr[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Pcr';
  }

}
