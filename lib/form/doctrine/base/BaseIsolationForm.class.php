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
 * Isolation form base class.
 *
 * @method Isolation getObject() Returns the current form's model object
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
abstract class BaseIsolationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'reception_date'         => new sfWidgetFormDate(),
      'isolation_subject'      => new sfWidgetFormChoice(array('choices' => array('sample' => 'sample', 'strain' => 'strain', 'external' => 'external', 'external_strain' => 'external_strain'))),
      'sample_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'), 'add_empty' => true)),
      'strain_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Strain'), 'add_empty' => true)),
      'external_strain_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExternalStrain'), 'add_empty' => true)),
      'external_code'          => new sfWidgetFormInputText(),
      'taxonomic_class_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TaxonomicClass'), 'add_empty' => true)),
      'genus_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Genus'), 'add_empty' => true)),
      'species_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Species'), 'add_empty' => true)),
      'authority_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Authority'), 'add_empty' => true)),
      'location_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Location'), 'add_empty' => true)),
      'environment_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Environment'), 'add_empty' => true)),
      'habitat_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Habitat'), 'add_empty' => true)),
      'delivery_date'          => new sfWidgetFormDate(),
      'purification_method_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PurificationMethod'), 'add_empty' => false)),
      'purification_details'   => new sfWidgetFormTextarea(),
      'observation'            => new sfWidgetFormTextarea(),
      'remarks'                => new sfWidgetFormTextarea(),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
      'isolators_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Isolator')),
      'culture_media_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'CultureMedium')),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'reception_date'         => new sfValidatorDate(),
      'isolation_subject'      => new sfValidatorChoice(array('choices' => array(0 => 'sample', 1 => 'strain', 2 => 'external', 3 => 'external_strain'), 'required' => false)),
      'sample_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'), 'required' => false)),
      'strain_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Strain'), 'required' => false)),
      'external_strain_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ExternalStrain'), 'required' => false)),
      'external_code'          => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'taxonomic_class_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TaxonomicClass'), 'required' => false)),
      'genus_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Genus'), 'required' => false)),
      'species_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Species'), 'required' => false)),
      'authority_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Authority'), 'required' => false)),
      'location_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Location'), 'required' => false)),
      'environment_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Environment'), 'required' => false)),
      'habitat_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Habitat'), 'required' => false)),
      'delivery_date'          => new sfValidatorDate(array('required' => false)),
      'purification_method_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('PurificationMethod'))),
      'purification_details'   => new sfValidatorString(array('required' => false)),
      'observation'            => new sfValidatorString(array('required' => false)),
      'remarks'                => new sfValidatorString(array('required' => false)),
      'created_at'             => new sfValidatorDateTime(),
      'updated_at'             => new sfValidatorDateTime(),
      'isolators_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Isolator', 'required' => false)),
      'culture_media_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'CultureMedium', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('isolation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Isolation';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['isolators_list']))
    {
      $this->setDefault('isolators_list', $this->object->Isolators->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['culture_media_list']))
    {
      $this->setDefault('culture_media_list', $this->object->CultureMedia->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveIsolatorsList($con);
    $this->saveCultureMediaList($con);

    parent::doSave($con);
  }

  public function saveIsolatorsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['isolators_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Isolators->getPrimaryKeys();
    $values = $this->getValue('isolators_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Isolators', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Isolators', array_values($link));
    }
  }

  public function saveCultureMediaList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['culture_media_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->CultureMedia->getPrimaryKeys();
    $values = $this->getValue('culture_media_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('CultureMedia', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('CultureMedia', array_values($link));
    }
  }

}
