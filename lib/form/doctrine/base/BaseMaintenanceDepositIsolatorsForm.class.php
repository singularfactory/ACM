<?php

/**
 * MaintenanceDepositIsolators form base class.
 *
 * @method MaintenanceDepositIsolators getObject() Returns the current form's model object
 *
 * @package    ACM
 * @subpackage form
 * @author     
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMaintenanceDepositIsolatorsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'maintenance_deposit_id' => new sfWidgetFormInputHidden(),
      'isolator_id'            => new sfWidgetFormInputHidden(),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'maintenance_deposit_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('maintenance_deposit_id')), 'empty_value' => $this->getObject()->get('maintenance_deposit_id'), 'required' => false)),
      'isolator_id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('isolator_id')), 'empty_value' => $this->getObject()->get('isolator_id'), 'required' => false)),
      'created_at'             => new sfValidatorDateTime(),
      'updated_at'             => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('maintenance_deposit_isolators[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MaintenanceDepositIsolators';
  }

}
