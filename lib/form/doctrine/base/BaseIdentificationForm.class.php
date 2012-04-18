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
 * Identification form base class.
 *
 * @method Identification getObject() Returns the current form's model object
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
abstract class BaseIdentificationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'identification_date'       => new sfWidgetFormDate(),
      'sample_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'), 'add_empty' => false)),
      'petitioner'                => new sfWidgetFormInputText(),
      'sample_picture'            => new sfWidgetFormInputText(),
      'microscopy_identification' => new sfWidgetFormTextarea(),
      'molecular_identification'  => new sfWidgetFormTextarea(),
      'request_document'          => new sfWidgetFormInputText(),
      'report_document'           => new sfWidgetFormInputText(),
      'remarks'                   => new sfWidgetFormTextarea(),
      'created_at'                => new sfWidgetFormDateTime(),
      'updated_at'                => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'identification_date'       => new sfValidatorDate(),
      'sample_id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'))),
      'petitioner'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'sample_picture'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'microscopy_identification' => new sfValidatorString(array('required' => false)),
      'molecular_identification'  => new sfValidatorString(array('required' => false)),
      'request_document'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'report_document'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'remarks'                   => new sfValidatorString(array('required' => false)),
      'created_at'                => new sfValidatorDateTime(),
      'updated_at'                => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('identification[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Identification';
  }

}
