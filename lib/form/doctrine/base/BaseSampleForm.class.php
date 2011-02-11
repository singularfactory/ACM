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
      'id'                 => new sfWidgetFormInputHidden(),
      'number'             => new sfWidgetFormInputText(),
      'ecosystem_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ecosystem'), 'add_empty' => false)),
      'location'           => new sfWidgetFormTextarea(),
      'latitude_degrees'   => new sfWidgetFormInputText(),
      'longitude_degrees'  => new sfWidgetFormInputText(),
      'latitude_minutes'   => new sfWidgetFormInputText(),
      'longitude_minutes'  => new sfWidgetFormInputText(),
      'environment_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Environment'), 'add_empty' => false)),
      'ph'                 => new sfWidgetFormInputText(),
      'conductivity'       => new sfWidgetFormInputText(),
      'temperature'        => new sfWidgetFormInputText(),
      'salinity'           => new sfWidgetFormInputText(),
      'close_picture'      => new sfWidgetFormTextarea(),
      'laboratory_picture' => new sfWidgetFormTextarea(),
      'collector_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Collector'), 'add_empty' => false)),
      'collection_date'    => new sfWidgetFormDateTime(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'number'             => new sfValidatorInteger(),
      'ecosystem_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Ecosystem'))),
      'location'           => new sfValidatorString(),
      'latitude_degrees'   => new sfValidatorInteger(array('required' => false)),
      'longitude_degrees'  => new sfValidatorInteger(array('required' => false)),
      'latitude_minutes'   => new sfValidatorNumber(array('required' => false)),
      'longitude_minutes'  => new sfValidatorNumber(array('required' => false)),
      'environment_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Environment'))),
      'ph'                 => new sfValidatorNumber(array('required' => false)),
      'conductivity'       => new sfValidatorNumber(array('required' => false)),
      'temperature'        => new sfValidatorNumber(array('required' => false)),
      'salinity'           => new sfValidatorNumber(array('required' => false)),
      'close_picture'      => new sfValidatorString(array('required' => false)),
      'laboratory_picture' => new sfValidatorString(array('required' => false)),
      'collector_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Collector'))),
      'collection_date'    => new sfValidatorDateTime(),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Sample', 'column' => array('number')))
    );

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
