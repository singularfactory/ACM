<?php

/**
 * FieldPicture form base class.
 *
 * @method FieldPicture getObject() Returns the current form's model object
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseFieldPictureForm extends BaseFormDoctrine {
  public function setup() {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'filename'   => new sfWidgetFormInputText(),
      'sample_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'), 'add_empty' => false)),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'filename'   => new sfValidatorString(array('max_length' => 255)),
      'sample_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'))),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('field_picture[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName() {
    return 'FieldPicture';
  }

}
