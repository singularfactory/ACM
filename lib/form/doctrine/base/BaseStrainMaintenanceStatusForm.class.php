<?php

/**
 * StrainMaintenanceStatus form base class.
 *
 * @method StrainMaintenanceStatus getObject() Returns the current form's model object
 *
 * @package    ACM
 * @subpackage form
 * @author     
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseStrainMaintenanceStatusForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'strain_id'             => new sfWidgetFormInputHidden(),
      'maintenance_status_id' => new sfWidgetFormInputHidden(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'strain_id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('strain_id')), 'empty_value' => $this->getObject()->get('strain_id'), 'required' => false)),
      'maintenance_status_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('maintenance_status_id')), 'empty_value' => $this->getObject()->get('maintenance_status_id'), 'required' => false)),
      'created_at'            => new sfValidatorDateTime(),
      'updated_at'            => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('strain_maintenance_status[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StrainMaintenanceStatus';
  }

}
