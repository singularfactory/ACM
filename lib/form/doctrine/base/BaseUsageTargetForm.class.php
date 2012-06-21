<?php

/**
 * UsageTarget form base class.
 *
 * @method UsageTarget getObject() Returns the current form's model object
 *
 * @package    ACM
 * @subpackage form
 * @author     
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUsageTargetForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'name'             => new sfWidgetFormInputText(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'usage_areas_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'UsageArea')),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'             => new sfValidatorString(array('max_length' => 128)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
      'usage_areas_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'UsageArea', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usage_target[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsageTarget';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['usage_areas_list']))
    {
      $this->setDefault('usage_areas_list', $this->object->UsageAreas->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveUsageAreasList($con);

    parent::doSave($con);
  }

  public function saveUsageAreasList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['usage_areas_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->UsageAreas->getPrimaryKeys();
    $values = $this->getValue('usage_areas_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('UsageAreas', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('UsageAreas', array_values($link));
    }
  }

}
