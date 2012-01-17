<?php

/**
 * Cryopreservation form base class.
 *
 * @method Cryopreservation getObject() Returns the current form's model object
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCryopreservationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'subject'                    => new sfWidgetFormChoice(array('choices' => array('sample' => 'sample', 'strain' => 'strain'))),
      'strain_id'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Strain'), 'add_empty' => true)),
      'sample_id'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'), 'add_empty' => true)),
      'cryopreservation_method_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CryopreservationMethod'), 'add_empty' => false)),
      'cryopreservation_date'      => new sfWidgetFormDate(),
      'first_replicate'            => new sfWidgetFormInputText(),
      'second_replicate'           => new sfWidgetFormInputText(),
      'third_replicate'            => new sfWidgetFormInputText(),
      'density'                    => new sfWidgetFormInputText(),
      'revival_date'               => new sfWidgetFormDate(),
      'viability'                  => new sfWidgetFormInputCheckbox(),
      'remarks'                    => new sfWidgetFormTextarea(),
      'created_at'                 => new sfWidgetFormDateTime(),
      'updated_at'                 => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'subject'                    => new sfValidatorChoice(array('choices' => array(0 => 'sample', 1 => 'strain'), 'required' => false)),
      'strain_id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Strain'), 'required' => false)),
      'sample_id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'), 'required' => false)),
      'cryopreservation_method_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CryopreservationMethod'))),
      'cryopreservation_date'      => new sfValidatorDate(),
      'first_replicate'            => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'second_replicate'           => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'third_replicate'            => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'density'                    => new sfValidatorNumber(array('required' => false)),
      'revival_date'               => new sfValidatorDate(array('required' => false)),
      'viability'                  => new sfValidatorBoolean(array('required' => false)),
      'remarks'                    => new sfValidatorString(array('required' => false)),
      'created_at'                 => new sfValidatorDateTime(),
      'updated_at'                 => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('cryopreservation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cryopreservation';
  }

}
