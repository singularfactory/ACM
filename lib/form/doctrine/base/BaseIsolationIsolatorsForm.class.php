<?php

/**
 * IsolationIsolators form base class.
 *
 * @method IsolationIsolators getObject() Returns the current form's model object
 *
 * @package    ACM
 * @subpackage form
 * @author     
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseIsolationIsolatorsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'isolation_id' => new sfWidgetFormInputHidden(),
      'isolator_id'  => new sfWidgetFormInputHidden(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'isolation_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('isolation_id')), 'empty_value' => $this->getObject()->get('isolation_id'), 'required' => false)),
      'isolator_id'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('isolator_id')), 'empty_value' => $this->getObject()->get('isolator_id'), 'required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('isolation_isolators[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'IsolationIsolators';
  }

}
