<?php

/**
 * DnaConcentration form base class.
 *
 * @method DnaConcentration getObject() Returns the current form's model object
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDnaConcentrationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'amount'        => new sfWidgetFormInputText(),
      '260_280_ratio' => new sfWidgetFormInputText(),
      '260_230_ratio' => new sfWidgetFormInputText(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'amount'        => new sfValidatorNumber(),
      '260_280_ratio' => new sfValidatorNumber(),
      '260_230_ratio' => new sfValidatorNumber(),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('dna_concentration[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DnaConcentration';
  }

}
