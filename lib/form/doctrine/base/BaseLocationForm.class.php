<?php

/**
 * Location form base class.
 *
 * @method Location getObject() Returns the current form's model object
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLocationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'name'        => new sfWidgetFormInputText(),
      'category_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'add_empty' => true)),
      'latitude'    => new sfWidgetFormInputText(),
      'longitude'   => new sfWidgetFormInputText(),
      'country_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => false)),
      'region_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Region'), 'add_empty' => false)),
      'island_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Island'), 'add_empty' => true)),
      'remarks'     => new sfWidgetFormTextarea(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'        => new sfValidatorString(array('max_length' => 255)),
      'category_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'required' => false)),
      'latitude'    => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'longitude'   => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'country_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Country'))),
      'region_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Region'))),
      'island_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Island'), 'required' => false)),
      'remarks'     => new sfValidatorString(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('location[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Location';
  }

}
