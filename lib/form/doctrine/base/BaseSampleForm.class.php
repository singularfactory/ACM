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
      'id'              => new sfWidgetFormInputHidden(),
      'notebook_code'   => new sfWidgetFormInputText(),
      'location_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Location'), 'add_empty' => false)),
      'latitude'        => new sfWidgetFormInputText(),
      'longitude'       => new sfWidgetFormInputText(),
      'environment_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Environment'), 'add_empty' => false)),
      'is_extremophile' => new sfWidgetFormInputCheckbox(),
      'habitat_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Habitat'), 'add_empty' => false)),
      'ph'              => new sfWidgetFormInputText(),
      'conductivity'    => new sfWidgetFormInputText(),
      'temperature'     => new sfWidgetFormInputText(),
      'salinity'        => new sfWidgetFormInputText(),
      'altitude'        => new sfWidgetFormInputText(),
      'radiation_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Radiation'), 'add_empty' => true)),
      'collector_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Collector'), 'add_empty' => false)),
      'collection_date' => new sfWidgetFormDate(),
      'remarks'         => new sfWidgetFormTextarea(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'notebook_code'   => new sfValidatorInteger(),
      'location_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Location'))),
      'latitude'        => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'longitude'       => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'environment_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Environment'))),
      'is_extremophile' => new sfValidatorBoolean(array('required' => false)),
      'habitat_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Habitat'))),
      'ph'              => new sfValidatorNumber(array('required' => false)),
      'conductivity'    => new sfValidatorNumber(array('required' => false)),
      'temperature'     => new sfValidatorNumber(array('required' => false)),
      'salinity'        => new sfValidatorNumber(array('required' => false)),
      'altitude'        => new sfValidatorNumber(array('required' => false)),
      'radiation_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Radiation'), 'required' => false)),
      'collector_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Collector'))),
      'collection_date' => new sfValidatorDate(),
      'remarks'         => new sfValidatorString(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
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

}
