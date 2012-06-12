<?php

/**
 * Notification form base class.
 *
 * @method Notification getObject() Returns the current form's model object
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseNotificationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'message'    => new sfWidgetFormTextarea(),
      'status'     => new sfWidgetFormChoice(array('choices' => array('new' => 'new', 'read' => 'read', 'deleted' => 'deleted'))),
      'user_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'message'    => new sfValidatorString(),
      'status'     => new sfValidatorChoice(array('choices' => array(0 => 'new', 1 => 'read', 2 => 'deleted'), 'required' => false)),
      'user_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('notification[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Notification';
  }

}
