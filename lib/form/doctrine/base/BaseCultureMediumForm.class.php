<?php

/**
 * CultureMedium form base class.
 *
 * @method CultureMedium getObject() Returns the current form's model object
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCultureMediumForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'name'                      => new sfWidgetFormInputText(),
      'description'               => new sfWidgetFormInputText(),
      'link'                      => new sfWidgetFormTextarea(),
      'is_public'                 => new sfWidgetFormInputCheckbox(),
      'created_at'                => new sfWidgetFormDateTime(),
      'updated_at'                => new sfWidgetFormDateTime(),
      'strains_list'              => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Strain')),
      'external_strains_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'ExternalStrain')),
      'patent_deposits_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'PatentDeposit')),
      'maintenance_deposits_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'MaintenanceDeposit')),
      'isolations_list'           => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Isolation')),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                      => new sfValidatorString(array('max_length' => 255)),
      'description'               => new sfValidatorString(array('max_length' => 255)),
      'link'                      => new sfValidatorString(array('max_length' => 1024)),
      'is_public'                 => new sfValidatorBoolean(array('required' => false)),
      'created_at'                => new sfValidatorDateTime(),
      'updated_at'                => new sfValidatorDateTime(),
      'strains_list'              => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Strain', 'required' => false)),
      'external_strains_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'ExternalStrain', 'required' => false)),
      'patent_deposits_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'PatentDeposit', 'required' => false)),
      'maintenance_deposits_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'MaintenanceDeposit', 'required' => false)),
      'isolations_list'           => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Isolation', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('culture_medium[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CultureMedium';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['strains_list']))
    {
      $this->setDefault('strains_list', $this->object->Strains->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['external_strains_list']))
    {
      $this->setDefault('external_strains_list', $this->object->ExternalStrains->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['patent_deposits_list']))
    {
      $this->setDefault('patent_deposits_list', $this->object->PatentDeposits->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['maintenance_deposits_list']))
    {
      $this->setDefault('maintenance_deposits_list', $this->object->MaintenanceDeposits->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['isolations_list']))
    {
      $this->setDefault('isolations_list', $this->object->Isolations->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveStrainsList($con);
    $this->saveExternalStrainsList($con);
    $this->savePatentDepositsList($con);
    $this->saveMaintenanceDepositsList($con);
    $this->saveIsolationsList($con);

    parent::doSave($con);
  }

  public function saveStrainsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['strains_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Strains->getPrimaryKeys();
    $values = $this->getValue('strains_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Strains', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Strains', array_values($link));
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

  public function saveIsolationsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['isolations_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Isolations->getPrimaryKeys();
    $values = $this->getValue('isolations_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Isolations', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Isolations', array_values($link));
    }
  }

}
