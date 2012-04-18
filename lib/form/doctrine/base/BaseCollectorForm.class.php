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
 * Collector form base class.
 *
 * @method Collector getObject() Returns the current form's model object
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
abstract class BaseCollectorForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'name'                      => new sfWidgetFormInputText(),
      'surname'                   => new sfWidgetFormInputText(),
      'email'                     => new sfWidgetFormInputText(),
      'created_at'                => new sfWidgetFormDateTime(),
      'updated_at'                => new sfWidgetFormDateTime(),
      'samples_list'              => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Sample')),
      'patent_deposits_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'PatentDeposit')),
      'maintenance_deposits_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'MaintenanceDeposit')),
      'external_strains_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'ExternalStrain')),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                      => new sfValidatorString(array('max_length' => 127)),
      'surname'                   => new sfValidatorString(array('max_length' => 127)),
      'email'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'                => new sfValidatorDateTime(),
      'updated_at'                => new sfValidatorDateTime(),
      'samples_list'              => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Sample', 'required' => false)),
      'patent_deposits_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'PatentDeposit', 'required' => false)),
      'maintenance_deposits_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'MaintenanceDeposit', 'required' => false)),
      'external_strains_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'ExternalStrain', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('collector[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Collector';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['samples_list']))
    {
      $this->setDefault('samples_list', $this->object->Samples->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['patent_deposits_list']))
    {
      $this->setDefault('patent_deposits_list', $this->object->PatentDeposits->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['maintenance_deposits_list']))
    {
      $this->setDefault('maintenance_deposits_list', $this->object->MaintenanceDeposits->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['external_strains_list']))
    {
      $this->setDefault('external_strains_list', $this->object->ExternalStrains->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveSamplesList($con);
    $this->savePatentDepositsList($con);
    $this->saveMaintenanceDepositsList($con);
    $this->saveExternalStrainsList($con);

    parent::doSave($con);
  }

  public function saveSamplesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['samples_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Samples->getPrimaryKeys();
    $values = $this->getValue('samples_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Samples', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Samples', array_values($link));
    }
  }

  public function savePatentDepositsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['patent_deposits_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->PatentDeposits->getPrimaryKeys();
    $values = $this->getValue('patent_deposits_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('PatentDeposits', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('PatentDeposits', array_values($link));
    }
  }

  public function saveMaintenanceDepositsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['maintenance_deposits_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->MaintenanceDeposits->getPrimaryKeys();
    $values = $this->getValue('maintenance_deposits_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('MaintenanceDeposits', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('MaintenanceDeposits', array_values($link));
    }
  }

  public function saveExternalStrainsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['external_strains_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->ExternalStrains->getPrimaryKeys();
    $values = $this->getValue('external_strains_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('ExternalStrains', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('ExternalStrains', array_values($link));
    }
  }

}
