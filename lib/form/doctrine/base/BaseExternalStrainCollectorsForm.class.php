<?php

/**
 * ExternalStrainCollectors form base class.
 *
 * @method ExternalStrainCollectors getObject() Returns the current form's model object
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseExternalStrainCollectorsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'external_strain_id' => new sfWidgetFormInputHidden(),
      'collector_id'       => new sfWidgetFormInputHidden(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'external_strain_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('external_strain_id')), 'empty_value' => $this->getObject()->get('external_strain_id'), 'required' => false)),
      'collector_id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('collector_id')), 'empty_value' => $this->getObject()->get('collector_id'), 'required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('external_strain_collectors[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ExternalStrainCollectors';
  }

}
