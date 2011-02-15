<?php

/**
 * Ecosystem form base class.
 *
 * @method Ecosystem getObject() Returns the current form's model object
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEcosystemForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'name'              => new sfWidgetFormInputText(),
      'latitude_degrees'  => new sfWidgetFormInputText(),
      'longitude_degrees' => new sfWidgetFormInputText(),
      'latitude_minutes'  => new sfWidgetFormInputText(),
      'longitude_minutes' => new sfWidgetFormInputText(),
      'country_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => false)),
      'province_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Province'), 'add_empty' => true)),
      'city'              => new sfWidgetFormInputText(),
      'picture'           => new sfWidgetFormInputText(),
      'remarks'           => new sfWidgetFormTextarea(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'              => new sfValidatorString(array('max_length' => 255)),
      'latitude_degrees'  => new sfValidatorInteger(array('required' => false)),
      'longitude_degrees' => new sfValidatorInteger(array('required' => false)),
      'latitude_minutes'  => new sfValidatorNumber(array('required' => false)),
      'longitude_minutes' => new sfValidatorNumber(array('required' => false)),
      'country_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Country'))),
      'province_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Province'), 'required' => false)),
      'city'              => new sfValidatorString(array('max_length' => 255)),
      'picture'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'remarks'           => new sfValidatorString(array('required' => false)),
      'created_at'        => new sfValidatorDateTime(),
      'updated_at'        => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('ecosystem[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Ecosystem';
  }

}
