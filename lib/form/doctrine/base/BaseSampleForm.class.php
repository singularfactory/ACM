<?php

/**
 * Sample form base class.
 *
 * @method Sample getObject() Returns the current form's model object
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSampleForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'notebook_code'    => new sfWidgetFormInputText(),
      'location_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Location'), 'add_empty' => false)),
      'location_details' => new sfWidgetFormInputText(),
      'latitude'         => new sfWidgetFormInputText(),
      'longitude'        => new sfWidgetFormInputText(),
      'environment_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Environment'), 'add_empty' => true)),
      'is_extremophile'  => new sfWidgetFormInputCheckbox(),
      'habitat_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Habitat'), 'add_empty' => true)),
      'ph'               => new sfWidgetFormInputText(),
      'conductivity'     => new sfWidgetFormInputText(),
      'temperature'      => new sfWidgetFormInputText(),
      'salinity'         => new sfWidgetFormInputText(),
      'altitude'         => new sfWidgetFormInputText(),
      'radiation_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Radiation'), 'add_empty' => true)),
      'collection_date'  => new sfWidgetFormDate(),
      'remarks'          => new sfWidgetFormTextarea(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'collectors_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Collector')),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'notebook_code'    => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'location_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Location'))),
      'location_details' => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'latitude'         => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'longitude'        => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'environment_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Environment'), 'required' => false)),
      'is_extremophile'  => new sfValidatorBoolean(array('required' => false)),
      'habitat_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Habitat'), 'required' => false)),
      'ph'               => new sfValidatorNumber(array('required' => false)),
      'conductivity'     => new sfValidatorNumber(array('required' => false)),
      'temperature'      => new sfValidatorNumber(array('required' => false)),
      'salinity'         => new sfValidatorNumber(array('required' => false)),
      'altitude'         => new sfValidatorNumber(array('required' => false)),
      'radiation_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Radiation'), 'required' => false)),
      'collection_date'  => new sfValidatorDate(),
      'remarks'          => new sfValidatorString(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
      'collectors_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Collector', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sample[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Sample';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['collectors_list']))
    {
      $this->setDefault('collectors_list', $this->object->Collectors->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveCollectorsList($con);

    parent::doSave($con);
  }

  public function saveCollectorsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['collectors_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Collectors->getPrimaryKeys();
    $values = $this->getValue('collectors_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Collectors', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Collectors', array_values($link));
    }
  }

}
