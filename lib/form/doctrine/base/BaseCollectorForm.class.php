<?php

/**
 * Collector form base class.
 *
 * @method Collector getObject() Returns the current form's model object
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCollectorForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'name'                 => new sfWidgetFormInputText(),
      'surname'              => new sfWidgetFormInputText(),
      'email'                => new sfWidgetFormInputText(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
      'samples_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Sample')),
      'patent_deposits_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'PatentDeposit')),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                 => new sfValidatorString(array('max_length' => 127)),
      'surname'              => new sfValidatorString(array('max_length' => 127)),
      'email'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'           => new sfValidatorDateTime(),
      'updated_at'           => new sfValidatorDateTime(),
      'samples_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Sample', 'required' => false)),
      'patent_deposits_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'PatentDeposit', 'required' => false)),
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

  }

  protected function doSave($con = null)
  {
    $this->saveSamplesList($con);
    $this->savePatentDepositsList($con);

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

}
