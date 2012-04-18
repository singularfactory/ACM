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
 * Project form base class.
 *
 * @method Project getObject() Returns the current form's model object
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
abstract class BaseProjectForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'project_name_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProjectName'), 'add_empty' => false)),
      'petitioner_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Petitioner'), 'add_empty' => false)),
      'subject'            => new sfWidgetFormChoice(array('choices' => array('sample' => 'sample', 'strain' => 'strain', 'external_strain' => 'external_strain'))),
      'strain_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Strain'), 'add_empty' => true)),
      'sample_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'), 'add_empty' => true)),
      'external_strain_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExternalStrain'), 'add_empty' => true)),
      'amount'             => new sfWidgetFormInputText(),
      'provider_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Provider'), 'add_empty' => true)),
      'inoculation_date'   => new sfWidgetFormDate(),
      'purpose'            => new sfWidgetFormTextarea(),
      'delivery_date'      => new sfWidgetFormDate(),
      'remarks'            => new sfWidgetFormTextarea(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'project_name_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ProjectName'))),
      'petitioner_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Petitioner'))),
      'subject'            => new sfValidatorChoice(array('choices' => array(0 => 'sample', 1 => 'strain', 2 => 'external_strain'), 'required' => false)),
      'strain_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Strain'), 'required' => false)),
      'sample_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'), 'required' => false)),
      'external_strain_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ExternalStrain'), 'required' => false)),
      'amount'             => new sfValidatorNumber(array('required' => false)),
      'provider_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Provider'), 'required' => false)),
      'inoculation_date'   => new sfValidatorDate(),
      'purpose'            => new sfValidatorString(),
      'delivery_date'      => new sfValidatorDate(array('required' => false)),
      'remarks'            => new sfValidatorString(array('required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('project[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Project';
  }

}
