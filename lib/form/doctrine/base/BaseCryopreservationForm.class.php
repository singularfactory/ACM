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
 * Cryopreservation form base class.
 *
 * @method Cryopreservation getObject() Returns the current form's model object
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
abstract class BaseCryopreservationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'subject'                    => new sfWidgetFormChoice(array('choices' => array('sample' => 'sample', 'strain' => 'strain', 'external_strain' => 'external_strain'))),
      'strain_id'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Strain'), 'add_empty' => true)),
      'sample_id'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'), 'add_empty' => true)),
      'external_strain_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExternalStrain'), 'add_empty' => true)),
      'cryopreservation_method_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CryopreservationMethod'), 'add_empty' => false)),
      'cryopreservation_date'      => new sfWidgetFormDate(),
      'first_replicate'            => new sfWidgetFormInputText(),
      'second_replicate'           => new sfWidgetFormInputText(),
      'third_replicate'            => new sfWidgetFormInputText(),
      'density'                    => new sfWidgetFormInputText(),
      'revival_date'               => new sfWidgetFormDate(),
      'viability'                  => new sfWidgetFormInputCheckbox(),
      'remarks'                    => new sfWidgetFormTextarea(),
      'created_at'                 => new sfWidgetFormDateTime(),
      'updated_at'                 => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'subject'                    => new sfValidatorChoice(array('choices' => array(0 => 'sample', 1 => 'strain', 2 => 'external_strain'), 'required' => false)),
      'strain_id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Strain'), 'required' => false)),
      'sample_id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'), 'required' => false)),
      'external_strain_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ExternalStrain'), 'required' => false)),
      'cryopreservation_method_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CryopreservationMethod'))),
      'cryopreservation_date'      => new sfValidatorDate(),
      'first_replicate'            => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'second_replicate'           => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'third_replicate'            => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'density'                    => new sfValidatorNumber(array('required' => false)),
      'revival_date'               => new sfValidatorDate(array('required' => false)),
      'viability'                  => new sfValidatorBoolean(array('required' => false)),
      'remarks'                    => new sfValidatorString(array('required' => false)),
      'created_at'                 => new sfValidatorDateTime(),
      'updated_at'                 => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('cryopreservation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cryopreservation';
  }

}
